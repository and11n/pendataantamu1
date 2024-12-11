<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KedatanganTamuController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PegawaiLoginController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     if (auth()->check()) {
//         $role = auth()->user()->role;

//         if ($role == 'admin') {
//             return redirect('admin');
//         } elseif ($role == 'pegawai') {
//             return redirect('pegawai');
//         } elseif ($role == 'fo') {
//             return redirect('fo');
//         } else {
//             return redirect('/beranda');
//         }
//     }
//     return view('signin');
// });



Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/loginui', [AdminController::class, 'loginui'])->name('loginui');

Route::middleware(['auth', 'CheckRole:admin'])->prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan', [HomeController::class, 'kunjungan'])->name('admin.kunjungan');
    Route::get('/laporan', [HomeController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/kurir', [HomeController::class, 'laporanKurir'])->name('admin.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai');
    Route::delete('/pegawai/hapus/{id}', [PegawaiController::class, 'destroy'])->name('deletePegawaiAdmin');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('addPegawaiAdmin');
    Route::post('/pegawai/{id}', [PegawaiController::class, 'edit'])->name('editPegawaiAdmin');
    // Route::get('import-excel', [PegawaiController::class, 'import_excel']);
    Route::post('import-excel', [PegawaiController::class, 'import_excel_post'])->name('admin_import-excel');
    Route::get('/download-template', function () {
        return response()->download(public_path('format/template_import_pegawai.xlsx'));
    })->name('download-template');

    Route::get('/admin/export/excel', [HomeController::class, 'exportExcelAdmin'])->name('admin.export.excel');
    Route::get('/admin/export/pdfRekap', [ExportController::class, 'exportPDFTamu'])->name('admin.export.pdf');
    Route::get('/admin/export/pdf', [HomeController::class, 'exportPDFAdmin'])->name('admin.export.pdflaporan');
    Route::get('/export-excel', [HomeController::class, 'exportExcelAdminKurir'])->name('admin_exportKurir.excel');
    Route::get('/export-pdf', [HomeController::class, 'exportKuPDFAdmin'])->name('admin.exportKurir.pdf');

});


// Route::middleware(['auth', 'Pegawai:pegawai'])->group(function () {
    //     Route::get('logout', [PegawaiLoginController::class, 'destroy'])->name('pegawai.logout');
    //     // Route::post('pegawai/login', [PegawaiLoginController::class, 'login'])->name('pegawai.login.handler');
    // });

    Route::middleware('CheckRole:pegawai')->prefix('pegawai')->group(function () {
    Route::get('/kunjungan', [HomeController::class, 'pegawaiKunjungan'])->name('pegawai.kunjungan');
    Route::get('/pegawai-dashboard', [PegawaiLoginController::class, 'index'])->name('pegawai.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan/{id_kedatangan}', [HomeController::class, 'getDetail'])->name('pegawai.kunjunganD');
    Route::patch('/update-status', [HomeController::class, 'updateStatus'])->name('update.status');
    Route::get('/laporan', [HomeController::class, 'pegawaiLaporan'])->name('pegawai.laporan');
    Route::get('/laporan/kurir', [HomeController::class, 'pegawaiLaporanKurir'])->name('pegawai.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');

    Route::get('/export-pdf', [HomeController::class, 'exportPDFPegawai'])->name('pegawai.export.pdf');
    Route::get('/export-pdf-kurir', [HomeController::class, 'exportKuPDFKurir'])->name('pegawai.exportKurir.pdf');
});

Route::middleware('CheckRole:fo')->prefix('fo')->group(function () {
    Route::get('/', [FrontOfficeController::class, 'index'])->name('frontoffice.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kunjungan', [FrontOfficeController::class, 'FOkunjungan'])->name('frontoffice.kunjungan');
    Route::patch('/update-status', [HomeController::class, 'updateStatus'])->name('pegawai.update.status');
    Route::get('/laporan', [FrontOfficeController::class, 'FOlaporan'])->name('frontoffice.laporan');
    Route::get('/export-excel', [FrontOfficeController::class, 'exportExcelFO'])->name('fo_export.excel');
    Route::get('/laporan/kurir', [FrontOfficeController::class, 'FOlaporanKurir'])->name('frontoffice.laporanKurir');

    Route::get('/tamu/terima/{id}', [KedatanganTamuController::class, 'terima'])->name('terimaTamu');
    Route::get('/tamu/tolak/{id}', [KedatanganTamuController::class, 'tolak'])->name('tolakTamu');
    Route::get('/tamu/kedatangan/{id}', [KedatanganTamuController::class, 'kedatangan'])->name('tambahKedatanganTamu');
    Route::get('/tamu/gagal/{id}', [KedatanganTamuController::class, 'gagal'])->name('tamuGagal');
    Route::post('/keterangan', [KedatanganTamuController::class, 'keterangan'])->name('ubahKeteranganTamu');

    Route::get('/pegawai', [FrontOfficeController::class, 'pegawai'])->name('fo.pegawai');

    Route::get('/get-tamu-detail/{id}', [FrontOfficeController::class, 'getTamuDetail'])->name('get-tamu-detail');
    Route::post('/save-photo-and-update-arrival', [FrontOfficeController::class, 'updateKedatangan'])
    ->name('update-kedatangan');

    Route::get('/export-pdf', [FrontOfficeController::class, 'exportPDFFO'])->name('frontoffice.export.pdf');

});

Route::get('pegawai/login', [PegawaiLoginController::class, 'loginPage'])->name('pegawai.login');

Route::get('/', [UserController::class, 'index'])->name('beranda');
// Route::get('user/login', [UserController::class, 'loginpop'])->name('loginn');
Route::get('user/kedTamu', [UserController::class, 'tamu'])->name('kedTamu');
Route::post('user/kedTamu/create', [UserController::class, 'tambahtamu'])->name('tambahkedTamu');
Route::get('user/kedKurir', [UserController::class, 'kurir'])->name('kedKurir');
Route::post('user/kedKurir/create', [UserController::class, 'tambahkurir'])->name('tambahkedKurir');
Route::post('user/kirim-email-kurir', [UserController::class, 'kirimEmailKurir'])->name('kirimEmailKurir');
Route::get('user/datGuru', [UserController::class, 'guru'])->name('datGuru');
Route::get('user/datTendik', [UserController::class, 'tendik'])->name('datTendik');
Route::get('user/about', [UserController::class, 'about'])->name('about');
Route::get('/search-tamu', [UserController::class, 'searchTamu'])->name('searchTamu');

Route::get('/kedatangan/submit-terima/{id}/{token}/{action}', [UserController::class, 'konfirmasiKedatangan'])
    ->name('kedatangan.submit-terima')
    ->where(['action' => 'terima|tolak']);

Route::post('/kedatangan/submit-penolakan/{id}/{token}', [UserController::class, 'submitTolak'])
    ->name('kedatangan.submit-penolakan');

// Route::get('/logout', function () {
//     Auth::logout();
//     return redirect(route('login'));
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
