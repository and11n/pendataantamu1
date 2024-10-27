<?php

namespace App\Exports;

use App\Models\KedatanganTamu;
use Maatwebsite\Excel\Concerns\FromCollection;

class LapAdminExport implements FromCollection
{
    public function collection()
    {
        return KedatanganTamu::with(['tamu', 'pegawai.user'])->get(); // Ambil semua data dari model
    }
}
