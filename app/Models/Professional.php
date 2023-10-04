<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property boolean $state
 * @property string $user
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $country
 * @property string $province
 * @property string $town
 * @property string $address
 * @property string $description
 * @property string $company
 * @property string $cif
 * @property string $type
 * @property string $tax_company
 * @property string $initial_invoice
 * @property int $distributor_id
 * @property Distributor $distributor
 * @property Order[] $orders
 * @property Payment[] $payments
 * @property Professionalselection[] $professionalselections
 */
class Professional extends Model
{

    public $timestamps = false;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'professional';

    /**
     * @var array
     */
    protected $fillable = ['state', 'user', 'name', 'email', 'phone', 'country', 'province', 'town', 'address', 'description', 'company', 'cif', 'type', 'tax_company', 'initial_invoice', 'distributor_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distributor()
    {
        return $this->belongsTo('App\Models\Distributor', 'distributor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'professional_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'professional_id');
    }  
    
    public function selections()
    {
        return $this->belongsToMany(Selection::class);
    }   

    // Check if professional exists
    public static function checkProfessional($id){

        $professional = Professional::find($id);

        if($professional == null)
            return false;

        return $professional;
    }

    // Validate professional
    public static function validateProfessional($params, $id = null){

        // Fields on Professional
        $user = !empty($params['user']) ? $params['user'] : null;
        $state = !empty($params['state']) ? $params['state'] : 0;
        $name = !empty($params['name']) ? $params['name'] : null;
        $email = !empty($params['email']) ? $params['email'] : null;
        $phone = !empty($params['phone']) ? $params['phone'] : null;
        $country = !empty($params['country']) ? $params['country'] : null;
        $province = !empty($params['province']) ? $params['province'] : null;
        $town = !empty($params['town']) ? $params['town'] : null;
        $address = !empty($params['address']) ? $params['address'] : null;
        $description = !empty($params['description']) ? $params['description'] : null;
        $company = !empty($params['company']) ? $params['company'] : null;
        $cif = !empty($params['cif']) ? $params['cif'] : null;
        $type = !empty($params['type']) ? $params['type'] : null;
        $tax_company = !empty($params['tax_company']) ? $params['tax_company'] : $company;
        $initial_invoice = !empty($params['initial_invoice']) ? $params['initial_invoice'] : null;

        if($user == null || $type == null || $email == null)
            return ["data" => false, "success" => false, "message" => "Empty fields"];

        if(!in_array($state, ["0", "1"]))
            return ["data" => false, "success" => false, "message" => "Incorrect state"];

        if(!in_array($type, ["Standard", "Open2"]))
            return ["data" => false, "success" => false, "message" => "Incorrect type"];

        // In case of update professional
        if(isset($id)){

            if(!$professional = Professional::checkProfessional($id))
                return ["data" => false, "success" => false, "message" => "Professional ID not found"];

            $professionalCopy = Professional::where('id', '!=', $id)
            ->where(function($query) use ($user, $email)
            {
                $query->where('user', $user)
                    ->orWhere('email', $email);
            })
            ->first();

            if($professionalCopy != null)
                return ["data" => false, "success" => false, "message" => "Professional fields user or email already exists"];

            // update
            $professional->user = $user;
            $professional->state = $state;
            $professional->name = $name;
            $professional->email = $email;
            $professional->phone = $phone;
            $professional->country = $country;
            $professional->province = $province;
            $professional->town = $town;
            $professional->address = $address;
            $professional->description = $description;
            $professional->company = $company;
            $professional->cif = $cif;
            $professional->type = $type;       
            $professional->tax_company = $params["tax_company"];       
            $professional->initial_invoice = $initial_invoice;       
            
            return ["data" => $professional, "success" => true, "message" => "Cuenta Actualizada"];
        }

        // In case of new Professional
        else{

            // Check if user or email is already on DB
            $professional = Professional::where('user', $user)
                ->orWhere('email', $email)
                ->first();

            if($professional != null)
                return ["data" => null, "success" => false, "message" => "Ya existe un usuario con esos datos"];

            $professional = new Professional($params);
            
            return ["data" => $professional, "success" => true, "message" => "Cuenta Creada"];
        }
    }

}
