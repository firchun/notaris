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
        Schema::create('formulir_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelayanan');
            $table->foreignId('id_formulir_layanan');
            $table->string('isi_formulir');
            $table->timestamps();

            $table->foreign('id_pelayanan')->references('id')->on('pelayanan');
            $table->foreign('id_formulir_layanan')->references('id')->on('layanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulir_pelayanan');
    }
};
