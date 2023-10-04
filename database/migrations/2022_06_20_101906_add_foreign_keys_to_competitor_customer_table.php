<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompetitorCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competitor_customer', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'competitor_customer_FK')->references(['id'])->on('customer')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['competitor_id'], 'competitor_customer_FK_1')->references(['id'])->on('competitor')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competitor_customer', function (Blueprint $table) {
            $table->dropForeign('competitor_customer_FK');
            $table->dropForeign('competitor_customer_FK_1');
        });
    }
}
