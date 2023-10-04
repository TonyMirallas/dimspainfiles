<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task', function (Blueprint $table) {
            $table->foreign(['contact_id'], 'task_FK')->references(['id'])->on('contact')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['from_contact_id'], 'task_FK_1')->references(['id'])->on('contact')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'task_FK_2')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['from_user_id'], 'task_FK_3')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task', function (Blueprint $table) {
            $table->dropForeign('task_FK');
            $table->dropForeign('task_FK_1');
            $table->dropForeign('task_FK_2');
            $table->dropForeign('task_FK_3');
        });
    }
}
