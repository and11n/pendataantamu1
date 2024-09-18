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
    public function index()
{
    // Menghitung jumlah tamu dan kurir hari ini
    $countTamuHari = KedatanganTamu::whereDate('created_at', Carbon::today())->count();
    $countKurirHari = KedatanganEkspedisi::whereDate('created_at', Carbon::today())->count();

    // Menghitung jumlah guru
    $countGuru = Pegawai::count();

    // Data Chart
    // Mendapatkan data untuk 12 bulan dalam tahun ini
    $startOfYear = now()->startOfYear(); // Mulai dari awal tahun ini
    $months = [];
    $tamu = [];
    $kurir = [];

    // Mengisi data untuk 12 bulan dari Januari hingga Desember
    for ($i = 0; $i < 12; $i++) {
        // Format nama bulan
        $months[] = $startOfYear->format('F Y');

        // Ambil jumlah tamu dan kurir per bulan
        $tamu[] = KedatanganTamu::whereYear('created_at', $startOfYear->year)
            ->whereMonth('created_at', $startOfYear->month)
            ->count();

        $kurir[] = KedatanganEkspedisi::whereYear('created_at', $startOfYear->year)
            ->whereMonth('created_at', $startOfYear->month)
            ->count();

        // Pindah ke bulan berikutnya
        $startOfYear->addMonth();
    }

    // Menyusun data grafik
    $chartData = [
        "kurir" => $kurir,
        "tamu" => $tamu,
        "labels" => $months,
    ];

    return view('admin.dashboard', compact('countTamuHari', 'countKurirHari', 'countGuru', 'chartData'));
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
