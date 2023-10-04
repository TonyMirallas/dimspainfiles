<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('customer_id')->nullable()->index('customer_product_FK'); 
            $table->string('product_id')->nullable()->index('customer_product_FK_1');
            $table->float('price')->nullable()->default(0);
            $table->float('discount', 10, 0)->nullable()->default(0)->comment('Discount for the Product and Customer');
            $table->boolean('active')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product');
    }
}
