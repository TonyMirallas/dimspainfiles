<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Task;

class TaskController extends Controller
{
    public function getTasks(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'customer_id' => 'exists:customer,id',
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
            

        if($request->user_id)
            $tasks = Task::where('user_id', $request->user_id)->get();
        else if($request->customer_id)
            $tasks = Task::where('customer_id', $request->customer_id)->get();
        else
            $tasks = Task::all();

        foreach($tasks as $task){
            $task->relation = json_decode($task->relation);
            $task->user;
            $task->fromUser;
            $task->customer;
            $task->contact;
            $task->fromContact;
        }

        return ['data' => $tasks, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
    }

    public function getTask(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($task = Task::checkTask($id)){
            $task->relation = json_decode($task->relation);
            $task->user;
            $task->fromUser;
            $task->customer;
            $task->contact;
            $task->fromContact;

            return ['data' => $task, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
    }    

    public function postTask(Request $request){
    
        $state = ['open', 'closed', 'canceled'];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'from_user_id' => 'required|exists:users,id',
            'customer_id' => 'exists:customer,id',
            'contact_id' => 'exists:contact,id',
            'from_contact_id' => 'exists:contact,id',
            'channel' => 'string',
            'objetive' => 'string',
            'state' => 'required|string|in:'.implode(',', $state),
            'description' => 'string',
            'relation' => 'json',
            'result' => 'string',
            'finished_at' => 'required|date'
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $task = Task::create($request->all());

        $task->relation = json_decode($task->relation);
        $task->user;
        $task->fromUser;
        $task->customer;
        $task->contact;
        $task->fromContact;

        return ['data' => $task, 'success' => true, 'message_log' => 'task created', 'message' => 'task creado'];
            
    }

    public function putTask(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        $state = ['open', 'closed', 'canceled'];

        $validator = Validator::make($request->all(), [
            'state' => 'nullable|string|in:'.implode(',', $state),
            'result' => 'nullable|string'
        ]);

        if ($validator->fails())
        return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
    

        if(!$task = Task::checkTask($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

        if($request->state)
            $task->state = $request->state;

        if($request->result)
            $task->result = $request->result;

        $task->save();

        $task->relation = json_decode($task->relation);
        $task->user;
        $task->fromUser;
        $task->customer;
        $task->contact;
        $task->fromContact;

        return ['data' => $task, 'success' => true, 'message_log' => 'task updated', 'message' => 'task actualizado'];

    }
}
