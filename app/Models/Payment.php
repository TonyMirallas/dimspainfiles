<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $credits
 * @property string $payment
 * @property string $status
 * @property int $professional_id
 * @property int $order_id
 * @property int $distributor_id
 * @property Order $order
 * @property Distributor $distributor
 * @property Professional $professional
 */
class Payment extends Model
{

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'payment';

    /**
     * @var array
     */
    protected $fillable = ['credits', 'payment', 'status', 'professional_id', 'order_id', 'distributor_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distributor()
    {
        return $this->belongsTo('App\Models\Distributor', 'distributor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo('App\Models\Professional', 'professional_id');
    }

    // Check if Payment exists
    public static function checkPayment($payment_id)
    {
        $payment = Payment::find($payment_id);

        if($payment == null)
            return false;

        return $payment;        
    }

    // Validate payment
    public static function validatePayment($params)
    {
        // Fields on Payment
        $credits = !empty($params['credits']) ? $params['credits'] : null;
        $payment = !empty($params['payment']) ? $params['payment'] : null;
        $status = !empty($params['status']) ? $params['status'] : null;
        $order_id = !empty($params['order_id']) ? $params['order_id'] : null;
        $professional_id = !empty($params['professional_id']) ? $params['professional_id'] : null;
        $distributor_id = !empty($params['distributor_id']) ? $params['distributor_id'] : null;

        // Check fields type
        if(!(is_numeric($credits) && is_string($payment)))
            return ["data" => false, "success" => false, "message_log" => "Incorrect field type"];

        // Check if $payment is in array with payments
        if(!in_array($payment, ['transferencia', 'crédito', 'paypal', 'order', 'refund', 'iniciales', 'otorgados']))
            return ["data" => false, "code" => "305", "message_log" => "Incorrect payment method"];

        // Check if $status is in array with status
        if(!in_array($status, ['Processing', 'Completed', 'Refunded', 'Canceled', 'Pending', 'Requested', 'Accepted']))
            return ["data" => false, "code" => "305", "message_log" => "Incorrect state payment"];            

        if($order_id != null && $params['credits'] >= 0)
            return ["data" => false, "success" => false, "message_log" => "Credits positive on Order Payment"];

        if($credits == null || $payment == null)
            return ["data" => false, "success" => false, "message_log" => "Credits or Payment empty"];

        if($payment == 'transferencia' && $status != 'Pending')
            return ["data" => false, "success" => false, "message_log" => "Payment method is transfer but status is not Pending", "message" => "El pago es incorrecto"];

        $payment = new Payment($params);

        return ["data" => $payment, "success" => true, "message_log" => "Chido"];
    }

    public static function getPayments($params){

        $professional_id = !empty($params['professional_id']) ? $params['professional_id'] : null;
        $distributor_id = !empty($params['distributor_id']) ? $params['distributor_id'] : null;
        $status = !empty($params['status']) ? [$params['status']] : ['Processing', 'Completed', 'Refunded', 'Canceled', 'Pending', 'Requested', 'Accepted'];

        if($professional_id != null && $distributor_id != null)
            $payments = Payment::where('professional_id', $professional_id)->where('distributor_id', $distributor_id)->whereIn('status', $status)->whereNotIn('payment', ["order", "refund"])->get();
        else if($professional_id != null)
            $payments = Payment::where('professional_id', $professional_id)->whereIn('status', $status)->whereNotIn('payment', ["order", "refund"])->get();
        else if($distributor_id != null)
            $payments = Payment::where('distributor_id', $distributor_id)->whereIn('status', $status)->whereNotIn('payment', ["order", "refund"])->get();
        else
            $payments = Payment::whereIn('status', $status)->whereNotIn('payment', ["order", "refund"])->get();
        
        foreach ($payments as $payment){
            $payment->professional;
            $payment->distributor;
        }

        return $payments;

    }

}
