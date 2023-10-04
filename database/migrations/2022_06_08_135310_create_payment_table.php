<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('credits')->nullable();
            $table->string('payment', 50)->nullable();
            $table->integer('professional_id')->nullable()->index('payment_FK_6');
            $table->integer('order_id')->nullable()->index('payment_FK_4');
            $table->integer('distributor_id')->nullable()->index('payment_FK_5');
            $table->string('status', 50);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
