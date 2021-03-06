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
        Schema::create('component_waves', function (Blueprint $table) {
            $table->id();
            $table->integer('Lot');
            $table->timestamps();
            $table->unsignedBigInteger('IdComponent');

            $table->foreign('IdComponent')->references('IdComponent')->on('components');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_waves');
    }
};
