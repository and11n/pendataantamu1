<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PegawaiImport implements ToCollection, WithStartRow
{
    /**
     * Start import from row 2 (skip header).
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Create a new user with data accessed by index
            $user = User::create([
                'nama_user' => $row[0],  // Assuming 'nama' is in the first column
                'email' => $row[1],      // Assuming 'email' is in the second column
                'password' => Hash::make('12345678'),
            ]);

            // Create a new Pegawai entry
            Pegawai::create([
                'nip' => $row[2],         // Assuming 'nip' is in the third column
                'id_user' => $user->id,   // Use the ID of the user just created
                'ptk' => $row[3],         // Assuming 'ptk' is in the fourth column
                'no_telp' => $row[4],     // Assuming 'no_telp' is in the fifth column
            ]);
        }
    }
}
