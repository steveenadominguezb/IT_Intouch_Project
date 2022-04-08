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
        Schema::create('monitor_waves', function (Blueprint $table) {
            $table->id();
            $table->string('SerialNumber');
            $table->bigInteger('IdWaveEmployee');
            $table->timestamps();

            $table->foreign('SerialNumber')->references('SerialNumber')->on('monitors');
            $table->foreign('IdWaveEmployee')->references('id')->on('wave_employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitor_waves');
    }
};
