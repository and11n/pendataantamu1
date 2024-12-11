<?php

namespace App\Http\Controllers;

use App\Models\KedatanganEkspedisi;
use App\Models\KedatanganTamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TamuTrait;
use App\KurirTrait;

class ExportController extends Controller
{
    use TamuTrait;

    public function exportPDFTamu(Request $request)
{
    // Initialize query and apply date filter
    $query = KedatanganTamu::query();
    $query = $this->applyDateFilterTamu($query, $request);
    $titleHeader = $this->headerDateTamu($request);

    // Group by date and count
    $data = $query->select(
            DB::raw('DATE(waktu_perjanjian) as tanggal'),
            DB::raw('COUNT(*) as jumlah_kedatangan')
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    // Generate PDF
    $pdf = Pdf::loadView('frontoffice.laporanTamu', compact('data', 'titleHeader'))
        ->setPaper('a4', 'landscape');

    // Generate filename and return PDF
    $filename = $this->generateFilteredFilename($request, 'laporan-tamu') . '.pdf';
    return $pdf->stream($filename);
}

    public function exportPDFKurir(Request $request)
    {
        // Initialize query
        $query = KedatanganEkspedisi::query();

        // Apply date filters
        $query = $this->applyDateFilterKurir($query, $request);
        $titleHeader = $this->headerDateKurir($request);

        // Group by date and count
        $data = $query->select(
            DB::raw('DATE(waktu_kedatangan) as tanggal'),
            DB::raw('COUNT(*) as jumlah_kedatangan')
        )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('FO.pdf.laporan-tamu', compact('data', 'titleHeader'))
        ->setPaper('a4', 'landscape');

        // Generate filename and return PDF
        $filename = $this->generateFilteredFilenameKurir($request, 'laporan-tamu') . '.pdf';
        return $pdf->download($filename);
    }
}
