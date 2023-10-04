<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->foreign(['contact_id'], 'invoice_FK')->references(['id'])->on('contact')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['customer_id'], 'invoice_FK_1')->references(['id'])->on('customer')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'invoice_FK_2')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign('invoice_FK');
            $table->dropForeign('invoice_FK_1');
            $table->dropForeign('invoice_FK_2');
        });
    }
}
