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
            $table->integer('api_id');
            $table->string('name');
            $table->string('abbreviation');
            $table->string('conference');
            $table->integer('games_played');
            $table->integer('points');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('overtime_losses');
            $table->integer('regulation_overtime_wins');
            $table->integer('division_ranking');
            $table->decimal('points_percentage');
            $table->string('last_ten_record');
            $table->string('streak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
