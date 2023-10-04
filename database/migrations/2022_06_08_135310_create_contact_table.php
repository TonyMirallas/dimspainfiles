<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('contact_id', 50)->nullable()->comment('foreign key from customer');
            $table->integer('customer_id')->nullable()->index('contact_FK')->comment('id from contact customer');
            // $table->integer('lead_id')->nullable()->index('contact_FK')->comment('foreign key from lead');
            $table->string('name', 50)->nullable();
            $table->string('email', 500)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('position', 50)->nullable();
            $table->string('channel', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->text('observations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }
}
