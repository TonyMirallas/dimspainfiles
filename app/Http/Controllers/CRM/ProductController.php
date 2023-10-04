<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    public function getProducts(){

        $products = Product::all();

        return ['data' => $products, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
    }

    public function getproduct(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($product = Product::checkproduct($id))
            return ['data' => $product, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
    }  
}
