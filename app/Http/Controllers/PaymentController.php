<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Payment;
use App\Models\Order;

use App\Services\GetData;
use App\Services\InsertPayment;

class PaymentController extends Controller
{

    protected $checkCredits, $insertPayment;

    public function __construct(GetData $checkCredits, InsertPayment $insertPayment)
    {
        $this->checkCredits = $checkCredits;
        $this->insertPayment = $insertPayment;
    }

    public function getPayments(Request $request){

        try{

            $params = [

                'professional_id' => !empty($request->input('professional_id')) ? $request->input('professional_id') : null,
                'distributor_id' => !empty($request->input('distributor_id')) ? $request->input('distributor_id') : null,
                'status' => !empty($request->input('status')) ? $request->input('status') : null,
            ];

            $payments = Payment::getPayments($params);

            // $payments = Payment::whereNotIn('payment', ["order", "refund"])->get();

            // foreach ($payments as $payment){
            //     $payment->professional;
            //     $payment->distributor;
            // }

            return api_response_true($payments, "Payments retrieved successfully");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener los pagos");
            
        }

    }

    public function getPayment(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;        

            $payment = Payment::find($id);

            if(!empty($payment)){
                return api_response_true($payment, "Payment retrieved successfully");
            }else{
                throw new Exception("Payment ID not found");
            }

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener el pago");
            
        }
    }

    public function postPayment(Request $request){

        try{

            $paramsPayment = [
                'credits' => !empty($request->input('credits')) ? $request->input('credits') : null,
                'payment' => !empty($request->input('payment')) ? $request->input('payment') : null,
                'status' => !empty($request->input('status')) ? $request->input('status') : null,
                'order_id' => !empty($request->input('order_id')) ? $request->input('order_id') : null,
                'professional_id' => !empty($request->input('professional_id')) ? $request->input('professional_id') : null,
                'distributor_id' => !empty($request->input('distributor_id')) ? $request->input('distributor_id') : null
            ];
            
            if($paramsPayment["professional_id"] == null && $paramsPayment["distributor_id"] == null){
                throw new Exception("Professional or Distributor ID not found");
            }

            if($paramsPayment["professional_id"] != null && !$professional = Professional::checkProfessional($paramsPayment['professional_id']))
                throw new Exception("Professional ID not found");

            if($paramsPayment["distributor_id"] != null && !$distributor = Distributor::checkDistributor($paramsPayment['distributor_id']))
                throw new Exception("Distributor ID not found");
   
            $dataParam = Payment::validatePayment($paramsPayment);

            if(!$payment = $dataParam["data"])
                throw new Exception($dataParam["message"]);

            // From Wordpress we receive the payment data
            $insertPaymentData = $this->insertPayment->insertPayment($payment);

            if(!$insertPaymentData["success"])
                throw new Exception($insertPaymentData["message"]);

            return api_response_true($insertPaymentData["data"], $insertPaymentData["message"]);

        }catch(Exception $e){

            return api_response_false($e, "Error al crear el pago");
            
        }
         
    }

    public function updatePayment(Request $request){

        try{

            // Fields on Payment
            $id = !empty($request->input('id')) ? $request->input('id') : null;
            $status = !empty($request->input('status')) ? $request->input('status') : null;

            // if any input is empty return error
            if(empty($id) || empty($status))
                throw new Exception($insertPaymentData["Some inputs are empty"]);

            // Check if Payment exists
            if(empty($payment = Payment::checkPayment($id)))     
                throw new Exception($insertPaymentData["Payment ID not found"]); 

            // update
            // No tiene validación de estado "correcto"
            $payment->status = $status;

            $payment->save();
        
            return api_response_true($payment, "Pago actualizado correctamente");

        }catch(Exception $e){

            return api_response_false($e, "Error al editar el pago");
            
        }

    } 

    public function refundPayment(Request $request){

        try{

            // Fields on Payment
            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if(!$order = Order::checkOrder($id))
                throw new Exception($insertPaymentData["Order ID not found"]); 

            $refoundOrder = $this->insertPayment->refoundOrder($order);

            if(!$refoundOrder["success"])
                throw new Exception($refoundOrder["message"]);

            return api_response_true($refoundOrder["data"], $refoundOrder["message"]);

        }catch(Exception $e){

            return api_response_false($e, "Error el devolver el pago");
            
        }


    }
}
