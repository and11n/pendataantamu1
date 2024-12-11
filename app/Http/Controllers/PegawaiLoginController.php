<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\KedatanganTamu;
use App\Models\KedatanganEkspedisi;
use App\Models\Pegawai;



class PegawaiLoginController extends Controller
{
    public function index(Request $request)
    {
        $queryTamu = KedatanganTamu::where('waktu_kedatangan', '!=', null);
        $queryEkspedisi = KedatanganEkspedisi::where('waktu_kedatangan', '!=', null);

        $user_id = Auth::user()->id;

        // Menghitung jumlah tamu dan kurir hari ini
        $pegawai = Pegawai::where('id_user', $user_id)->first();

        $nip = $pegawai->nip;

        $totalTamuPegawai = KedatanganTamu::where('id_pegawai', $nip)
        ->whereMonth('created_at', Carbon::now()->month) // Use whereMonth to filter by month
        ->count();

        $totalKurirPegawai = KedatanganEkspedisi::where('id_pegawai', $nip)
        ->whereMonth('created_at', Carbon::now()->month) // Use whereMonth to filter by month
        ->count();

        // Data Chart
        // Mendapatkan data untuk 12 bulan dalam tahun ini
        $selectedMonth = $request->bulan ?? now()->month;
        $startOfMonth = Carbon::create(null, $selectedMonth)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;
        $months = [];
        $tamu = [];
        $kurir = [];

        // Mengisi data untuk setiap hari dalam bulan ini
        for ($i = 0; $i < $daysInMonth; $i++) {
            // Format nama hari
            $currentDate = $startOfMonth->copy()->addDays($i); // Menggunakan copy untuk tidak mengubah $startOfMonth
            $months[] = $currentDate->format('d M'); // Format tanggal

            // Ambil jumlah tamu dan kurir per hari, default ke 0 jika tidak ada data
            $tamuCount = KedatanganTamu::whereDate('created_at', $currentDate)->count();
            $kurirCount = KedatanganEkspedisi::whereDate('created_at', $currentDate)->count();

            $tamu[] = $tamuCount > 0 ? $tamuCount : 0; // Menyimpan jumlah tamu, default ke 0
            $kurir[] = $kurirCount > 0 ? $kurirCount : 0; // Menyimpan jumlah kurir, default ke 0
        }

        // Menyusun data grafik
        $chartData = [
            "kurir" => $kurir,
            "tamu" => $tamu,
            "labels" => $months,
        ];

        if ($request->has('bulan') && $request->bulan != 'all') {
            $queryTamu->whereMonth('created_at', $selectedMonth);
            $queryEkspedisi->whereMonth('created_at', $selectedMonth);
        }

        $tamuDatang = KedatanganTamu::where('id_pegawai', $nip)
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuMenunggu = KedatanganTamu::where('id_pegawai', $nip)
            ->where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuDitolak = KedatanganTamu::where('id_pegawai', $nip)
            ->where('status', 'ditolak')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $kurirHari = KedatanganEkspedisi::where('id_pegawai', $nip)
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Filter berdasarkan hari ini saja
        $selesai = KedatanganTamu::where('status', 'diterima')
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->filter(function ($item) {
                return $item->waktu_kedatangan !== null
                    && $item->waktu_perjanjian !== null
                    && Carbon::parse($item->waktu_kedatangan)->isToday();
            });

        return view('pegawai.dashboard', compact('totalTamuPegawai', 'totalKurirPegawai', 'chartData', 'tamuDatang', 'tamuMenunggu', 'tamuDitolak', 'kurirHari', 'selesai'));
    }

    public function loginPage()
    {
        if (Auth::guard('pegawai')->check()) {
            return redirect(route('pegawai.dashboard'));
        } elseif (Auth::check()) {
            return redirect(route('dashboard'));
        }
        return view('pegawai.signin');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::guard('pegawai')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // dd($request->email);
            return redirect()->route('pegawai.dashboard');
        }
        // dd($request->all());
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    public function destroy()
    {
        Auth::guard('pegawai')->logout();
        return redirect()->route('pegawai.login');
    }
}
