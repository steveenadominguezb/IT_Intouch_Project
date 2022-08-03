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
        Schema::create('attritions', function (Blueprint $table) {
            $table->id();
            $table->string('cde');
            $table->unsignedBigInteger('IdProgram');
            $table->boolean('hardware');
            $table->string('SerialNumber');
            $table->string('wfs-attrition');
            $table->string('hardware_returned');
            $table->date('attrition_date');
            $table->date('tested_date')->nullable();
            $table->string('NewSerialNumber')->nullable();
            $table->string('comments');
            $table->timestamps();

            $table->foreign('cde')->references('cde')->on('users');
            $table->foreign('IdProgram')->references('IdProgram')->on('programs');
            $table->foreign('SerialNumber')->references('SerialNumber')->on('computers');
            $table->foreign('NewSerialNumber')->references('SerialNumber')->on('computers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attritions');
    }
};
