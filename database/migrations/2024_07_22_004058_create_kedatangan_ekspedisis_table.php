<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kedatangan_ekspedisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kurir');
            $table->string('id_ekspedisi');
            $table->string('id_pegawai');
            $table->unsignedBigInteger('id_user');
            $table->text('foto')->nullable();
            $table->dateTime('tanggal_waktu');

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_ekspedisi')->references('id_ekspedisi')->on('ekspedisis');
            $table->foreign('id_pegawai')->references('nip')->on('pegawais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kedatangan_ekspedisis');
    }
};
