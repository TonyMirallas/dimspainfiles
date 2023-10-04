<?php
namespace App\Services;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Technical;
use App\Models\Payment;

class GetData
{

    public function getCredencials($params){

        $user = !empty($params['user']) ? $params['user'] : null;
        $email = !empty($params['email']) ? $params['email'] : null;

        // Get Professional with $user and $email

        $client = Professional::where('user', $user)->where('email', $email)->first();

        if(empty($client))
            $client = Distributor::where('user', $user)->where('email', $email)->first();

        if(empty($client))
            $client = Technical::where('user', $user)->where('email', $email)->first();

        if(empty($client))
            return ["data" => false, "success" => false, "message_log" => "User ID not found", "message" => "Usuario no encontrado"];

        return ["data" => $client, "success" => true, "message_log" => "User found", "message" => "Usuario encontrado"];

    }

    public function getCredits($client){

        if (is_a($client, 'App\Models\Professional')) {
            // Check how many credits has a professional
            $payments = $client->payments()->where('status', 'Completed')->get();

            $credits = 0;
            foreach ($payments as $payment) 
                $credits += $payment->credits;

        }else if (is_a($client, 'App\Models\Distributor')) {

            // Check how many credits has a distributor
            $payments = $client->payments()->where('status', 'Completed')->get();

            $credits = 0;
            foreach ($payments as $payment)
                $credits += $payment->credits;

        }else{

            return false;
        }

        return $credits;
    }
}