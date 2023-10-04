<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInvoiceProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->foreign(['invoice_id'], 'invoice_product_FK')->references(['id'])->on('invoice')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['product_id'], 'invoice_product_FK_1')->references(['id'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->dropForeign('invoice_product_FK');
            $table->dropForeign('invoice_product_FK_1');
        });
    }
}
