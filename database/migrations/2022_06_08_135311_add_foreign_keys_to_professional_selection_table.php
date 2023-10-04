<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProfessionalSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professional_selection', function (Blueprint $table) {
            $table->foreign(['professional_id'], 'professionalselection_FK')->references(['id'])->on('professional')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['selection_id'], 'professionalselection_FK_1')->references(['id'])->on('selection')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professional_selection', function (Blueprint $table) {
            $table->dropForeign('professionalselection_FK');
            $table->dropForeign('professionalselection_FK_1');
        });
    }
}
