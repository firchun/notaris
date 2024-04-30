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
        Schema::create('pembayaran_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelayanan');
            $table->foreignId('id_staff');
            $table->integer('total');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('id_staff')->references('id')->on('users');
            $table->foreign('id_pelayanan')->references('id')->on('pelayanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_pelayanan');
    }
};
