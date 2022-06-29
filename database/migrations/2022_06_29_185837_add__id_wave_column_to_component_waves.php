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
        Schema::table('component_waves', function (Blueprint $table) {
            $table->bigInteger('IdWaveLocation');
            $table->foreign('IdWaveLocation')->references('IdWaveLocation')->on('wave_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('component_waves', function (Blueprint $table) {
        });
    }
};
