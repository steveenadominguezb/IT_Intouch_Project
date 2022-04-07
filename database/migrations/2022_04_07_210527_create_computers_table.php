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
        Schema::create('computers', function (Blueprint $table) {
            $table->string('SerialNumber')->unique();
            $table->string('HostName')->unique();
            $table->boolean('Laptop');
            $table->string('Model');
            $table->string('OS');
            $table->string('Brand');
            $table->string('Status');
            $table->timestamps();

            $table->primary('SerialNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computers');
    }
};
