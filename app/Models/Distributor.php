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
 * @property Payment[] $payments
 * @property Professional[] $professionals
 */
class Distributor extends Model
{

    public $timestamps = false;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'distributor';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['state', 'user', 'name', 'email', 'phone', 'country', 'province', 'town', 'address', 'description', 'company', 'cif'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'distributor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professionals()
    {
        return $this->hasMany('App\Models\Professional', 'distributor_id');
    }

    // Check if distributor exists
    public static function checkDistributor($id)
    {
        $distributor = Distributor::find($id);

        if($distributor == null)
            return false;
        else
            return $distributor;
    }
}
