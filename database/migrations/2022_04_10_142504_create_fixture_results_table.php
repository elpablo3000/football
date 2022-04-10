<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_results', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->integer('week_number');
            $table->integer('played');
            $table->integer('won');
            $table->integer('drawn');
            $table->integer('loosed');
            $table->integer('goal_difference');
            $table->integer('predictions');
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
        Schema::dropIfExists('fixture_results');
    }
};
