<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
{
    foreach ($rows as $row) {
        // Membuat user baru dengan metode create
        // dd($row);
        $user = User::create([
            'nama_user' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make('12345678'),
        ]);

        // Menggunakan id dari user yang baru saja dibuat
        Pegawai::create([
            'nip' => $row['nip'],
            'id_user' => $user->id, // Mengakses id dari instance user
            'ptk' => $row['ptk'],
            'no_telp' => $row['no_telp'],
        ]);
    }
}
}
