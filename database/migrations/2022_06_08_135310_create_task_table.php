<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('user_id')->nullable()->index('task_FK_3');
            $table->unsignedBigInteger('from_user_id')->nullable()->index('task_FK_4');
            $table->integer('customer_id')->nullable()->index('task_FK_2');
            $table->integer('contact_id')->nullable()->index('task_FK');
            $table->integer('from_contact_id')->nullable()->index('task_FK_1');
            $table->string('channel', 50)->nullable();
            $table->string('objetive', 200)->nullable();
            $table->string('state', 20)->nullable();
            $table->text('description')->nullable();
            $table->json('relation')->nullable();
            $table->text('result')->nullable();
            $table->dateTime('finished_at')->nullable();
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
        Schema::dropIfExists('task');
    }
}
