<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id')->index('invoice_product_FK');
            $table->string('product_id', 100)->index('invoice_product_FK_1');
            $table->float('price', 10, 0)->nullable();
            $table->float('discount', 10, 0)->nullable()->default(0)->comment('Discount for the product');
            $table->integer('quantity')->default(1);
            $table->float('subtotal', 10, 0)->nullable();
            $table->float('total', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_product');
    }
}
