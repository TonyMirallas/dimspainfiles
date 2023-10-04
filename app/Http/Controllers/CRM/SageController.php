<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Customer;

use App\Services\SageAPI;

class SageController extends Controller
{

    public function health(Request $request){

        return SageAPI::checkHealth();

    }

    public function customers(Request $request){

        $skip = !empty($request->input('skip')) ? $request->input('skip') : null;

        $url = "Customers";

        $params = [
            'url' => $url,
            'skip' => $skip
        ];

        $response = SageAPI::getAll($params);

        if($response['success']){

            $customers = $response['data'];

            foreach($customers as $customer){

                // save $product into new Product

                $newCustomer = Customer::find($customer->Id);

                if(!$newCustomer){
                    $newCustomer = new Customer;
                    $newCustomer->id = $customer->Id;
                }

                $newCustomer->company_id = $customer->CompanyId;
                $newCustomer->name = $customer->Name;
                $newCustomer->commercial_name = $customer->CommercialName;
                $newCustomer->code = $customer->Code;
                $newCustomer->active = $customer->Active;
                $newCustomer->tax_number = $customer->TaxNumber;
                $newCustomer->notes = $customer->Notes;

                $newCustomer->save();

            }

            return $response;

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

    }

    public function products(Request $request){

        $skip = !empty($request->input('skip')) ? $request->input('skip') : null;
        $url = "Products";
        $filter = " and Active eq true";

        $params = [
            'url' => $url,
            'skip' => $skip
        ];

        $response = SageAPI::getAll($params);

        // return $response;

        if($response['success']){
                
            $products = $response['data'];

            foreach($products as $product){

                // save $product into new Product

                $newProduct = Product::find($product->Id);

                if(!$newProduct){
                    $newProduct = new Product;
                    $newProduct->id = $product->Id;
                }

                $newProduct->name = $product->Name;
                $newProduct->code = $product->Code;
                $newProduct->description = $product->Description;
                $newProduct->active = $product->Active;
                $newProduct->price = $product->SalesPrice;
                $newProduct->family = "";
                $newProduct->family_code = "";
                $newProduct->stock = 0;

                $request = new \Illuminate\Http\Request();

                $request->replace(['productId' => $product->Id]);

                $responseStock = $this->stock($request);

                if($responseStock['success'])
                    $newProduct->stock = $responseStock['data'];

                $newProduct->save();

            }

            return $response;

        }else
            return $response;

    }

    public function stock(Request $request){

        $productId = !empty($request->input('productId')) ? $request->input('productId') : null;

        $params = [
            'productId' => $productId
        ];

        $response = SageAPI::getStock($params);

        if($response['success']){

            if(!$response['data'])
                $response['data'] = -1;
            else
                $response['data'] = $response['data']->Quantity;

}

        return $response;

    }
}
