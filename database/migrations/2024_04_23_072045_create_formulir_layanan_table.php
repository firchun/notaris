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
        Schema::create('formulir_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_layanan');
            $table->string('nama_formulir');
            $table->timestamps();

            $table->foreign('id_layanan')->references('id')->on('layanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulir_layanan');
    }
};
