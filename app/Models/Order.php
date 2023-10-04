<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $notes
 * @property string $technical_notes
 * @property string $status
 * @property string $options
 * @property string $professional_file
 * @property string $technical_file
 * @property string $shw_file
 * @property string $type
 * @property string $veh_type
 * @property string $model
 * @property string $manufacture
 * @property int $year
 * @property string $fuel
 * @property int $kw
 * @property string $emission
 * @property int $technical_id
 * @property int $professional_id
 * @property Technical $technical
 * @property Payment[] $payments
 */
class Order extends Model
{

    protected $casts = [
        'options' => 'array'
    ];    
    
    // public $timestamps = false;


    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'order';

    /**
     * @var array
     */
    protected $fillable = ['notes', 'technical_notes', 'status', 'options', 'professional_file', 'technical_file', 'shw_file', 'type', 'veh_type', 'model', 'manufacture', 'year', 'fuel', 'kw', 'emission', 'technical_id', 'professional_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technical()
    {
        return $this->belongsTo('App\Models\Technical', 'technical_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'order_id');
    }

    // Check if order exists
    public static function checkOrder($id)
    {
        $order = Order::find($id);
        if ($order == null)
            return false;
        else
            return $order;
    }

    // Validate order
    public static function validateOrder($params)
    {
        // Fields on Order
        $type = $params['type'];
        $model = $params['model'];
        $veh_type = $params['veh_type'];
        $manufacture = $params['manufacture'];
        $year = $params['year'];
        $fuel = $params['fuel'];
        $kw = $params['kw'];
        $emission = $params['emission'];
        $notes = $params['notes'];
        $status = !empty($params['status']) ? $params['status'] : null;
        $options = $params['options'];
        $professional_file = !empty($params['professional_file']) ? $params['professional_file'] : null;
        $technical_file = !empty($params['technical_file']) ? $params['technical_file'] : null;
        $shw_file = $params['shw_file'];
        
        if(!in_array($veh_type, ['BIKE', 'CAR', 'LCV', 'MARINE', 'TRUCK', 'TRACTOR']))
            return ["data" => false, "code" => "305", "message" => "Incorrect vehicle type"]; 

        // Check if kw is a number and greater than 0
        if(!is_numeric($kw) || $kw <= 0)
            return ["data" => false, "code" => "306", "message" => "Incorrect kw"];

        $params['status'] = "Pendiente";

        $order = new Order($params);
 
        return ["data" => $order, "code" => "200", "message" => "Chido"];
    }

    public static function updateStatus($params, $technical_id = null)
    {
        $id = !empty($params['id']) ? $params['id'] : null;
        $status = !empty($params['status']) ? $params['status'] : null;
        $technical_notes = !empty($params['technical_notes']) ? $params['technical_notes'] : null;

        $states = ['Pendiente', 'En Proceso', 'Completado', 'Devolución'];

        // if(!in_array($status, $states))
        //     return ["data" => false, "code" => "304", "message" => "Incorrect Status"];

        $order = Order::checkOrder($id);

        if(!$order = Order::checkOrder($id))
            return ["data" => false, "code" => "304", "message" => "Order ID not found"];

        switch ($status) {
            case $states[1]:
                
                if($order->status != $states[0])
                    return ["data" => false, "code" => "304", "message" => "status incompatible with current status"];

                if($technical_id == null)
                    return ["data" => false, "code" => "304", "message" => "technical_id is required on status 'En Proceso'"];

                $order->technical_id = $technical_id;

                break;
            case $states[2]:
            
                if($order->status != $states[1])
                    return ["data" => false, "code" => "304", "message" => "status incompatible with current status"];

                break;            
            case $states[3]:
        
                if($order->status != $states[1] && $order->status != $states[2])
                    return ["data" => false, "code" => "304", "message" => "status incompatible with current status"];

                break;  

            default:
                return ["data" => false, "code" => "304", "message" => "Incorrect Status"];
                break;
        }
        
        $order->status = $status;
        $order->technical_notes .= " " . $technical_notes;
        $order->save();

        return ["data" => $order, "code" => "200", "message" => "Chido"];
    }
}
