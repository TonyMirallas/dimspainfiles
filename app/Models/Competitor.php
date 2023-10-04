<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property CompetitorCustomer[] $competitorCustomers
 */
class Competitor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'competitor';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competitorCustomers()
    {
        return $this->hasMany('App\CompetitorCustomer');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }     
}
