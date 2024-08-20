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
        Schema::create('pegawais', function (Blueprint $table) {
                $table->string('nip')->primary();

                $table->unsignedBigInteger('id_user');
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

                $table->string('no_telp');
                $table->string('ptk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
