<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_interest', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('interest_id')->nullable()->index('customer_interest_FK_1');
            $table->integer('customer_id')->nullable()->index('customer_interest_FK');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_interest');
    }
}
