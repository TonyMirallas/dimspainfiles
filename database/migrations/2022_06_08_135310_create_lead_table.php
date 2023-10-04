<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadTable extends Migration
{
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     Schema::create('lead', function (Blueprint $table) {
    //         $table->integer('id', true);
    //         $table->string('name', 100);
    //         $table->string('fiscal_name', 100)->nullable();
    //         $table->string('cif', 15)->nullable();
    //         $table->string('pc', 15)->nullable();
    //         $table->string('address', 200)->nullable();
    //         $table->string('country', 25)->nullable();
    //         $table->string('province', 25)->nullable();
    //         $table->string('city', 25)->nullable();
    //         $table->string('acquisition', 50)->nullable();
    //         $table->text('observations')->nullable();
    //         $table->dateTime('updated_at')->nullable();
    //         $table->dateTime('created_at')->nullable();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead');
    }
}
