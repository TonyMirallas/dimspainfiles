<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property InterestLead[] $interestLeads
 */
class Interest extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'interest';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interestLeads()
    {
        return $this->hasMany(Lead::class);
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }    
}
