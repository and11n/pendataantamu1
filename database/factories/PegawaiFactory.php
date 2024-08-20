<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "NIP" => fake()->randomNumber(8) . fake()->randomNumber(8),
            "nama" => fake()->name(),
            "email" => fake()->email(),
            "ptk" => fake()->randomElement(['guru', 'tendik']),
            "no_telp" => "+628" . fake()->randomNumber(8) . fake()->randomNumber(2),
            "password" => Hash::make("password"),
        ];
    }
}
