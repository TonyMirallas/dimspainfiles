<?php
namespace App\Services;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Payment;
use App\Models\Order;

use App\Services\GetData;
use App\Services\ShadowFiles;

class InsertPayment
{
    public function insertPayment(Payment $payment, Order $order = null){

        // Check for who is the payment
        if($payment->professional_id != null){

            if(!$client = Professional::checkProfessional($payment->professional_id))
                return ["data" => false, "success" => false, "message_log" => "Professional ID not found", "message" => "Order payment already refunded"];

        }
        else if($payment->distributor_id != null){

            if(!$client = Distributor::checkDistributor($payment->distributor_id))
                return ["data" => false, "success" => false, "message_log" => "Distributor ID not found", "message" => "Order payment already refunded"];

        }else
            return ["data" => false, "success" => false, "message_log" => "No Professional or Distributor ID", "message" => "Order payment already refunded"];

        // Check if client has enough credits
        $checkCredits = new GetData();
        $credits = $checkCredits->getCredits($client);

        if($order != null){

            // Validate order (COMING SOON)

            // Get order credits costs
            // $orderCredits = 0;

            if($payment->credits < 0 && $credits + $payment->credits < 0)
                return ["data" => false, "success" => false, "message_log" => "No tenes plata", "message" => "Order payment already refunded"];

            $shadowFiles = new ShadowFiles();

            $shadowFiles->moveFile($order->shw_file, $client);

            $order->status = "Pendiente";
            $order->save();

            $payment->order_id = $order->id;
        }

        if($payment->credits < 0 && 0 < $credits && $credits < $payment->credits)
            return ["data" => false, "success" => false, "message_log" => "Order payment already refunded", "message" => "No tenes plata"];

        $payment->save();

        return ["data" => true, "success" => true, "message_log" => "Payment inserted", "message" => "Pago insertado"];
    }

    public function refoundOrder(Order $order){

        if(!in_array($order->status, ["En Proceso", "Completado"]))
            return ["data" => false, "success" => false, "message_log" => "Order status not in [En Proceso, Completado]", "message" => "Estado de Orden incorrecto"];

        $payments = $order->payments;

        // Look for order payment
        foreach($payments as $payment){

            if($payment->payment == "refund")
                return ["data" => false, "success" => false, "message_log" => "Order payment already refunded", "message" => "Orden ya devuelta"];

            if($payment->payment == "order")
                $paymentOrder = $payment;
        }

        if(!isset($paymentOrder))
            return ["data" => false, "success" => false, "message_log" => "Order payment not found", "message" => "Pago de la orden no encontrado"];

        $params = [
            "order_id" => $order->id,
            "credits" => $paymentOrder->credits * (-1),
            "payment" => "refund",
            "professional_id" => $paymentOrder->professional_id,
            "status" => "Completed"
        ];
 
        $payment = new Payment($params);
        $data = $this->insertPayment($payment);

        if(!$data["success"])
        $data;

        $order->status = "Devolución";
        $order->save();

        return ["data" => $payment, "success" => true, "message_log" => "Order refounded", "message" => "Orden devuelta"];
    }
}