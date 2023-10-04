<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $technical_id
 * @property string $host
 * @property string $port
 * @property string $address
 * @property string $name
 * @property string $encryption
 * @property string $username
 * @property string $password
 * @property Technical $technical
 */
class Email extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'email';

    /**
     * @var array
     */
    protected $fillable = ['technical_id', 'host', 'port', 'address', 'name', 'encryption', 'username', 'password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technical()
    {
        return $this->belongsTo(Technical::class);
    }
}
