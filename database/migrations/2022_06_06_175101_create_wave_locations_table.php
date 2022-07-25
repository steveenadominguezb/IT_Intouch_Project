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
        Schema::create('wave_locations', function (Blueprint $table) {
            $table->bigInteger('IdWaveLocation')->autoIncrement();
            $table->bigInteger('IdWave');
            $table->unsignedBigInteger('IdLocation');
            $table->timestamps();

            $table->foreign('IdWave')->references('IdWave')->on('waves')->onDelete('cascade');
            $table->foreign('IdLocation')->references('IdLocation')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wave_locations');
    }
};
