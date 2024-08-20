<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ekspedisi;
use App\Models\KedatanganEkspedisi;
use App\Models\KedatanganTamu;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $data = Pegawai::all();
        // foreach ($data as $row) {
        //     $row->password = Hash::make('password');
        //     $row->save();
        // }
        $this->call(
            UserSeeder::class,
        );

    }
}
