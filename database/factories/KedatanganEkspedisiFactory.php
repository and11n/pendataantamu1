<?php

namespace Database\Factories;

use App\Models\Ekspedisi;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KedatanganEkspedisi>
 */
class KedatanganEkspedisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama_kurir" => fake()->name,
            "foto" => null,
            "id_ekspedisi" => Ekspedisi::factory(),
            "id_pegawai" => Pegawai::factory(),
            "id_user" => User::factory(),
        ];
    }
}
