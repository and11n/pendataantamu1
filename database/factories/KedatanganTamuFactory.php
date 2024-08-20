<?php

namespace Database\Factories;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KedatanganTamu>
 */
class KedatanganTamuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static ?string $status;
    public function definition(): array
    {
        return [
            "id_pegawai" => Pegawai::factory(),
            "id_user" => User::factory(),
            "nama" => fake()->name,
            "alamat" => fake()->address,
            "no_telp" => fake()->e164PhoneNumber(),
            "email" => fake()->email,
            "tujuan" => fake()->paragraph(10, true),
            "waktu_perjanjian" => fake()->dateTime(),
            "status" => static::$status ??= fake()->randomElement(["menunggu", "ditolak", "diterima", "tidakDatang"]),
            "instansi" => fake()->company()

        ];
    }
}
