<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCustomerInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'interest_customer_FK')->references(['id'])->on('customer')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['interest_id'], 'interest_customer_FK_1')->references(['id'])->on('interest')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->dropForeign('interest_customer_FK');
            $table->dropForeign('interest_customer_FK_1');
        });
    }
}
