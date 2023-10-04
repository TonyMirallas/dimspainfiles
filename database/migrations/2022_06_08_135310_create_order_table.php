<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('notes')->nullable();
            $table->string('status', 50)->nullable();
            $table->json('options')->nullable();
            $table->string('professional_file', 200)->nullable()->comment('File sent by professional');
            $table->string('technical_file', 200)->nullable()->comment('File sent by technical');
            $table->integer('technical_id')->nullable()->index('order_FK');
            $table->string('shw_file', 200)->nullable();
            $table->integer('professional_id')->index('order_FK_1');
            $table->string('type', 100)->nullable();
            $table->string('veh_type', 10)->nullable();
            $table->string('manufacture', 50)->nullable();
            $table->integer('year')->nullable();
            $table->string('fuel', 50)->nullable();
            $table->float('kw', 10, 0)->nullable();
            $table->string('emission', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->text('technical_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
