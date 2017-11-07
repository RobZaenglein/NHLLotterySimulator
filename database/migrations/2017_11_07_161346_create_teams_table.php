<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('abbreviation');
            $table->string('conference');
            $table->integer('games_played');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('overtime_losses');
            $table->decimal('points_percentage')->index();
            $table->integer('regulation_plus_overtime_wins');
            $table->string('record_last_ten');
            $table->string('streak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
