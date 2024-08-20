<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KedatanganTamuController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PegawaiLoginController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/login', function () {
//     if (auth()->check()) {
//         $role = auth()->user()->role;

//         if ($role == 'admin') {
//             return redirect('admin');
//         } elseif ($role == 'pegawai') {
//             return redirect('pegawai');
//         } elseif ($role == 'fo') {
//             return redirect('FrontOffice');
//         } else {
//             return redirect('/welcome');
//         }
//     }
//     // return view('login');
// });


Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [AdminController::class, 'loginui'])->name('loginui');

Route::middleware(['auth', 'CheckRole:admin'])->prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan', [HomeController::class, 'kunjungan'])->name('admin.kunjungan');
    Route::post('/kunjungan', [HomeController::class, 'kunjunganSearch'])->name('kunjunganSearch');
    Route::get('/laporan', [HomeController::class, 'laporan'])->name('admin.laporan');
    Route::post('/laporan/kurir', [HomeController::class, 'laporanSearchKurir'])->name('laporanSearchKurir');
    Route::post('/laporan/tamu', [HomeController::class, 'laporanSearchTamu'])->name('laporanSearchTamu');
    Route::get('/laporan/kurir', [HomeController::class, 'laporanKurir'])->name('admin.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai');
    Route::delete('/pegawai/hapus/{id}', [PegawaiController::class, 'destroy'])->name('deletePegawaiAdmin');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('addPegawaiAdmin');
    Route::post('/pegawai/search', [PegawaiController::class, 'pegawaiSearch'])->name('searchPegawaiAdmin');
    Route::get('/pegawai/{id}', [PegawaiController::class, 'edit'])->name('editPegawaiAdmin');
    Route::get('import-excel', [PegawaiController::class, 'import_excel']);
    Route::post('import-excel', [PegawaiController::class, 'import_excel_post'])->name('admin_import-excel');
});


// Route::middleware(['auth', 'Pegawai:pegawai'])->group(function () {
    //     Route::get('logout', [PegawaiLoginController::class, 'destroy'])->name('pegawai.logout');
    //     // Route::post('pegawai/login', [PegawaiLoginController::class, 'login'])->name('pegawai.login.handler');
    // });

Route::middleware('CheckRole:pegawai')->prefix('pegawai')->group(function () {
    Route::get('/', [PegawaiLoginController::class, 'index'])->name('pegawai.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan', [HomeController::class, 'pegawaiKunjungan'])->name('pegawai.kunjungan');
    Route::post('/kunjungan', [HomeController::class, 'kunjunganSearch'])->name('pegawai.kunjunganSearch');
    Route::get('/laporan', [HomeController::class, 'pegawaiLaporan'])->name('pegawai.laporan');
    Route::post('/laporan/kurir', [HomeController::class, 'laporanSearchKurir'])->name('pegawai.laporanSearchKurir');
    Route::post('/laporan/tamu', [HomeController::class, 'laporanSearchTamu'])->name('pegawai.laporanSearchTamu');
    Route::get('/laporan/kurir', [HomeController::class, 'pegawaiLaporanKurir'])->name('pegawai.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');
});

Route::middleware('CheckRole:fo')->prefix('fo')->group(function () {
    Route::get('/', [FrontOfficeController::class, 'index'])->name('frontoffice.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan', [HomeController::class, 'kunjungan'])->name('frontoffice.kunjungan');
    Route::post('/kunjungan', [HomeController::class, 'kunjunganSearch'])->name('frontoffice.kunjunganSearch');
    Route::get('/laporan', [HomeController::class, 'laporan'])->name('fo.laporan');
    Route::post('/laporan/kurir', [HomeController::class, 'laporanSearchKurir'])->name('frontoffice.laporanSearchKurir');
    Route::post('/laporan/tamu', [HomeController::class, 'laporanSearchTamu'])->name('frontoffice.laporanSearchTamu');
    Route::get('/laporan/kurir', [HomeController::class, 'laporanKurir'])->name('frontoffice.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('fo.pegawai');
    Route::delete('/pegawai/hapus/{id}', [PegawaiController::class, 'destroy'])->name('deletePegawai');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('addPegawai');
    Route::post('/pegawai/search', [PegawaiController::class, 'pegawaiSearch'])->name('searchPegawai');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'edit'])->name('editPegawai');
    Route::get('import-excel', [PegawaiController::class, 'import_excel']);
    Route::post('import-excel', [PegawaiController::class, 'import_excel_post'])->name('import-excel');
});

Route::get('pegawai/login', [PegawaiLoginController::class, 'loginPage'])->name('pegawai.login');

// Route::get('/logout', function () {
//     Auth::logout();
//     return redirect(route('login'));
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
