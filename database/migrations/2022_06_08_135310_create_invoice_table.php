<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->nullable()->index('invoice_FK_3')->comment('ID from actual technical but future commercial');
            $table->integer('customer_id')->nullable()->index('invoice_FK_2')->comment('Invoice from Sage client or Lead');
            $table->integer('contact_id')->nullable()->index('invoice_FK')->comment('Whom invoice is sent');
            $table->string('state', 25)->nullable()->default('on hold')->comment('on hold, cancelled, approved');
            $table->integer('discount')->nullable()->default(0);
            $table->string('payment', 50)->nullable()->default('cash')->comment('Cash, transfer, credit card');
            $table->integer('iva')->default(0);
            $table->string('code', 20)->nullable();
            $table->float('subtotal', 10, 0)->nullable()->default(0)->comment('Total before discount and prodcuts discounts');
            $table->float('total', 10, 0)->nullable()->default(0);
            $table->text('observations')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
