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
    public function index()
    {
        // Menghitung jumlah tamu hari ini
        $countTamuHari = KedatanganTamu::whereDate('created_at', Carbon::today())->count();

        // Menghitung jumlah kurir hari ini (jika diperlukan)
        $countKurirHari = KedatanganEkspedisi::whereDate('created_at', Carbon::today())->count();

        $countGuru = Pegawai::count();
        // dd($countGuru);

        // $countTendik = Pegawai::count();

        // Kirim variabel ke view
        return view('pegawai.dashboard', compact('countTamuHari', 'countKurirHari', 'countGuru'));
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
