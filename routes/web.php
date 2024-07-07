<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin', [HomeController::class, 'index'])->name('admin/index');

Route::get('/Kurir', function () {
    return view('lap-kurir');
})->name('kurir');

Route::get('/Tamu', function () {
    return view('lap-tamu');
})->name('tamu');

Route::get('/Pegawai', function () {
    return view('pegawai');
})->name('pegawai');

Route::get('/QR', function () {
    return view('qrcode');
})->name('qr');

Route::get('/SignIn', function () {
    return view('signin');
})->name('signin');

Route::get('/SignUp', function () {
    return view('signup');
})->name('signup');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
