<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional', function (Blueprint $table) {
            $table->integer('id', true);
            $table->boolean('state')->nullable();
            $table->string('user', 10)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('province', 20)->nullable();
            $table->string('town', 20)->nullable();
            $table->string('address', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('company', 100)->nullable();
            $table->string('cif', 15)->nullable();
            $table->integer('distributor_id')->nullable()->index('professional_FK');
            $table->string('type', 100)->nullable()->comment('The system to process this professional');
            $table->string('tax_company', 100)->nullable();
            $table->string('initial_invoice', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professional');
    }
}
