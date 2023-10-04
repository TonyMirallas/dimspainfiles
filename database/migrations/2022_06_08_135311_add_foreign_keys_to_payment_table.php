<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->foreign(['order_id'], 'payment_FK_4')->references(['id'])->on('order')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['distributor_id'], 'payment_FK_5')->references(['id'])->on('distributor')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['professional_id'], 'payment_FK_6')->references(['id'])->on('professional')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign('payment_FK_4');
            $table->dropForeign('payment_FK_5');
            $table->dropForeign('payment_FK_6');
        });
    }
}
