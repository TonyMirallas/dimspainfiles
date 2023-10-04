<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\GetData;

class UserController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getData(Request $request){

        $params = [
            "user" => !empty($request->input('user')) ? $request->input('user') : null,
            "email" => !empty($request->input('email')) ? $request->input('email') : null,
        ];
        
        $allData = new GetData();
        $data = $allData->getCredencials($params);

        return $data;

    }

    public function getUsers(Request $request){

        if($request->has('rol'))
            $users = User::where('rol', $request->rol)->get();
        else
            $users = User::all();

        foreach($users as $user)
            $user->tasks;

        return ['data' => $users, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
    }

    public function getUser(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$user = User::checkUser($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

        $user->tasks;

        return ['data' => $user, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

    }
    
    public function postTechnical(Request $request){

        try{

            $user = $request->input('user');
            $email = $request->input('email');

            if(empty($user) || empty($email))
                throw new Exception("User or email empty");

            $params = array("user" => $user, "email" => $email);

            $technical = Technical::where('user', $user)
                ->orWhere('email', $email)
                ->first();

            if(empty($technical)){

                $technical = new Technical($params);
                $technical->save();
                return api_response_true($technical, "Profesional creado");

            }else{
                throw new Exception("User or email already on DB");
            }

        }catch(Exception $e){

            return api_response_false($e, "Error al crear el profesional");
            
        }

    }

}
