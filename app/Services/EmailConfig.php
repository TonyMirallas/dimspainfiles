<?php


namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Mail;

use App\Mail\SendInvoice;
use App\Models\Technical;

class EmailConfig
{
    public function putConfig(Technical $technical, $email, $email_to, $attachment = '')
    {

        if($technicalConfig = $technical->emails->first()){

            // $encrypt = Crypt::encryptString($string);
    
            $decrypt = Crypt::decryptString($technicalConfig->password);
    
            $existing = config('mail');
            $new =array_merge(
                $existing, [
                'host' => $technicalConfig->host,
                'port' => $technicalConfig->port,
                'from' => [
                    'address' => $technicalConfig->address,
                    'name' => $technicalConfig->support,
                    ],
                'encryption' => $technicalConfig->encryption,
                'username' => $technical->email,
                'password' => $decrypt
                ]);
        
            config(['mail'=>$new]); 
        }

        try{

            $this->sendEmail($email, $email_to, $attachment);

        }catch(\Exception $e){
            return false;
        }

        return true;
            
    }

    private function sendEmail($email, $email_to, $attachment = ''){

        Mail::to($email_to)->send(new SendInvoice($attachment));

        // check if the email was sent
        // if (Mail::failures())
        //     return false;

        return true;

    }
}