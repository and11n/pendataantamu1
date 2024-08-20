<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontOfficeController extends Controller
{
    public function index()
    {
        return view('frontoffice.dashboard');
    }
    public function loginPage()
    {
        if (Auth::guard('fo')->check()) {
            return redirect(route('frontoffice.dashboard'));
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
        if (Auth::guard('fo')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // dd($request->email);
            return redirect()->route('frontoffice.dashboard');
        }
        // dd($request->all());
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    public function destroy()
    {
        Auth::guard('fo')->logout();
        return redirect()->route('pegawai.login');
    }
}
