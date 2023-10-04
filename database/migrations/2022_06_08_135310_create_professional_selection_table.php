<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_selection', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('selection_id', 20)->nullable()->index('professionalselection_FK_1');
            $table->integer('professional_id')->nullable()->index('professionalselection_FK');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professional_selection');
    }
}
