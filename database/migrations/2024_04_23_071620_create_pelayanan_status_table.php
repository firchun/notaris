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
        Schema::create('pelayanan_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelayanan');
            $table->foreignId('id_staff');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_pelayanan')->references('id')->on('pelayanan');
            $table->foreign('id_staff')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelayanan_status');
    }
};
