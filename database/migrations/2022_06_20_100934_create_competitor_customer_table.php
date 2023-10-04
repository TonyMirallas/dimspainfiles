<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitor_customer', function (Blueprint $table) {
            $table->id();
            $table->integer('competitor_id')->nullable()->index('competitor_customer_FK_1');
            $table->integer('customer_id')->nullable()->index('competitor_customer_FK');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitor_customer');
    }
}
