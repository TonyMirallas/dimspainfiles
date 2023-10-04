<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sage_id', 100)->nullable();
            $table->string('company_id', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('commercial_name', 100)->nullable();
            $table->string('email', 500)->nullable();
            $table->string('code', 20)->nullable();
            $table->boolean('active')->nullable()->default(false);
            $table->string('tax_number', 15)->nullable();
            $table->text('notes')->nullable();
            $table->string('legal_representative_name', 100)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('pc', 15)->nullable()->comment('Postal code');
            $table->string('phone', 20)->nullable();
            $table->string('acquisition', 15)->nullable()->comment('Email | Google');
            $table->string('type', 50)->nullable()->default("lead")->comment('lead | customer');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
