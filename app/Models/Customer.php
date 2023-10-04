<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $commercial_name
 * @property string $email
 * @property string $code
 * @property boolean $active
 * @property string $tax_number
 * @property string $notes
 * @property string $legal_representative_name
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $address
 * @property string $pc
 * @property string $phone
 * @property string $acquisition
 * @property string $type
 * @property Invoice[] $invoices
 * @property Competition[] $competitions
 */
class Customer extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'customer';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'commercial_name', 'email', 'code', 'active', 'tax_number', 'notes', 'legal_representative_name', 'country', 'province', 'city', 'address', 'pc', 'phone', 'acquisition', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'customer_id');
    } 
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'customer_id');
    } 

    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    } 

    public function competitors()
    {
        return $this->belongsToMany(Competitor::class);
    } 

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'discount', 'active');
    }    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice', 'customer_id');
    }

    // Check if customer exists
    public static function checkCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer == null)
            return false;
        else
            return $customer;
    }     
}
