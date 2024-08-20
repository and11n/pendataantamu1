<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiLoginController extends Controller
{
    public function index()
    {
        return view('pegawai.dashboard');
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
