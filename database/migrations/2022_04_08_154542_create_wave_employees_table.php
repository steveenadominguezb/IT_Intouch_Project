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
        Schema::create('wave_employees', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->date('Date');
            $table->boolean('T&IHeadSet');
            $table->boolean('T&ICamera');
            $table->timestamps();

            $table->bigInteger('IdWave');
            $table->string('cde');
            $table->string('SerialNumberKey')->nullable();
            $table->string('SerialNumberComputer');
            $table->unsignedBigInteger('IdLocation');
            

            $table->foreign('IdWave')->references('IdWave')->on('waves');
            $table->foreign('cde')->references('cde')->on('users');
            $table->foreign('SerialNumberKey')->references('SerialNumber')->on('yubikeys');
            $table->foreign('SerialNumberComputer')->references('SerialNumber')->on('computers');
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
        Schema::dropIfExists('wave_employees');
    }
};
