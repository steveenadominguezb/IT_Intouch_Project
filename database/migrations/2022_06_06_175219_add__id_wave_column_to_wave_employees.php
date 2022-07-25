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
        Schema::table('wave_employees', function (Blueprint $table) {
            $table->bigInteger('IdWave');
            $table->foreign('IdWave')->references('IdWaveLocation')->on('wave_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wave_employees', function (Blueprint $table) {
            //
        });
    }
};
