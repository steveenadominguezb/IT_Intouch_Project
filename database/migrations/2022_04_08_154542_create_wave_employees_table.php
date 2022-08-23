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
            $table->date('Date')->default(now());
            $table->boolean('T&IHeadSet')->default(true);
            $table->boolean('T&ICamera')->default(true);
            $table->timestamps();


            $table->string('cde')->nullable();
            $table->boolean('attrition')->nullable()->default(false);
            $table->string('SerialNumberKey')->nullable();
            $table->string('SerialNumberComputer')->nullable();


            $table->foreign('cde')->references('cde')->on('users')->onUpdate('cascade');
            $table->foreign('SerialNumberKey')->references('SerialNumber')->on('yubikeys')->onUpdate('cascade');
            $table->foreign('SerialNumberComputer')->references('SerialNumber')->on('computers')->onUpdate('cascade');
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
