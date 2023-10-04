<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Lead;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Interest;
use App\Models\Competitor;

use App\Services\CRM\ReadCSV;
use Exception;

class CustomerController extends Controller
{
    public function getCustomers(Request $request){


        if($request->has('type'))
            $customers = Customer::where('type', $request->type)->get();
        else
            $customers = Customer::all();

        foreach($customers as $customer){
            $customer->contacts;
            $customer->interests;
            $customer->competitors;
        }

        return ['data' => $customers, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
    }

    public function getCustomer(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($customer = Customer::checkCustomer($id)){

            $customer->contacts;
            $customer->interests;
            $customer->competitors;
            // $customer->products()->attach('0000ada2-05c5-4df9-8fed-5aa7aa0fe158', ['discount' => 30]);
            $customer->products;

            return ['data' => $customer, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
    } 

    public function postCustomer(Request $request){
    
        /* ONLY LEAD TYPE */

        $validator = Validator::make($request->all(), [
            'tax_number' => 'unique:customer|max:15',
            'pc' => 'max:15',
            'name' => 'required|unique:customer,name',
            'legal_representative_name' => 'unique:customer,legal_representative_name',
            'email' => 'unique:customer|email',
            'interests' => 'array',  
            'competitions' => 'array',  
        ]);

        if ($validator->fails())
        return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $request->request->add(['active' => true]);
        $request->request->add(['commercial_name' => $request->name]);
        $request->request->add(['type' => 'lead']);

        $customer = Customer::create($request->all());

        /* Interests */

        if(!empty($request->interests)){
            
            $interests = Interest::whereIn('name', $request->interests)->get();
            $customer->interests()->saveMany($interests);
        }

        /* Competitors */

        if(!empty($request->competitors)){
            
            $competitors = Competitor::whereIn('name', $request->competitors)->get();
            $customer->competitors()->saveMany($competitors);
        }        

        $customer->contacts;
        $customer->interests;
        $customer->competitors;

        return ['data' => $customer, 'success' => true, 'message_log' => 'Lead created', 'message' => 'Lead creado'];
            
    } 
    
    public function postContactCustomer(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:customer',
            'name' => 'required|unique:contact,name',
            'email' => 'unique:contact,email|email'
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];

        $customer = Customer::find($request->id);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = $request->position;
        $contact->channel = $request->channel;
        $contact->observations = $request->observations;

        $customer->contacts()->save($contact); 

        return ['data' => $contact, 'success' => true, 'message_log' => 'Contact created', 'message' => 'Contacto creado'];
        
    }    

    public function putCustomer(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$customer = Customer::checkCustomer($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('customer', 'name')->ignore($customer->id),
            ],
            'legal_representative_name' => [
                'nullable',
                'string',
                Rule::unique('customer', 'legal_representative_name')->ignore($customer->id),
            ],            
            'tax_number' => [
                'nullable',
                'max:15',
                Rule::unique('customer', 'tax_number')->ignore($customer->id),
            ],
            'pc' => 'nullable|max:15',
            'email' => [
                'nullable',
                'email',
                Rule::unique('customer', 'email')->ignore($customer->id),
            ],            
            'interests' => 'array',  
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $customer->name = $request->name;
        $customer->commercial_name = $request->name;
        $customer->legal_representative_name = $request->legal_representative_name;
        $customer->email = $request->email;
        $customer->tax_number = $request->tax_number;
        $customer->notes = $request->notes;        
        $customer->country = $request->country;
        $customer->province = $request->province;
        $customer->city = $request->city;
        $customer->address = $request->address;
        $customer->pc = $request->pc;
        $customer->phone = $request->phone;
        $customer->acquisition = $request->acquisition;

        $customer->save();
        
        /* Interests */

        // delete all customer interests
        $customer->interests()->detach();
        $customer->save();

        if(!empty($request->interests)){
            
            $interests = Interest::whereIn('name', $request->interests)->get();
            $customer->interests()->saveMany($interests);
        }

        $customer->contacts;
        $customer->interests;

        return ['data' => $customer, 'success' => true, 'message_log' => 'customer created', 'message' => 'customer creado'];

    }    

    public function putContact(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$contact = Contact::checkcontact($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];    

        if($contact->customer->type != 'lead')
            return ['data' => null, 'success' => false, 'message_log' => 'Not lead', 'message' => 'No es un lead'];

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('contact', 'name')->ignore($contact->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contact', 'email')->ignore($contact->id),
            ],            
            'phone' => [
                'nullable',
                'max:12',
                Rule::unique('contact', 'phone')->ignore($contact->id),
            ]
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
    
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = $request->position;
        $contact->channel = $request->channel;        
        $contact->observations = $request->observations;

        $contact->save();
        
        $contact->lead;

        return ['data' => $contact, 'success' => true, 'message_log' => 'contact created', 'message' => 'contact creado'];

    }  
    
    public function getCustomerProduct(Request $request){

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customer,id',
            'product_id' => 'required|exists:product,id',
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
            
        $customer = Customer::find($request->customer_id);
        $product = $customer->products()->find($request->product_id);

        if(!$product){
            
            $product = Product::find($request->product_id);
            $data = array("price" => $product->price, "discount" => 0, "active" => true);

        }else

            $data = array("price" => $product->pivot->price, "discount" => $product->pivot->discount, "active" => $product->pivot->active);

        return ['data' => $data, 'success' => true, 'message_log' => 'chido', 'message' => 'chido'];

    }
    
    public function deleteCustomer(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($customer = Customer::checkCustomer($id)){

            $invoices = $customer->invoices;

            foreach ($invoices as $invoice)
                $invoice->products()->detach();

            $customer->tasks()->delete();
            $customer->invoices()->delete();
            $customer->contacts()->delete();
            $customer->interests()->detach();
            $customer->competitors()->detach();
            $customer->delete();

            return ['data' => true, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
                    
    }

    public function importCSV(Request $request){

        $csvFileName = $request->csv;
        $csvFile = public_path('csv/' . $csvFileName);
        $csvArray = ReadCSV::readCSV($csvFile, array('delimiter' => ','));
                
        $products = [];

        for ($i=0; $i < count($csvArray[1]); $i++) { 

            if($csvArray[1][$i]){

                $customer = Customer::where('tax_number', (string)$csvArray[1][$i])->first();
                $customer->products()->detach();
                          
                try{
                    $taxNumber = $csvArray[1][$i];
    
                }catch(Exception $e){
    
                    return $taxNumber;
                }

                for ($j=2; $j < count($csvArray) - 1; $j++) { 

                    try{
                        $code = $csvArray[$j][1];
        
                    }catch(Exception $e){
        
                        return $code;
                    }

                    $product = Product::where('code', $code)->first();

                    if($product && ($csvArray[$j][$i] == "NO lo pueden comprar" || $csvArray[$j][$i] == "NO APLICA a estos clientes"))

                        $customer->products()->attach($product->id, ['price' => 0, 'discount' => 0, 'active' => false]);
                        // $products2 [] = $code;

                    else if($product && (int)$csvArray[$j][$i] >= 0 && (float)$csvArray[$j][2] > 0)

                        // $products2 [] = $code;
                        $customer->products()->attach($product->id, ['price' => (float)$csvArray[$j][2], 'discount' => (int)$csvArray[$j][$i], 'active' => true]);

                    else

                        $products []= (float)$csvArray[$j][2];

                }

            }

        }

        return $products;
    }
}
