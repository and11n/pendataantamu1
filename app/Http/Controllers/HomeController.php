<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KedatanganTamu;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // public function kunjungan()
    // {
    //     $tamuBelumDatang = Tamu::where('status', 'belum datang')->count();
    //     $tamuSelesai = Tamu::where('status', 'selesai')->count();
    //     $tamuGagal = Tamu::where('status', 'gagal')->count();

    //     // Pass the variables to the view
    //     return view('admin.kunjungan', compact('tamuBelumDatang', 'tamuSelesai', 'tamuGagal'));
    // }

    public function kunjunganSearch()
    {
        return view('admin.kunjungan');
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function laporanSearchTamu()
    {
        return view('admin.laporan');
    }

    public function laporanKurir()
    {
        return view('admin.laporanKurir');
    }

    public function laporanSearchKurir()
    {
        return view('admin.laporanKurir');
    }

    public function pegawaiLaporan()
    {
        return view('pegawai.laporan');
    }

    public function pegawaiLaporanKurir()
    {
        return view('pegawai.laporanKurir');
    }

    public function pegawaiLaporanSearchKurir()
    {
        return view('pegawai.laporanKurir');
    }

    public function pegawaiKunjungan(Request $request)
    {
        // Hitung jumlah tamu berdasarkan status "belum datang", "selesai", dan "gagal"
        $tamuBelumDatang = KedatanganTamu::where('status', 'belum datang')->count();
        $tamuSelesai = KedatanganTamu::where('status', 'selesai')->count();
        $tamuGagal = KedatanganTamu::where('status', 'gagal')->count();

        // Definisikan variabel diterima, ditolak, dan menunggu
        $diterima = KedatanganTamu::where('status', 'diterima')->count();
        $ditolak = KedatanganTamu::where('status', 'ditolak')->count();
        $menunggu = KedatanganTamu::where('status', 'menunggu')->count();

        // Ambil query parameter status dari request
        $status = $request->query('status');

        // Filter data berdasarkan status
        if ($status) {
            $pegawaiKunjungan = KedatanganTamu::with('tamu')
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $pegawaiKunjungan = KedatanganTamu::with('tamu')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Menghitung persentase
        $total = $diterima + $ditolak + $menunggu;
        $diterimaPersen = $total > 0 ? ($diterima / $total) * 100 : 0;
        $ditolakPersen = $total > 0 ? ($ditolak / $total) * 100 : 0;
        $menungguPersen = $total > 0 ? ($menunggu / $total) * 100 : 0;

        // Passing data ke view
        return view('pegawai.kunjungan', compact('diterima', 'ditolak', 'menunggu', 'diterimaPersen', 'ditolakPersen', 'menungguPersen', 'pegawaiKunjungan', 'tamuBelumDatang', 'tamuSelesai', 'tamuGagal'));
    }
}
