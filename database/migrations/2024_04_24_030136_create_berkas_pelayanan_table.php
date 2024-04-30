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
        Schema::create('berkas_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelayanan');
            $table->foreignId('id_berkas_layanan');
            $table->string('berkas');
            $table->timestamps();

            $table->foreign('id_pelayanan')->references('id')->on('pelayanan');
            $table->foreign('id_berkas_layanan')->references('id')->on('berkas_layanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas_pelayanan');
    }
};
