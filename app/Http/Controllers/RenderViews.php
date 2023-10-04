<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RenderViews extends Controller
{

    //##################################################### Technical
    public function technical(Request $request){
        $data_server = ['auth' => $request->auth];
        return view('technical', ["data_server" => $data_server]);
    }

    public function technicalAccountExit(Request $request){

        foreach ($_COOKIE as $key => $value) {
            \Cookie::queue(\Cookie::forget($key));
        }

        return redirect('http://'.$_SERVER['HTTP_HOST'].'/login');

    }

    //##################################################### Technical
    public function distributor(Request $request){
        $data_server = ['auth' => $request->auth];
        return view('distributor', ["data_server" => $data_server]);
    }

    public function distributorAccountExit(Request $request){

        foreach ($_COOKIE as $key => $value) {
            \Cookie::queue(\Cookie::forget($key));
        }

        return redirect('http://'.$_SERVER['HTTP_HOST'].'/login');

    }

    //##################################################### Profesional
    public function professional(Request $request){
        $data_server = ['auth' => $request->auth];
        return view('professional', ["data_server" => $data_server]);
    }
    
}
