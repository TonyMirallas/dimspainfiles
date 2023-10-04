<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_option', function (Blueprint $table) {
            $table->foreign(['option_id'], 'orderoption_FK')->references(['id'])->on('option')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['order_id'], 'orderoption_FK_1')->references(['id'])->on('order')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_option', function (Blueprint $table) {
            $table->dropForeign('orderoption_FK');
            $table->dropForeign('orderoption_FK_1');
        });
    }
}
