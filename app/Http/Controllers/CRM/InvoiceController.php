<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Services\EmailConfig;

use App\Models\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Task;

use PDF;
use File;

class InvoiceController extends Controller
{
    public function getInvoices(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:user,id',
            'customer_id' => 'nullable|exists:customer,id',          
            'contact_id' => 'nullable|exists:contact,id',           
            'state' => 'nullable|exists:state,id',  
            ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];        

        if($request->has('user_id'))
            $invoices = Invoice::where('user_id', $request->input('user_id'))->get();
        else if($request->has('customer_id'))
            $invoices = Invoice::where('customer_id', $request->input('customer_id'))->get();
        else if($request->has('lead_id'))
            $invoices = Invoice::where('lead_id', $request->input('lead_id'))->get();
        else if($request->has('contact_id'))
            $invoices = Invoice::where('contact_id', $request->input('contact_id'))->get();
        else if($request->has('state'))
            $invoices = Invoice::where('state', $request->input('state'))->get();
        else
            $invoices = Invoice::all();

        foreach($invoices as $invoice){
            $invoice->user;
            $invoice->contact;
            $invoice->customer;
        }

        return ['data' => $invoices, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
    }

    public function getInvoice(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($invoice = Invoice::checkInvoice($id)){

            $invoice->user;
            $invoice->customer;
            $invoice->contact;

            return ['data' => $invoice, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
    }    

    public function postInvoice(Request $request){
    
        $states = ['on_hold', 'cancelled', 'approved'];
        $payments = ['transfer', 'credit_card', 'paypal', 'bank_draft'];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'unique:customer,id,'.$request->customer_id,            
            'contact_id' => 'required|unique:contact,id,'.$request->contact_id,            
            'state' => 'required|in:'.implode(',', $states),
            'discount' => 'required|integer|between:0,100',
            'payment' => 'required|in:'.implode(',', $payments),
            'iva' => 'required||integer|between:0,100',
            'code' => 'required',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',     
            'finished_at' => 'required|date',     
            'product_id' => 'required|array',   
            'product_id.*' => 'required|exists:product,id',   
            'product_price' => 'required|array',   
            'product_price.*' => 'required|numeric|min:0',             
            'product_quantity' => 'required|array',   
            'product_quantity.*' => 'required|integer|min:1',               
            'product_discount' => 'required|array',               
            'product_discount.*' => 'required|integer|between:0,100',             
            ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];

        if(!$user = User::checkUser($request->user_id))
            return ['data' => null, 'success' => false, 'message_log' => 'User Not found', 'message' => 'User No encontrado'];

        $countProducts = count((array)$request->product_id);

        if($countProducts != count((array)$request->product_quantity) || $countProducts != count((array)$request->product_discount))
            return ['data' => null, 'success' => false, 'message_log' => 'Different length on products', 'message' => 'Tamaños distintos en productos'];

        if($request->customer_id && $customer = Customer::checkCustomer($request->customer_id)){

            $contact = $customer->contacts->find($request->contact_id);

            if(!$contact)
                return ['data' => null, 'success' => false, 'message_log' => 'Contact Not found', 'message' => 'Contacto No encontrado'];

            $invoice = new Invoice();
            $invoice->user_id = $user->id;
            $invoice->customer_id = $customer->id;
            $invoice->contact_id = $contact->id;
            $invoice->state = $request->state;
            $invoice->discount = $request->discount;
            $invoice->payment = $request->payment;
            $invoice->iva = $request->iva;
            $invoice->code = $request->code;
            $invoice->observations = $request->observations;
            $invoice->finished_at = $request->finished_at;
            $invoice->save();

            $subtotal = 0;

            for($i = 0; $i < $countProducts; $i++){
                $product = Product::find($request->product_id[$i]);
                $subtotalProduct = round(($request->product_price[$i] - $request->product_price[$i] * ($request->product_discount[$i]/100)) * $request->product_quantity[$i], 2);
                $totalProduct = round($subtotalProduct + ($subtotalProduct * ($request->iva/100)), 2);
                $subtotal += $subtotalProduct;
                $invoice->products()->attach($product->id, ['quantity' => $request->product_quantity[$i], 'price' => $request->product_price[$i], 'discount' => $request->product_discount[$i], 'subtotal' => $subtotalProduct, 'total' => $totalProduct]);
            }

            $invoice->subtotal = round($subtotal - $subtotal * $request->discount/100, 2);
            $total = $invoice->subtotal + $invoice->subtotal * $request->iva/100;
            $invoice->total = round($total, 2);
            $invoice->save();

            switch($invoice->payment){
                case 'transfer':
                    $invoice->payment_translate = 'Transferencia';
                    break;
                case 'credit_card':
                    $invoice->payment_translate = 'Tarjeta de crédito';
                    break;
                case 'paypal':
                    $invoice->payment_translate = 'Paypal';
                    break;
                case 'bank_draft':
                    $invoice->payment_translate = 'Giro Bancario';
                    break;
                default:
                    $invoice->payment_translate = 'No concretado';
                    break;
            }  
            
            // data for pdf view
            $data = [

                'title' => 'Presupuesto',
                'date' => date('m/d/Y'),
                'products' => $invoice->products,
                'invoice' => $invoice,
                'customer' => $customer,
                'contact' => $contact
    
            ];   
            
            // Get pdf and save on Storage local disk
            $pdf = PDF::loadView('layout', $data);
            $pdfDownload = $pdf->download($invoice->code);
            Storage::disk('local')->put('invoices' . '/' . $invoice->code . '.pdf', $pdfDownload . '.pdf');

            return ['data' => $invoice, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
            
    }

    public function putInvoice(Request $request){

        $states = ['on_hold', 'cancelled', 'approved'];

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'state' => 'required|in:'.implode(',', $states),           
            ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];        

        if(!$invoice = Invoice::checkInvoice($request->id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];   
            
        $invoice->state = $request->state;
        $invoice->save();

        $invoice->technical;
        $invoice->lead;
        $invoice->contact;
        $invoice->customer;

        return ['data' => $invoice, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

    }

    public function viewPdf(Request $request){

        $code = $request->code ? $request->code : null;

        // check if file exists on storage local disk
        if(!Storage::disk('local')->exists('invoices/' . $code . '.pdf'))
            return ['data' => null, 'success' => false, 'message_log' => 'File not found', 'message' => 'Archivo no encontrado'];

        $path = storage_path('app/invoices/' . $code . '.pdf');
        $file = $code . '.pdf';

        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file . '"'
          ];

        return response()->file($path, $header);
        // return PDF::loadView('test', $response);
    }   

    public function viewPdfTest(Request $request){

        $invoice = Invoice::find(59);
        $lead = $invoice->lead;

        // data for pdf view
        $data = [

            'title' => 'Presupuesto',
            'date' => date('m/d/Y'),
            'products' => $invoice->products,
            'invoice' => $invoice,
            'customer' => $lead,
            'contact' => $lead->contacts->where('position', 'Company')->first()

        ];  
        $pdf = PDF::loadView('layout', $data);
        return $pdf->stream('test.pdf', array("Attachment" => false));
        // return $pdf->download('test.pdf');
    }     
    
    public function sendEmail(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$invoice = Invoice::checkInvoice($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
            
        $user = $invoice->user;
        $email = $user->email;
        $email_to = $invoice->contact->email;

        if(!$email || !$email_to)
            return ['data' => null, 'success' => false, 'message_log' => 'Email not found', 'message' => 'Email no encontrado'];

        $emailConfig = new EmailConfig();
        if(!$emailConfig->putConfig($user, $email, $email_to, $attachment = 'invoices/' . $invoice->code . '.pdf'))
            return ['data' => null, 'success' => false, 'message_log' => 'Not sent', 'message' => 'No enviado'];

        return ['data' => $invoice, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

    }
}
