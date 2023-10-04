<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $contact_id
 * @property string $customer_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $position
 * @property string $channel
 * @property string $observations
 * @property Customer $customer
 */
class Contact extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'contact';

    /**
     * @var array
     */
    protected $fillable = ['contact_id', 'customer_id', 'name', 'email', 'phone', 'position', 'channel', 'observations'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }    

    // Check if Contact exists
    public static function checkContact($id)
    {
        $contact = Contact::find($id);
        if ($contact == null)
            return false;
        else
            return $contact;
    }  
}
