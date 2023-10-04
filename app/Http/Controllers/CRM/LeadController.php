<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Lead;
use App\Models\Contact;
use App\Models\Interest;

class LeadController extends Controller
{

    public function getLeads(){

        $leads = Lead::all();
        foreach($leads as $lead){
            $lead->contacts;
            $lead->interests;

        }

        return ['data' => $leads, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];
        
    }

    public function getLead(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if($lead = Lead::checkLead($id)){
            $lead->contacts;
            $lead->interests;

            return ['data' => $lead, 'success' => true, 'message_log' => 'Chido', 'message' => 'Chido'];

        }else
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];
    }    

    public function postLead(Request $request){
    
        $validator = Validator::make($request->all(), [
            'cif' => 'unique:lead|max:15',
            'pc' => 'max:15',
            'name' => 'required|unique:lead,name',
            'fiscal_name' => 'unique:lead,fiscal_name',
            'email' => 'unique:contact|email',
            'interests' => 'array',  
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $lead = new Lead();
        $lead->name = $request->name;
        $lead->fiscal_name = $request->fiscal_name;
        $lead->cif = $request->cif;
        $lead->pc = $request->pc;
        $lead->address = $request->address;
        $lead->country = $request->country;
        $lead->province = $request->province;
        $lead->city = $request->city;
        $lead->acquisition = $request->acquisition;
        $lead->observations = $request->observations;

        $lead->save();

        /* Contacts */

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = "Company"; // Company, Commercial, Supplier, Contable, etc
        $contact->channel = $request->channel;
        $contact->observations = $request->contact_observations;


        $lead->contacts()->save($contact);
        
        /* Interests */

        if(!empty($request->interests)){
            
            $interests = Interest::whereIn('name', $request->interests)->get();
            $lead->interests()->saveMany($interests);
        }

        $lead->contacts;
        $lead->interests;

        return ['data' => $lead, 'success' => true, 'message_log' => 'Lead created', 'message' => 'Lead creado'];
            
    }

    public function postContactLead(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:lead',
            'name' => 'required',
            'email' => 'required|unique:contact,email|email'
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];

        $lead = Lead::find($request->id);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = $request->position;
        $contact->channel = $request->channel;
        $contact->observations = $request->observations;

        $lead->contacts()->save($contact);
        $lead->contacts;

        return ['data' => $lead, 'success' => true, 'message_log' => 'Contact created', 'message' => 'Contacto creado'];
        
    }

    public function putLead(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$lead = Lead::checkLead($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

        $contact = $lead->contacts()->where('position', 'Company')->first();

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('lead', 'name')->ignore($lead->id),
            ],
            'fiscal_name' => [
                'nullable',
                'string',
                Rule::unique('lead', 'fiscal_name')->ignore($lead->id),
            ],            
            'cif' => [
                'nullable',
                'max:15',
                Rule::unique('lead', 'cif')->ignore($lead->id),
            ],
            'pc' => 'nullable|max:15',
            'address' => 'nullable|string',
            'email' => [
                'nullable',
                'email',
                Rule::unique('contact', 'email')->ignore($contact->id),
            ],            
            'interests' => 'array',  
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $lead->name = $request->name;
        $lead->fiscal_name = $request->fiscal_name;
        $lead->cif = $request->cif;
        $lead->pc = $request->pc;
        $lead->address = $request->address;
        $lead->country = $request->country;
        $lead->province = $request->province;
        $lead->city = $request->city;
        $lead->acquisition = $request->acquisition;
        $lead->observations = $request->observations;

        $lead->save();

        /* Contacts */

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->position = "Company"; // Company, Commercial, Supplier, Contable, etc
        $contact->channel = $request->channel;
        $contact->observations = $request->contact_observations;


        $lead->contacts()->save($contact);
        
        /* Interests */

        // delete all lead interests
        $lead->interests()->detach();
        $lead->save();

        if(!empty($request->interests)){
            
            $interests = Interest::whereIn('name', $request->interests)->get();
            $lead->interests()->saveMany($interests);
        }

        $lead->contacts;
        $lead->interests;

        return ['data' => $lead, 'success' => true, 'message_log' => 'Lead created', 'message' => 'Lead creado'];

    }

    public function putContact(Request $request){

        $id = !empty($request->input('id')) ? $request->input('id') : null;

        if(!$contact = Contact::checkContact($id))
            return ['data' => null, 'success' => false, 'message_log' => 'Not found', 'message' => 'No encontrado'];

        $company = 'Company';

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('contact', 'name')->ignore($contact->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contact', 'email')->ignore($contact->id),
            ],
            'phone' => 'nullable|string',
            // Exclude position "Company"
            'position' => 'nullable|string|not_in:' . $company,
            'channel' => 'nullable|string',
            'observations' => 'required|string',
        ]);

        if ($validator->fails())
            return ['data' => $validator->errors(), 'success' => false, 'message_log' => 'Validation failed', 'message' => 'Validación fallida'];
        
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        if($contact->position != "Company")
            $contact->position = $request->position;
        $contact->channel = $request->channel;
        $contact->observations = $request->observations;

        $contact->save();

        $contact->lead;

        return ['data' => $contact, 'success' => true, 'message_log' => 'Contact created', 'message' => 'Contacto creado'];

    }
}
