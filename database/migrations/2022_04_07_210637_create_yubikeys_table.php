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
        Schema::create('yubikeys', function (Blueprint $table) {
            $table->string('SerialNumber')->unique();
            $table->string('PrivateIdentify');
            $table->string('SecretKey');

            $table->primary('SerialNumber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yubikeys');
    }
};
