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
        Schema::create('waves', function (Blueprint $table) {
            $table->bigInteger('IdWave')->autoIncrement();
            $table->string('Name');
            $table->date('StartDate');
            $table->string('ItopsInspector');
            $table->boolean('Return')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('IdProgram');

            $table->foreign('IdProgram')->references('IdProgram')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waves');
    }
};
