<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('name', 100);
            $table->string('code', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->boolean('active')->default(false);
            $table->float('price', 10, 0)->nullable();
            $table->string('family', 50)->nullable();
            $table->string('family_code', 50)->nullable();
            $table->integer('stock')->nullable();
            $table->string('company_id', 300)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
