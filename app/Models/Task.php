<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $from_user_id
 * @property int $customer_id
 * @property int $contact_id
 * @property int $from_contact_id
 * @property string $channel
 * @property string $objetive
 * @property string $state
 * @property string $description
 * @property array $relation
 * @property string $result
 * @property string $created_at
 * @property string $updated_at
 * @property string $finished_at
 * @property Contact $contact
 * @property Contact $contact
 * @property User $user
 * @property User $user
 */
class Task extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'task';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'from_user_id', 'customer_id', 'contact_id', 'from_contact_id', 'channel', 'objetive', 'state', 'description', 'relation', 'result', 'created_at', 'updated_at', 'finished_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo('App\Models\User', 'from_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromContact()
    {
        return $this->belongsTo('App\Models\Contact', 'from_contact_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Check if Task exists
    public static function checkTask($id){

        $task = Task::find($id);

        if($task == null)
            return false;

        return $task;
    }    
}
