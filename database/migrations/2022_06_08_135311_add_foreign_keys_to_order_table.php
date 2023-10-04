<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->foreign(['technical_id'], 'order_FK')->references(['id'])->on('technical')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['professional_id'], 'order_FK_1')->references(['id'])->on('professional')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeign('order_FK');
            $table->dropForeign('order_FK_1');
        });
    }
}
