<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('host', 100)->nullable();
            $table->string('port', 4)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('encryption', 10)->nullable();
            $table->string('username', 100)->nullable();
            $table->string('password', 400)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('email_FK');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email');
    }
}
