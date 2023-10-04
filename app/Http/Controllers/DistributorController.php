<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Distributor;

use App\Services\GetData;

class DistributorController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDistributors(){

        try{

            $distributors = Distributor::all();

            $checkCredits = new GetData();
            
            foreach ($distributors as $distributor){
                
                $distributor->professionals;
                $distributor->credits = $checkCredits->getCredits($distributor);
            }   

            return api_response_true($distributors, "Distribuidores encontrados");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener los distribuidores");
            
        }

    }

    public function getDistributor(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if(!$distributor = Distributor::checkDistributor($id))
                throw new Exception("Distributor ID not found");

            $checkCredits = new GetData();

            $distributor->professionals;
            $distributor->credits = $checkCredits->getCredits($distributor);

            return api_response_true($distributor, "Distribuidor encontrado");

        }catch(Exception $e){

            return api_response_false($e, "Error al obtener el distribuidor");
            
        }

    }

    public function getDistributorProfessionals(Request $request){

        try{

            $id = !empty($request->input('id')) ? $request->input('id') : null;

            if(!$distributor = Distributor::checkDistributor($id))
                throw new Exception("Distributor ID not found");

            return api_response_true($distributor->professionals, "Distributor's Professionals got correctly");
    
        }catch(Exception $e){

            return api_response_false($e, "Error al obtener los distribuidores de profesionales");
            
        }

    }    

    public function postDistributor(Request $request){

        try{

            // Fields on Distributor
            $user = !empty($request->input('user')) ? $request->input('user') : null;
            $state = !empty($request->input('state')) ? $request->input('state') : 0;
            $name = !empty($request->input('name')) ? $request->input('name') : null;
            $email = !empty($request->input('email')) ? $request->input('email') : null;
            $phone = !empty($request->input('phone')) ? $request->input('phone') : null;
            $country = !empty($request->input('country')) ? $request->input('country') : 'ESPAÑA';
            $province = !empty($request->input('province')) ? $request->input('province') : null;
            $town = !empty($request->input('town')) ? $request->input('town') : null;
            $address = !empty($request->input('address')) ? $request->input('address') : null;
            $description = !empty($request->input('description')) ? $request->input('description') : null;
            $company = !empty($request->input('company')) ? $request->input('company') : null;
            $cif = !empty($request->input('cif')) ? $request->input('cif') : null;

            // if any input is empty return error
            if(empty($user) || empty($name) || empty($email) || empty($company))
                throw new Exception("Some inputs are empty");

            $distributor = Distributor::where('user', $user)
                ->orWhere('email', $email)
                ->first();

            if(!empty($distributor))
                throw new Exception("User or email already on DB");

            $params = array(
                'user' => $user,
                'state' => $state,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'country' => $country,
                'province' => $province,
                'town' => $town,
                'address' => $address,
                'description' => $description,
                'company' => $company,
                'cif' => $cif,
            );

            $distributor = new Distributor($params);

            // Register user on wp
            $userWP = wp_create_user([
                "user_login"=> $user,
                "user_email"=> $email,
                "first_name"=> $name,
                "last_name"=> $company,
                "role"=> "distributor"
            ]);

            // If the user was created in wp, it is also created in laravel
            if($userWP){
                $distributor->save();
                return api_response_true($distributor, "Distribuidor creado");
            }
        
            throw new Exception("User Wordpress Error");

        }catch(Exception $e){

            return api_response_false($e, "Error al crear el distribuidor");
            
        }

    }

    public function updateDistributor(Request $request){

        try{

            // Fields on Distributor
            $id = !empty($request->input('id')) ? $request->input('id') : null;
            $user = !empty($request->input('user')) ? $request->input('user') : null;
            $state = !empty($request->input('state')) ? $request->input('state') : 0;
            $name = !empty($request->input('name')) ? $request->input('name') : null;
            $email = !empty($request->input('email')) ? $request->input('email') : null;
            $phone = !empty($request->input('phone')) ? $request->input('phone') : null;
            $country = !empty($request->input('country')) ? $request->input('country') : 'ESPAÑA';
            $province = !empty($request->input('province')) ? $request->input('province') : null;
            $town = !empty($request->input('town')) ? $request->input('town') : null;
            $address = !empty($request->input('address')) ? $request->input('address') : null;
            $description = !empty($request->input('description')) ? $request->input('description') : null;
            $company = !empty($request->input('company')) ? $request->input('company') : null;
            $cif = !empty($request->input('cif')) ? $request->input('cif') : null;

            // if any input is empty return error
            if(empty($user) || empty($name) || empty($email) || empty($company))
                throw new Exception("Some inputs are empty");

            // Check if another distributor has same user or email
            $distributorCopy = Distributor::where('id', '!=', $id)
                ->where(function($query) use ($user, $email)
                    {
                        $query->where('user', $user)
                            ->orWhere('email', $email);
                    })
                    ->first();

            if($id == null)
                throw new Exception("Distributor ID empty");
            
            // Check if distributor exists
            if(empty($distributor = Distributor::where('id', $id)->first()))
                throw new Exception("Distributor ID not found");

            if(empty($distributorCopy) && $id != null && !empty($distributor)){

                // update
                $distributor->user = $user;
                $distributor->state = $state;
                $distributor->name = $name;
                $distributor->email = $email;
                $distributor->phone = $phone;
                $distributor->country = $country;
                $distributor->province = $province;
                $distributor->town = $town;
                $distributor->address = $address;
                $distributor->description = $description;
                $distributor->company = $company;
                $distributor->cif = $cif;

                $distributor->save();

                return api_response_true($distributor, "Distributor updated");
            }

            throw new Exception("Intentando actualizar un distribuidor distinto al id indicado");

        }catch(Exception $e){

            return api_response_false($e, "Error al actualizar el distribuidor");
            
        }

        
    } 
    
    public function addProfessionalDistributor(Request $request){

        $distributor_id = !empty($request->input('distributor_id')) ? $request->input('distributor_id') : null;
        $professional_id = !empty($request->input('professional_id')) ? $request->input('professional_id') : null;

        $professional = Professional::checkProfessional($professional_id);

        if(!$professional || (!$distributor = Distributor::checkDistributor($distributor_id) && $distributor_id != null))      
            return ["data" => false, "success" => false, "message" => "Distribuidor o profesional no encontrado", "message_log" => "Distributor or Professional not found"];

        $professional->distributor_id = $distributor_id;
        $professional->save();

        return ["data" => false, "success" => false, "message" => "Distribuidor o profesional no encontrado", "message_log" => "Distributor or Professional not found"];

    }
}
