<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property boolean $active
 * @property float $price
 * @property string $family
 * @property string $family_code
 * @property int $stock
 * @property string $company_id
 */
class Product extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'product';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'description', 'active', 'price', 'family', 'family_code', 'stock', 'company_id'];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }    

    // Check if product exists
    public static function checkProduct($id){

        $product = Product::find($id);

        if($product == null)
            return false;

        return $product;
    }

}
