<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Selection;
use App\Models\Payment;

use App\Services\GetData;
use App\Services\InsertPayment;
use App\Services\ShadowFiles;

class ProfessionalController extends Controller
{
    
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getProfessionals(){

        try{

            $professionals = Professional::all();
            $checkCredits = new GetData();

            // Add credentials to each professional. IMPORTANT: ADD ORDERS AND DISTRIBUTOR TO EACH PROFESSIONAL
            foreach($professionals as $professional){
                $professional->credits = $checkCredits->getCredits($professional);
                $professional->selections;
            }

            return api_response_true($professionals, "Obtención de profesionales exitosa");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener los profesionales");
            
        }

    }

    public function getProfessional(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if($professional = Professional::checkProfessional($id)){
                
                $checkCredits = new GetData();
                $professional->credits = $checkCredits->getCredits($professional);
                $professional->selections;
                $professional->payments = $professional->payments()->whereNotIn('payment', ["order", "refund"])->get();
                $professional->orders;

                return api_response_true($professional, "Obtención de profesional exitosa");

            }
            
            throw new Exception("Professional not found");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener el profesional");

        }

    }

    public function postProfessional(Request $request){

        try{
    
            $params = [
                // Fields on Professional
                'user' => !empty($request->input('user')) ? $request->input('user') : null,
                'state' => !empty($request->input('state')) ? $request->input('state') : 0,
                'name' =>!empty($request->input('name')) ? $request->input('name') : null,
                'email' =>!empty($request->input('email')) ? $request->input('email') : null,
                'phone' =>!empty($request->input('phone')) ? $request->input('phone') : null,
                'country' =>!empty($request->input('country')) ? $request->input('country') : null,
                'province' =>!empty($request->input('province')) ? $request->input('province') : null,
                'town' =>!empty($request->input('town')) ? $request->input('town') : null,
                'address' =>!empty($request->input('address')) ? $request->input('address') : null,
                'description' =>!empty($request->input('description')) ? $request->input('description') : null,
                'company' =>!empty($request->input('company')) ? $request->input('company') : null,
                'cif' =>!empty($request->input('cif')) ? $request->input('cif') : null,
                'type' =>!empty($request->input('type')) ? $request->input('type') : null,
                'tax_company' =>!empty($request->input('tax_company')) ? $request->input('tax_company') : null,
                'initial_invoice' =>!empty($request->input('initial_invoice')) ? $request->input('initial_invoice') : null,
                'distributor_id' =>!empty($request->input('distributor_id')) ? $request->input('distributor_id') : null

            ];

            $paramsPayment = [
                'credits' => !empty($request->input('credits')) ? $request->input('credits') : null,
                'payment' => 'iniciales',
                'status' => 'Completed'
            ];

            $selection = !empty($request->input('selection')) ? $request->input('selection') : null;

            if($params["distributor_id"] != null && !$distributor = Distributor::checkDistributor($params["distributor_id"]))
                $params["distributor_id"] = null;

            $dataProfessional = Professional::validateProfessional($params);

            if(!$professional = $dataProfessional["data"])
                throw new Exception($dataProfessional["message"]);

            $selectionModel = Selection::validateSelection($selection);
            $professional->save();

            if($selectionModel)
                $professional->selections()->saveMany($selectionModel);

            $professional->selections = $selectionModel;

            if($paramsPayment["credits"] != null){
                $paramsPayment["professional_id"] = $professional->id;
                $dataPayment = Payment::validatePayment($paramsPayment);

                if($dataPayment["success"])
                    $dataPayment["data"]->save();
            }
            
            $userWP = wp_create_user([
                "user_login"=> $professional->user,
                "user_email"=> $professional->email,
                "first_name"=> $professional->name,
                "last_name"=> $professional->company,
                "role"=> "professional"
            ]);

            // If the user was created in wp, it is also created in laravel
            if(!$userWP)
                throw new Exception("Error al crear el profesional en wp");

            return api_response_true($dataProfessional["data"], "Creación de profesional exitosa"); 

        }catch(Exception $e){

            return api_response_false($e, "Error al crear el profesional");

        }
            
    }

    public function updateProfessional(Request $request){

        try{

            // Fields on Professional
            $id = !empty($request->input('id')) ? $request->input('id') : 0;
            $distributor_id = !empty($request->input('distributor_id')) ? $request->input('distributor_id') : null;

            $params = [

                // Fields on Professional
                'user' => !empty($request->input('user')) ? $request->input('user') : null,
                'state' => !empty($request->input('state')) ? $request->input('state') : 0,
                'name' =>!empty($request->input('name')) ? $request->input('name') : null,
                'email' =>!empty($request->input('email')) ? $request->input('email') : null,
                'phone' =>!empty($request->input('phone')) ? $request->input('phone') : null,
                'country' =>!empty($request->input('country')) ? $request->input('country') : null,
                'province' =>!empty($request->input('province')) ? $request->input('province') : null,
                'town' =>!empty($request->input('town')) ? $request->input('town') : null,
                'address' =>!empty($request->input('address')) ? $request->input('address') : null,
                'description' =>!empty($request->input('description')) ? $request->input('description') : null,
                'company' =>!empty($request->input('company')) ? $request->input('company') : null,
                'cif' =>!empty($request->input('cif')) ? $request->input('cif') : null,
                'type' =>!empty($request->input('type')) ? $request->input('type') : null,
                'tax_company' =>!empty($request->input('tax_company')) ? $request->input('tax_company') : null,
                'initial_invoice' =>!empty($request->input('initial_invoice')) ? $request->input('initial_invoice') : null,
            ];   

            $professionalData = Professional::validateProfessional($params, $id);

            if(!$professional = $professionalData["data"])
                throw new Exception($professionalData["message"]);

            // In case of null, the association with a distributor is removed
            if($distributor_id == null){

                $professional->distributor_id = null;

            }else if($distributor = Distributor::checkDistributor($distributor_id))
                    $professional->distributor_id = $distributor->id;

            $selection = !empty($request->input('selection')) ? $request->input('selection') : null;
            $selectionModel = Selection::validateSelection($selection);
            $professional->selections()->detach();

            $professional->save();

            if($selectionModel)
                $professional->selections()->saveMany($selectionModel);
        
            $professional->selections;

            return api_response_true($professionalData['data'], "Actualización de profesional exitosa");

        }catch(Exception $e){

            return api_response_false($e, "Error al actualizar el profesional");

        }

    } 
    
    // return professional files from FTP
    public function getProfessionalFiles(Request $request){
        
        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if(!$professional = Professional::checkProfessional($id))
                throw new Exception("Error al obtener los archivos del profesional");

            $shadowFiles = new ShadowFiles();
            $data = $shadowFiles->getFiles($professional);

            if(!$data)
                throw new Exception("No se encuentra ningún archivo shadow");

            return api_response_true($data, "Obtención de archivos exitosa");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener los archivos del profesional");

        }

    }
}
