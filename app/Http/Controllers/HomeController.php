<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function kunjungan()
    {
        return view('admin.kunjungan');
    }
    public function pegawaiKunjungan()
    {
        return view('pegawai.kunjungan');
    }

    public function kunjunganSearch()
    {
        return view('admin.kunjungan');
    }

    public function laporan()
    {
        return view('admin.laporan');
    }
    public function pegawaiLaporan()
    {
        return view('pegawai.laporan');
    }

    public function laporanSearchTamu()
    {
        return view('admin.laporan');
    }

    public function laporanKurir()
    {
        return view('admin.laporanKurir');
    }
    public function pegawaiLaporanKurir()
    {
        return view('pegawai.laporanKurir');
    }

    public function laporanSearchKurir()
    {
        return view('admin.laporanKurir');
    }
    public function pegawaiLaporanSearchKurir()
    {
        return view('pegawai.laporanKurir');
    }
}
