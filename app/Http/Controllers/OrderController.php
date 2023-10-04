<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Professional;
use App\Models\Technical;

use App\Services\GetData;
use App\Services\InsertPayment;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getOrders(){

        try{

            $orders = Order::all();

            foreach ($orders as $order)
                $order->payments;

            return api_response_true($orders, 'Orders retrieved successfully');

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener las ordenes");
            
        }

    }

    public function getOrder(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            $order = Order::find($id);

            if($order != null)
                $order->payments;

            if(empty($order))
                throw new Exception("Order ID not found");

            return api_response_true($order, 'Order retrieved successfully');

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener la orden");
            
        }
    }

    public function getOrdersByProfessional(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if($professional = Professional::checkProfessional($id)){

                $orders = $professional->orders;
                // $orders = $professional->orders->sortByDesc('created_at');

                foreach ($orders as $order)
                    $order->payments;

                return api_response_true($orders, 'Professional orders');

            }else{
                throw new Exception("Professional ID not found");
            }

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener las ordenes del profesional");
            
        }
    }    
    
    public function postOrder(Request $request){

        try{

            $paramsPayment = [
                'credits' => !empty($request->input('credits')) ? $request->input('credits') : null,
                'payment' => !empty($request->input('payment')) ? $request->input('payment') : null,
                'status' => !empty($request->input('status')) ? $request->input('status') : null,
                'order_id' => !empty($request->input('order_id')) ? $request->input('order_id') : null,
                'professional_id' => !empty($request->input('professional_id')) ? $request->input('professional_id') : null
            ];
            
            $paramsOrder = [
                'type' => !empty($request->input('type')) ? $request->input('type') : null,
                'model' => !empty($request->input('model')) ? $request->input('model') : null,
                'veh_type' => !empty($request->input('veh_type')) ? $request->input('veh_type') : null,
                'manufacture' => !empty($request->input('manufacture')) ? $request->input('manufacture') : null,
                'year' => !empty($request->input('year')) ? $request->input('year') : null,
                'fuel' => !empty($request->input('fuel')) ? $request->input('fuel') : null,
                'kw' => !empty($request->input('kw')) ? (float)$request->input('kw') : null,
                'emission' => !empty($request->input('emission')) ? $request->input('emission') : null, // En api listapp "normative"
                'options' => !empty($request->input('options')) ? $request->input('options') : null,
                'notes' => !empty($request->input('notes')) ? $request->input('notes') : null,
                'professional_file' => !empty($request->input('professional_file')) ? $request->input('professional_file') : null,
                'shw_file' => !empty($request->input('shw_file')) ? $request->input('shw_file') : null,
                'order_id' => !empty($request->input('order_id')) ? $request->input('order_id') : null,
                'professional_id' => !empty($request->input('professional_id')) ? $request->input('professional_id') : null,
            ];
            
            if(!$professional = Professional::checkProfessional($paramsOrder['professional_id']))
                throw new Exception("Professional ID not found");

            $dataParam = Payment::validatePayment($paramsPayment);

            if(!$payment = $dataParam["data"])
                throw new Exception($dataParam["message"]);

            $dataOrder = Order::validateOrder($paramsOrder);

            if(!$order = $dataOrder["data"])
                throw new Exception($dataOrder["message"]);       

            $insertPayment = new InsertPayment();
            $insertPaymentRes =  $insertPayment->insertPayment($payment, $order);
            
            if(!$insertPaymentRes["success"])
                throw new Exception($insertPaymentRes["message"]);
        
            return api_response_true($insertPaymentRes['data'], 'Orden Creada');

        }catch(Exception $e){

            return api_response_false($e, "Error al crear la orden");
            
        }

    }

    public function updateOrderStatus(Request $request){

        try{

            $params = [
                'id' => !empty($request->input('id')) ? $request->input('id') : null,
                'status' => !empty($request->input('status')) ? $request->input('status') : null,
                'technical_notes' => !empty($request->input('technical_notes')) ? $request->input('technical_notes') : null
            ];

            $technical_id = !empty($request->input('technical_id')) ? $request->input('technical_id') : null;

            if(!Technical::checkTechnical($technical_id))
                throw new Exception('Technical ID not found');

            $orderData = Order::updateStatus($params, $technical_id);

            if($orderData["data"])   
                return api_response_true($orderData["data"], 'Orden actualizad con exito');
            else
                throw new Exception($orderData["message"]);  
    
        }catch(Exception $e){

            return api_response_false($e, "Error al actualizar el estado de la orden");
            
        }

    }

    public function fileUploadFPF(Request $request){

        try{

            $contents = file_get_contents($request->file_data->path());

            Storage::disk('local')->put($request->professional_id .'/'. $request->file_name, $contents);

            return api_response_true([], 'Archivo subido con exito');
        
        }catch(Exception $e){

            return api_response_false($e, "Error al subir el archivo");
            
        }

    }

    
    public function fileDownloadFPF(Request $request){

        try{

            $file = Storage::disk('local')->get($request->professional_id .'/'. $request->file_name);

            return response($file, 200)->header('Content-Type', 'application/fpf');
        
        }catch(Exception $e){

            return api_response_false($e, "Error al descargar el archivo");
            
        }

    }

}
