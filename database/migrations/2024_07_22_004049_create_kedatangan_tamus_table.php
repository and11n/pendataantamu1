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
        Schema::create('kedatangan_tamus', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai');
            $table->string('id_tamu');
            $table->foreign('id_tamu')->references('id_tamu')->on('tamus');
            // $table->unsignedBigInteger('id_user');
            $table->string('instansi');
            $table->text('tujuan');
            $table->text('qr_code')->nullable();
            $table->dateTime('waktu_perjanjian');
            $table->dateTime('waktu_kedatangan')->nullable();
            $table->text('foto')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'tidakDatang'])->default('menunggu');
            // $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_pegawai')->references('nip')->on('pegawais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kedatangan_tamus');
    }
};
