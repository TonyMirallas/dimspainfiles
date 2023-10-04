<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $fiscal_name
 * @property string $cif
 * @property string $pc
 * @property string $address
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $acquisition
 * @property string $observations
 * @property Contact $contact
 */
class Lead extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lead';

    /**
     * @var array
     */
    protected $fillable = ['name', 'fiscal_name', 'cif', 'pc', 'address', 'country', 'province', 'city', 'acquisition', 'observations'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'lead_id');
    } 
    
    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    }      

    // Check if Lead exists
    public static function checkLead($id)
    {
        $lead = Lead::find($id);
        if ($lead == null)
            return false;
        else
            return $lead;
    }    
}
