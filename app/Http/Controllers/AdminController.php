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

        $selectedYear = $request->tahun ?? now()->year;
        $tamu = [];
        $kurir = [];
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            // Membuat tanggal awal dan akhir untuk bulan yang dipilih dalam satu tahun
            $startOfMonth = Carbon::create($selectedYear, $month)->startOfMonth();
            $endOfMonth = Carbon::create($selectedYear, $month)->endOfMonth();

            // Mengambil jumlah data tamu dan kurir untuk bulan ini
            $tamuCount = KedatanganTamu::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $kurirCount = KedatanganEkspedisi::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

            $tamu[] = $tamuCount;
            $kurir[] = $kurirCount;
            $months[] = $startOfMonth->format('F'); // Nama bulan (Januari, Februari, Maret, dst.)
        }

        // Menyusun data grafik
        $chartData = [
            "kurir" => $kurir,
            "tamu" => $tamu,
            "labels" => $months,
        ];


        $tamuDatang = KedatanganTamu::where('status', 'diterima')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuMenunggu = KedatanganTamu::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuDitolak = KedatanganTamu::where('status', 'ditolak')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $kurirHari = KedatanganEkspedisi::whereDate('created_at', Carbon::today())->get();

        // Filter berdasarkan hari ini saja
        $selesai = KedatanganTamu::where('status', 'diterima')
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->filter(function ($item) {
                return $item->waktu_kedatangan !== null
                    && $item->waktu_perjanjian !== null
                    && Carbon::parse($item->waktu_kedatangan)->isToday();
            });

        return view('admin.dashboard', compact('countTamuBulan', 'countKurirBulan', 'countGuru', 'chartData', 'tamuDatang', 'tamuMenunggu', 'tamuDitolak', 'kurirHari', 'selesai'));
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
