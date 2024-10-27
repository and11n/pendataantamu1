<?php

namespace App\Http\Controllers;

use App\Mail\NotifTamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KedatanganTamu;
use App\Models\KedatanganEkspedisi;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Tamu;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class FrontOfficeController extends Controller
{
    public function index(Request $request)
    {
        $queryTamu = KedatanganTamu::where('waktu_kedatangan', '!=', null);
        $queryEkspedisi = KedatanganEkspedisi::where('waktu_kedatangan', '!=', null);

        // Menghitung jumlah tamu dan kurir hari ini
        $countTamuBulan = KedatanganTamu::whereMonth('created_at', Carbon::now()->month)->count();
        $countKurirBulan = KedatanganEkspedisi::whereMonth('created_at', Carbon::now()->month)->count();

        // Menghitung jumlah guru
        $countGuru = Pegawai::count();

        // Data Chart - Mendapatkan data untuk bulan tertentu atau default ke bulan ini
        $selectedMonth = $request->bulan ?? now()->month;
        $startOfMonth = Carbon::create(null, $selectedMonth)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;
        $months = [];
        $tamu = [];
        $kurir = [];

        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDate = $startOfMonth->copy()->addDays($i);
            $months[] = $currentDate->format('d M');

            $tamuCount = KedatanganTamu::whereDate('created_at', $currentDate)->count();
            $kurirCount = KedatanganEkspedisi::whereDate('created_at', $currentDate)->count();

            $tamu[] = $tamuCount;
            $kurir[] = $kurirCount;
        }

        // Menyusun data grafik
        $chartData = [
            "kurir" => $kurir,
            "tamu" => $tamu,
            "labels" => $months,
        ];

        // Filter the visitor data by month if selected
        if ($request->has('bulan') && $request->bulan != 'all') {
            $queryTamu->whereMonth('created_at', $selectedMonth);
            $queryEkspedisi->whereMonth('created_at', $selectedMonth);
        }

        $tamuDatang = KedatanganTamu::where('status','diterima')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuMenunggu = KedatanganTamu::where('status','menunggu')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $tamuDitolak = KedatanganTamu::where('status','ditolak')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $kurirHari = KedatanganEkspedisi::whereDate('created_at', Carbon::today())->get();

        return view('frontoffice.dashboard', compact('countTamuBulan', 'countKurirBulan', 'countGuru', 'chartData', 'tamuDatang', 'tamuMenunggu', 'tamuDitolak', 'kurirHari'));
    }

    public function updateKedatangan(Request $request)
{
    try {
        $kedatanganTamu = KedatanganTamu::where('id', $request->id)
            ->orderBy('Waktu_perjanjian', 'desc')
            ->first();

        if (!$kedatanganTamu) {
            return response()->json(['success' => false, 'message' => 'Data kedatangan tamu tidak ditemukan']);
        }

        // Set waktu kedatangan
        $kedatanganTamu->waktu_kedatangan = now();

        if ($request->photo) {
            $image = $request->photo;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '_' . $request->id . '.jpg';

            // Simpan foto ke storage
            if (Storage::disk('public')->put('img-tamu/' . $imageName, base64_decode($image))) {
                $kedatanganTamu->Foto = 'img-tamu/' . $imageName; // Simpan path relatif
            } else {
                throw new \Exception('Gagal menyimpan gambar');
            }
        }

        $kedatanganTamu->save();

        // Cek dan kirim email
        if ($kedatanganTamu->pegawai && $kedatanganTamu->pegawai->user) {
            Mail::to($kedatanganTamu->pegawai->user->email)->send(new NotifTamu($kedatanganTamu));
        } else {
            throw new \Exception('User  tidak ditemukan untuk kedatangan tamu ini.');
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function getTamuDetail($id)
    {
        $tamu = KedatanganTamu::find($id);
        if ($tamu) {
            // $kedatangan = KedatanganTamu::where('id', $id)
            //     ->whereDate('waktu_perjanjian', '<=', now()->toDateString())
            //     ->orderBy('waktu_perjanjian', 'desc')
            //     ->first();

            $kedatangan = KedatanganTamu::where('id', $id)
                ->orderBy('waktu_perjanjian', 'desc')
                ->first();

            if ($kedatangan) {
                if ($kedatangan->status !== 'diterima') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Status tamu belum "Diterima".'
                    ], 403);
                }

                $waktuPerjanjian = Carbon::parse($kedatangan->waktu_perjanjian);
                $now = Carbon::now();
                $batasWaktu = $waktuPerjanjian->copy()->addHour();

                if ($now->between($waktuPerjanjian, $batasWaktu)) {
                    return response()->json([
                        'success' => true,
                        'name' => $tamu->tamu->nama,
                        'email' => $tamu->tamu->email,
                        'phone' => $tamu->tamu->no_telp,
                        'waktu_perjanjian' => $kedatangan->waktu_perjanjian,
                        'status' => $kedatangan->status
                    ]);
                } else if ($now->lessThan($waktuPerjanjian)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu scan belum mencapai jadwal perjanjian.'
                    ], 403);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu scan telah melewati batas 1 jam dari jadwal perjanjian.'
                    ], 403);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada jadwal perjanjian yang sesuai.'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tamu tidak ditemukan'
            ], 404);
        }
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

    public function FOkunjungan(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = KedatanganTamu::with('pegawai.user');

        // Status filtering logic
        if ($request->has('status') && $request->status != 'all') {
            switch ($request->status) {
                case 'waiting': // Sudah Datang
                    $query->where('waktu_kedatangan', now()); // Check if the arrival time has passed
                    break;
                case 'accepted': // Belum Datang
                    $query->where('waktu_kedatangan', now()); // Check if the arrival time is in the future
                    break;
            }
        }

        // Retrieve paginated results for Kedatangan Tamu only
        $listKunjungan = KedatanganTamu::with('pegawai.user')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('tamu', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%'); // Filter by visitor name
                });
            })
            ->orderBy('waktu_perjanjian', 'desc')
            ->paginate(5)
            ->appends($request->query());

        // Status counts for percentage calculations
        $tamuBelumDatang = KedatanganTamu::where('status', 'belum datang')->count();
        $tamuSelesai = KedatanganTamu::where('status', 'selesai')->count();
        $tamuGagal = KedatanganTamu::where('status', 'gagal')->count();

        $diterima = KedatanganTamu::where('status', 'diterima')->count();
        $ditolak = KedatanganTamu::where('status', 'ditolak')->count();
        $menunggu = KedatanganTamu::where('status', 'menunggu')->count();

        // Calculate percentages
        $total = $diterima + $ditolak + $menunggu;
        $diterimaPersen = $total > 0 ? ($diterima / $total) * 100 : 0;
        $ditolakPersen = $total > 0 ? ($ditolak / $total) * 100 : 0;
        $menungguPersen = $total > 0 ? ($menunggu / $total) * 100 : 0;

        return view('frontoffice.kunjungan', compact(
            'diterima', 'listKunjungan', 'ditolak', 'menunggu',
            'diterimaPersen', 'ditolakPersen', 'menungguPersen',
            'tamuBelumDatang', 'tamuSelesai', 'tamuGagal'
        ));
    }

    public function FOlaporan(Request $request)
    {
        $query = KedatanganTamu::with(['tamu', 'pegawai.user'])
            ->whereHas('pegawai.user');

        // Handle search
        // if ($request->has('search') && $request->search != '') {
        //     $searchTerm = '%' . $request->search . '%';
        //     $query->where(function ($q) use ($searchTerm) {
        //         $q->whereHas('tamu', function ($tamuQuery) use ($searchTerm) {
        //             $tamuQuery->where('nama', 'like', $searchTerm);
        //         })
        //         ->orWhereHas('pegawai.user', function ($pegawaiQuery) use ($searchTerm) {
        //             $pegawaiQuery->where('nama_user', 'like', $searchTerm);
        //         });
        //     });
        // }

        // Handle date filter
       // Handle status filter
       if ($request->has('status') && $request->status != 'all') {
        \Log::info('Request Status:', ['status' => $request->status]); // Debugging
        switch ($request->status) {
            case 'waiting':
                $query->where('status', 'menunggu');
                break;
            case 'accepted':
                $query->where('status', 'diterima');
                break;
            case 'rejected':
                $query->where('status', 'ditolak');
                break;
        }
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $kedatanganTamu = $query->get();
        $kedatanganTamu = $query->paginate(7);
        $kedatanganTamu->appends($request->all());

        return view('frontoffice.laporan', compact('kedatanganTamu'));
    }

    public function exportPDFFO()
    {
        $kedatanganTamu = KedatanganTamu::with(['tamu', 'pegawai.user'])->get(); // Ambil data yang ingin diekspor
        $pdf = PDF::loadView('frontoffice.laporan_pdf', compact('kedatanganTamu'));
        return $pdf->download('laporan_tamu.pdf');
    }

    public function FOlaporanKurir(Request $request)
    {
        $query = KedatanganEkspedisi::with(['pegawai.user', 'ekspedisi'])
            ->whereHas('pegawai.user');

        // Handle search
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Handle date filter
        if ($request->has('lama') && $request->lama != 'all') {
            $query->where(function ($q) use ($request) {
                switch ($request->lama) {
                    case 'day':
                        $q->whereDate('created_at', Carbon::today());
                        break;
                    case 'week':
                        $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'month':
                        $q->whereMonth('created_at', Carbon::now()->month);
                        break;
                }
            });
        }

        $kedatanganEkspedisi = $query->get();
        $kedatanganEkspedisi = $query->paginate(7);
        $kedatanganEkspedisi->appends($request->all());

        $options = [
            'day' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'all' => 'All',
        ];

        return view('frontoffice.laporanKurir', compact('kedatanganEkspedisi', 'options'));
    }

    public function pegawai(Request $request)
    {
        // Mulai dengan query dasar
        $query = Pegawai::with('user');

        // Cek apakah ada filter 'body_ptk'
        if ($request->has('body_ptk') && $request->body_ptk != 'all') {
            $query->where('ptk', $request->body_ptk);
        }

        // Cek apakah ada filter pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('nama_user', 'like', $searchTerm);
                })
                ->orWhere('nip', 'like', $searchTerm);
            });
        }

        // Ambil data dengan paginasi
        $data = $query->paginate(10)->appends($request->all()); // Menambahkan parameter query ke URL pagination

        // Kembalikan view dengan data
        return view('frontoffice.pgww', compact('data'));
    }
}
