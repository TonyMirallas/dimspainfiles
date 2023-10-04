<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $customer_id
 * @property int $contact_id
 * @property int $user_id
 * @property string $state
 * @property int $discount
 * @property string $payment
 * @property string $iva
 * @property string $code
 * @property float $subtotal
 * @property float $total
 * @property float $observations
 * @property string $finished_at
 * @property User $user
 * @property Contact $contact
 * @property Customer $customer
 * @property InvoiceProduct[] $invoiceProducts
 */
class Invoice extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'invoice';

    /**
     * @var array
     */
    protected $fillable = ['customer_id', 'contact_id', 'user_id', 'state', 'discount', 'payment', 'iva', 'code', 'subtotal', 'total', 'observations', 'finished_at'];

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
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'discount', 'quantity', 'subtotal', 'total');
    }

    // Check if invoice exists
    public static function checkInvoice($id){

        $invoice = Invoice::find($id);

        if($invoice == null)
            return false;

        $invoice->user;
        $invoice->customer;
        $invoice->contacts;
        $invoice->products;

        return $invoice;
    }
}
