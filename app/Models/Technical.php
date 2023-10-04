<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $user
 * @property string $token
 * @property Order[] $orders
 */
class Technical extends Model
{
    public $timestamps = false;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'technical';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['email', 'user', 'token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Model\Order', 'technical_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::Class, 'technical_id');
    }    

    // Check if technical exists
    public static function checkTechnical($id)
    {
        $technical = Technical::find($id);
        if ($technical == null)
            return false;
        else
            return $technical;
    }    
}
