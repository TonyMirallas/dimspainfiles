<?php
namespace App\Services;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Technical;
use App\Models\Payment;
use App\Services\SageAPI as ServicesSageAPI;

class SageAPI
{

  public static function checkHealth(){

    $token = $token = SageAPI::getToken();
    $url = "Healthcheck";

    $version = "1.0";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'X-Nonce: 87',
        'X-Site: 9f098e6a-1566-4b0e-ab6b-d2692313337e',
        'Ocp-Apim-Subscription-Key: f+vxHnH44OJeJkh/e6BAjzYtLKtPoG3mcl7AwjGnwO0=',
        'Authorization: Bearer ' . $token,
      ),
    ));
    
    $response = curl_exec($curl); // {"diagnosis":[{"errorCode":"ExpiredToken","message":"The oauth token is expired and is not valid anymore."}]}
    $responseJson = json_decode($response);

    curl_close($curl);

    return $responseJson;

  }

  public static function token($params)  {

    $code = !empty($params['code']) ? $params['code'] : null;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://id.sage.com/oauth/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'grant_type=authorization_code&client_id=jarILReWvovEegLFUS51LskQN9qLpy72&code='. $code .'&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fapi%2Fv1%2Fsage-token&code_verifier=xe2FbGu7vJvWtPzw4Pi7sHMWkpU-hCAwRv_2H5qPGto',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Cookie: did=s%3Av0%3Ab7a1f3d0-bdfa-11eb-a60e-fb25f5126b08.MDbVRuy%2FeMMM8biQwxbH5vWkTL8I0hr43vdba4MvVXc; did_compat=s%3Av0%3Ab7a1f3d0-bdfa-11eb-a60e-fb25f5126b08.MDbVRuy%2FeMMM8biQwxbH5vWkTL8I0hr43vdba4MvVXc'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response;

  }

  public static function getAll($params){

      $token = $token = SageAPI::getToken();
      $url = !empty($params['url']) ? $params['url'] : null;
      $skip = !empty($params['skip']) ? $params['skip'] : 0;
      $filter = !empty($params['filter']) ? $params['filter'] : "";

      $version = "1.0";

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$skip=' . $skip,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'X-Nonce: 87',
          'X-Site: 9f098e6a-1566-4b0e-ab6b-d2692313337e',
          'Ocp-Apim-Subscription-Key: f+vxHnH44OJeJkh/e6BAjzYtLKtPoG3mcl7AwjGnwO0=',
          'Authorization: Bearer ' . $token,
        ),
      ));
      
      $companyId = "7c03ddb1-676a-47b9-8b4b-690ab59e24e3"; // c68f8957-e914-42a4-ac9f-e36c1bb026e8
      $response = [];
      $exit = "unfinish";
      $start = $skip;
          
      curl_setopt($curl, CURLOPT_URL, 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$filter=CompanyId eq \'' . $companyId . $filter . '\'&$skip=' . $skip);

      $responseCustomers = curl_exec($curl); // {"diagnosis":[{"errorCode":"ExpiredToken","message":"The oauth token is expired and is not valid anymore."}]}
      $responseCustomersJson = json_decode($responseCustomers);

      if(!empty($responseCustomersJson->diagnosis)){
        $exit = "invalid token";
        break;

      }else if($responseCustomersJson)
        foreach ($responseCustomersJson->value as $value)
        //   if($value->CompanyId == $companyId)
          $response[] = $value;
   
/*
      do{

        for ($skip=$start; $skip < $start + 500; $skip+=50) { 
          
          curl_setopt($curl, CURLOPT_URL, 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$filter=CompanyId eq \'' . $companyId . $filter . '\'&$skip=' . $skip);

          $responseCustomers = curl_exec($curl); // {"diagnosis":[{"errorCode":"ExpiredToken","message":"The oauth token is expired and is not valid anymore."}]}
          $responseCustomersJson = json_decode($responseCustomers);

          if(!empty($responseCustomersJson->diagnosis)){
            $exit = "invalid token";
            break;

          }else if($responseCustomersJson)
            foreach ($responseCustomersJson->value as $value)
            //   if($value->CompanyId == $companyId)
              $response[] = $value;

        }
        
        if($exit != "invalid token" && $responseCustomersJson){

          if(count($responseCustomersJson->value) < 50)
            $exit = "finish";

          else{
            $start = $skip;
            // sleep(60);
          }

        }else if(!$responseCustomersJson) // Sometimes API returns void for no reason, so we need to sleep on those empty calls
          sleep(60);

        if($skip - $start >= 2500)
          $exit = "finish";

      }while ($exit == "unfinish");
*/
      curl_close($curl);

      switch($exit){
        case "finish":
          return ["data" => $response, "success" => true, "message_log" => "Chido", "message" => "Chido"];
          break;

        case "invalid token":
          return ["data" => $responseCustomersJson, "success" => false, "message_log" => "Invalid Token", "message" => "Token inválido"];
          break;    
          
        case "empty response":
          return ["data" => $responseCustomersJson, "success" => false, "message_log" => "Empty response", "message" => "Respuesta vacía"];
          break;    

      }

  }
  
  public static function getStock($params){

    $token = SageAPI::getToken();
    $url = "ProductStock";
    $skip = 0;
    $productId = !empty($params['productId']) ? $params['productId'] : null;

    $version = "1.0";

    $test = 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$filter=ProductId eq \'' . $productId . '\'&$skip=' . $skip;
      
    $curl = curl_init();
    // 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$filter=CompanyId eq \'' . $companyId . '\'&$skip=' . $skip
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sage200.sage.es/api/sales/' . $url . '?api-version=' . $version . '&$filter=ProductId eq \'' . $productId . '\'&$skip=' . $skip,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'X-Nonce: 87',
        'X-Site: 9f098e6a-1566-4b0e-ab6b-d2692313337e',
        'Ocp-Apim-Subscription-Key: f+vxHnH44OJeJkh/e6BAjzYtLKtPoG3mcl7AwjGnwO0=',
        'Authorization: Bearer ' . $token,
      ),
    ));
    
    try{

      $response = curl_exec($curl); // {"diagnosis":[{"errorCode":"ExpiredToken","message":"The oauth token is expired and is not valid anymore."}]}
      curl_close($curl);

      $responseJson = json_decode($response);

      if(!$responseJson)
        return ["data" => null, "success" => false, "message_log" => "Unknown error", "message" => "Error inesperado, inténtelo de nuevo"];
      else if(!$responseJson->value) // Sometimes this motherfucker returns void for no reason, so we need to make another case
        return ["data" => null, "success" => true, "message_log" => "Empty response", "message" => "No se encontraron registros"];
      else
        return ["data" => json_decode($response)->value[0], "success" => true, "message_log" => "Chido", "message" => "Chido"];
      
    }catch(Exception $e){
      return ["data" => null, "success" => false, "message_log" => $e, "message" => $e];
    }

  }

  private static function getToken(){

    // Get technical from db with email tony
    $technical = Technical::where('email', 'tony@agenciat1.es')->first();

    return $technical->token;
  }

}