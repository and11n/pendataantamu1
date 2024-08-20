<?php

namespace App\Http\Controllers;

use App\Models\KedatanganEkspedisi;
use App\Models\KedatanganTamu;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // today time
        $today = now()->format('Y-m-d');
        // this month
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');
        //the statistic data
        $countKurirHari = KedatanganEkspedisi::whereDate('created_at', $today)->count();
        $countTamuHari = KedatanganTamu::whereDate('created_at', $today)->count();
        $countKurirBulan = KedatanganEkspedisi::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $endOfMonth)->count();
        $countTamuBulan = KedatanganTamu::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $endOfMonth)->count();
        // Data Chart
        function getPastSixDaysName(): array
        {
            $today = new DateTime();
            $days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];

            $daysOfWeek = [];
            for ($i = 0; $i < 6; $i++) {
                $pastDate = clone $today; // Create a copy to avoid modifying the original object
                $pastDate->sub(new DateInterval("P{$i}D")); // Subtract $i days
                $daysOfWeek[] = $days[$pastDate->format('w')]; // Convert timestamp to milliseconds
            }

            return $daysOfWeek;
        }
        $today = now();
        $tamu = [];
        for ($i = 0; $i < 6; $i++) {
            $tamuTemp = KedatanganTamu::whereDate("created_at", $today)->count();
            $tamu[] = $tamuTemp;
            $today->subDay();
        }
        $kurir = [];
        $today = now();

        for ($i = 0; $i < 6; $i++) {
            $kurirTemp = KedatanganEkspedisi::whereDate("created_at", $today)->count();
            $kurir[] = $kurirTemp;
            $today->subDay();
        }
        $days = getPastSixDaysName();
        $chartData = [
            "kurir" => $kurir,
            "tamu" => $tamu,
            "labels" => $days,
        ];
        // dd($chartData);
        return view("admin.dashboard", compact("countKurirHari", "countTamuHari", "countTamuBulan", "countKurirBulan", "chartData"));
    }

    public function loginui()
    {
        return view("signin");

    }
}
