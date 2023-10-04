<?php

if(!function_exists('wp_create_user')){

    function wp_create_user($params){

        try{

            // SOLO TONY ################################################################################################
            // return true;
            // ###########################################################################################################

            $url = config('global.base_url') . "wp-json/user/create";    

            $client = new GuzzleHttp\Client();

            $res = $client->post($url, [ GuzzleHttp\RequestOptions::JSON => $params]);

            if($res->getStatusCode() == 200){
                return true;
            }else{
                return false;
            }
        
        }catch(Exception $e){
            return false;
        }

    }
    
}


if(!function_exists('wp_create_update')){

    function wp_create_update($params){

        try{

            // SOLO TONY ################################################################################################
            return true;
            // ###########################################################################################################

            $url = config('global.base_url') . "wp-json/user/update";    

            $client = new GuzzleHttp\Client();

            $res = $client->post($url, [ GuzzleHttp\RequestOptions::JSON => $params]);

            if($res->getStatusCode() == 200){
                return true;
            }else{
                return false;
            }
        
        }catch(Exception $e){
            return false;
        }

    }
    
}


// Se genera un estandar de devolución de objectos para todas 
// las respuestas de la api, de esta forma tambien podemos mantener
// un log de cada error
if(!function_exists('api_response_true')){

    function api_response_true($data, $message){

        return [
            "data" => $data, 
            "success" => true, 
            "message" => $message, 
            "message_log" => $message
        ]; 

    }
    
}

if(!function_exists('api_response_false')){

    function api_response_false($e, $message){

        return [
            "data" => null, 
            "success" => false, 
            "message" => $e->getMessage(),
            "message_log" => $message,
        ]; 

    }
    
}
