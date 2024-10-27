<?php

namespace App\Http\Controllers;

use App\Models\KedatanganEkspedisi;
use App\Models\KedatanganTamu;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pegawai;

class AdminController extends Controller
{
public function index(Request $request)
    {
        $queryTamu = KedatanganTamu::where('waktu_kedatangan', '!=', null);
        $queryEkspedisi = KedatanganEkspedisi::where('waktu_kedatangan', '!=', null);

        // Menghitung jumlah tamu dan kurir hari ini
        $countTamuBulan = KedatanganTamu::whereMonth('created_at', Carbon::now()->month)->count();
        $countKurirBulan = KedatanganEkspedisi::whereMonth('created_at', Carbon::now()->month)->count();

        // Menghitung jumlah guru
        $countGuru = Pegawai::count();

        // Data Chart - Mendapatkan data untuk bulan tertentu atau default ke bulan ini
        $selectedMonth = $request->bulan ?? now()->month;
        $startOfMonth = Carbon::create(null, $selectedMonth)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;
        $months = [];
        $tamu = [];
        $kurir = [];

        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDate = $startOfMonth->copy()->addDays($i);
            $months[] = $currentDate->format('d M');

            $tamuCount = KedatanganTamu::whereDate('created_at', $currentDate)->count();
            $kurirCount = KedatanganEkspedisi::whereDate('created_at', $currentDate)->count();

            $tamu[] = $tamuCount;
            $kurir[] = $kurirCount;
        }

        // Menyusun data grafik
        $chartData = [
            "kurir" => $kurir,
            "tamu" => $tamu,
            "labels" => $months,
        ];

        // Filter the visitor data by month if selected
        if ($request->has('bulan') && $request->bulan != 'all') {
            $queryTamu->whereMonth('created_at', $selectedMonth);
            $queryEkspedisi->whereMonth('created_at', $selectedMonth);
        }

        $tamuDatang = KedatanganTamu::where('status','diterima')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuMenunggu = KedatanganTamu::where('status','menunggu')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuDitolak = KedatanganTamu::where('status','ditolak')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $kurirHari = KedatanganEkspedisi::whereDate('created_at', Carbon::today())->get();

        return view('admin.dashboard', compact('countTamuBulan', 'countKurirBulan', 'countGuru', 'chartData', 'tamuDatang', 'tamuMenunggu', 'tamuDitolak', 'kurirHari'));
    }



    // private function getPastSixDaysName(): array
    // {
    //     $today = new DateTime();
    //     $days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];

    //     $daysOfWeek = [];
    //     for ($i = 0; $i < 6; $i++) {
    //         $pastDate = clone $today; // Create a copy to avoid modifying the original object
    //         $pastDate->sub(new DateInterval("P{$i}D")); // Subtract $i days
    //         $daysOfWeek[] = $days[$pastDate->format('w')]; // Convert timestamp to milliseconds
    //     }

    //     return $daysOfWeek;
    // }

    public function loginui()
    {
        return view("signin");
    }
}
