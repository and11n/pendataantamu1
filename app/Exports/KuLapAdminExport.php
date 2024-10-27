<?php

namespace App\Exports;

use App\Models\KedatanganEkspedisi;
use Maatwebsite\Excel\Concerns\FromCollection;

class KuLapAdminExport implements FromCollection
{
    public function collection()
    {
        return KedatanganEkspedisi::with(['pegawai.user', 'ekspedisi'])->get(); // Ambil semua data dari model
    }
}
