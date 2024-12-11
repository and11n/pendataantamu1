<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KedatanganTamu;
use App\Models\KedatanganEkspedisi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Exports\LapAdminExport;
use App\Exports\KuLapAdminExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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

    public function laporan(Request $request)
    {
        $query = KedatanganTamu::with(['tamu', 'pegawai.user'])
            ->whereHas('pegawai.user');

        // Handle search (jika Anda ingin mengaktifkan pencarian)
        /*
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('tamu', function ($tamuQuery) use ($searchTerm) {
                    $tamuQuery->where('nama', 'like', $searchTerm);
                })
                ->orWhereHas('pegawai.user', function ($pegawaiQuery) use ($searchTerm) {
                    $pegawaiQuery->where('nama_user', 'like', $searchTerm);
                });
            });
        }
        */

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

        // Handle date filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Cek apakah ada filter pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $filter = $request->input('filter');

            $query->where(function ($q) use ($searchTerm, $filter) {
                switch ($filter) {
                    case 'tamu':
                        $q->whereHas('tamu', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('nama', 'like', $searchTerm); // Pastikan 'nama' adalah kolom yang benar
                        });
                        break;
                    case 'no_telp':
                        $q->whereHas('no telp ', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('no_telp', 'like', $searchTerm);
                        });
                        break;
                    case 'alamat':
                        $q->whereHas('alamat', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('alamat', 'like', $searchTerm);
                        });
                        break;
                    case 'pegawai':
                        $q->whereHas('pegawai', function ($pegawaiQuery) use ($searchTerm) {
                            $pegawaiQuery->where('nama_user', 'like', $searchTerm);
                        });
                        break;
                    case 'tanggal_waktu':
                        $q->whereDate('waktu_perjanjian', '=', date('Y-m-d', strtotime($searchTerm)));
                        break;
                    case 'instansi':
                        $q->whereHas('instansi', function ($instansiQuery) use ($searchTerm) {
                            $instansiQuery->where('instansi', 'like', $searchTerm);
                        });
                        break;
                }
            });
        }

        // Ambil data dengan paginasi
        $kedatanganTamu = $query->paginate(7);

        return view('admin.laporan', compact('kedatanganTamu'));
    }

    public function exportExcelAdmin()
    {
        return Excel::download(new LapAdminExport, 'laporan_tamu.xlsx');
    }

    public function exportPDFAdmin()
    {
        $kedatanganTamu = KedatanganTamu::with(['tamu', 'pegawai.user'])->get(); // Ambil data yang ingin diekspor
        $pdf = PDF::loadView('admin.laporan_pdf', compact('kedatanganTamu'));
        return $pdf->download('laporan_tamu.pdf');
    }

    // public function laporanSearchTamu()
    // {
    //     return view('admin.laporan');
    // }

    public function laporanKurir(Request $request)
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

        return view('admin.laporanKurir', compact('kedatanganEkspedisi', 'options'));
    }

    public function exportExcelAdminKurir()
    {
        return Excel::download(new KuLapAdminExport, 'laporan_ekspedisi.xlsx');
    }

    public function exportKuPDFAdmin()
    {
        $kedatanganEkspedisi = KedatanganEkspedisi::with(['ekspedisi', 'pegawai.user'])->get(); // Ambil data yang ingin diekspor
        $pdf = PDF::loadView('admin.laporanKurir_pdf', compact('kedatanganEkspedisi'));
        return $pdf->download('laporan_ekspedisi.pdf');
    }

    // public function laporanSearchKurir()
    // {
    //     return view('admin.laporanKurir');
    // }

    public function pegawaiLaporan(Request $request)
    {
        $query = KedatanganTamu::with(['tamu', 'pegawai.user'])
            ->whereHas('pegawai.user');

        // Handle search (jika Anda ingin mengaktifkan pencarian)
        /*
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('tamu', function ($tamuQuery) use ($searchTerm) {
                    $tamuQuery->where('nama', 'like', $searchTerm);
                })
                ->orWhereHas('pegawai.user', function ($pegawaiQuery) use ($searchTerm) {
                    $pegawaiQuery->where('nama_user', 'like', $searchTerm);
                });
            });
        }
        */

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

        // Handle date filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Cek apakah ada filter pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $filter = $request->input('filter');

            $query->where(function ($q) use ($searchTerm, $filter) {
                switch ($filter) {
                    case 'tamu':
                        $q->whereHas('tamu', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('nama', 'like', $searchTerm); // Pastikan 'nama' adalah kolom yang benar
                        });
                        break;
                    case 'no_telp':
                        $q->whereHas('no telp ', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('no_telp', 'like', $searchTerm);
                        });
                        break;
                    case 'alamat':
                        $q->whereHas('alamat', function ($tamuQuery) use ($searchTerm) {
                            $tamuQuery->where('alamat', 'like', $searchTerm);
                        });
                        break;
                    case 'pegawai':
                        $q->whereHas('pegawai', function ($pegawaiQuery) use ($searchTerm) {
                            $pegawaiQuery->where('nama_pegawai', 'like', $searchTerm); // Pastikan 'nama_pegawai' ada di tabel pegawai
                        });
                        break;
                    case 'tanggal_waktu':
                        $q->whereDate('waktu_perjanjian', '=', date('Y-m-d', strtotime($searchTerm))); // Pastikan format pencarian tanggal sesuai
                        break;
                    case 'instansi':
                        $q->whereHas('instansi', function ($instansiQuery) use ($searchTerm) {
                            $instansiQuery->where('instansi', 'like', $searchTerm);
                        });
                        break;
                }
            });
        }

        // Ambil data dengan paginasi
        $kedatanganTamu = $query->paginate(7);
        $kedatanganTamu->appends($request->all());

        return view('pegawai.laporan', compact('kedatanganTamu'));
    }

    public function exportPDFPegawai()
    {
        $kedatanganTamu = KedatanganTamu::with(['tamu', 'pegawai.user'])->get(); // Ambil data yang ingin diekspor
        $pdf = PDF::loadView('pegawai.laporan_pdf', compact('kedatanganTamu'));
        return $pdf->download('laporan_tamu.pdf');
    }

    public function pegawaiLaporanKurir(Request $request)
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

        return view('pegawai.laporanKurir', compact('kedatanganEkspedisi', 'options'));
    }

    public function exportKuPDFKurir()
    {
        $kedatanganEkspedisi = KedatanganEkspedisi::with(['ekspedisi', 'pegawai.user'])->get(); // Ambil data yang ingin diekspor
        $pdf = PDF::loadView('pegawai.laporanKurir_pdf', compact('kedatanganEkspedisi'));
        return $pdf->download('laporan_ekspedisi.pdf');
    }

    public function pegawaiKunjungan(Request $request)
    {
        $id_user = Auth::id();

        $status = $request->query('status');
        $search = $request->query('search'); // Get the search input

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

        $listKunjungan = KedatanganTamu::with('pegawai.user', 'tamu') // Include the 'tamu' relationship
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

        // Hitung jumlah tamu berdasarkan status "belum datang", "selesai", dan "gagal"
        $tamuBelumDatang = KedatanganTamu::where('status', 'belum datang')->count();
        $tamuSelesai = KedatanganTamu::where('status', 'selesai')->count();
        $tamuGagal = KedatanganTamu::where('status', 'gagal')->count();

        // Definisikan variabel diterima, ditolak, dan menunggu
        $diterima = KedatanganTamu::where('status', 'diterima')->count();
        $ditolak = KedatanganTamu::where('status', 'ditolak')->count();
        $menunggu = KedatanganTamu::where('status', 'menunggu')->count();

        // Menghitung persentase
        $total = $diterima + $ditolak + $menunggu;
        $diterimaPersen = $total > 0 ? ($diterima / $total) * 100 : 0;
        $ditolakPersen = $total > 0 ? ($ditolak / $total) * 100 : 0;
        $menungguPersen = $total > 0 ? ($menunggu / $total) * 100 : 0;

        // Passing data ke view
        return view('pegawai.kunjungan', compact(
            'diterima', 'listKunjungan', 'ditolak', 'menunggu',
            'diterimaPersen', 'ditolakPersen', 'menungguPersen',
            'tamuBelumDatang', 'tamuSelesai', 'tamuGagal'
        ));
    }


    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $kunjungan = KedatanganTamu::findOrFail($request->id);
        $kunjungan->status = $request->status;
        $kunjungan->save();

        if ($request->status == 'diterima') {
            $qrCodePath = 'qrcodes/' . $kunjungan->id_kedatangan . '.png';
            $qrCodeData = base64_decode($kunjungan->qr_code);
            Storage::disk('public')->put($qrCodePath, $qrCodeData);
            $fullQrCodePath = public_path('storage/' . $qrCodePath);
            // Kirim email ketika kunjungan diterima
            Mail::send('mails.SendEmail', [
                'subject' => 'Kunjungan Diterima',
                'body' => 'Kunjungan Anda telah diterima. Berikut adalah QR code untuk keperluan kunjungan Anda.',
            ], function ($message) use ($kunjungan, $fullQrCodePath) {
                $message->to($kunjungan->tamu->email)
                    ->subject('Kunjungan Diterima')
                    ->attach($fullQrCodePath, [
                        'as' => 'qrcode.png',
                        'mime' => 'image/png',
                    ]);
            });
        } elseif ($request->status == 'ditolak') {
            // Kirim email ketika kunjungan ditolak
            Mail::send('mails.SendEmail', [
                'subject' => 'Kunjungan Ditolak',
                'body' => 'Kunjungan Anda telah ditolak. Alasan: ' . $request->alasan,
            ], function ($message) use ($kunjungan) {
                $message->to($kunjungan->tamu->email)
                    ->subject('Kunjungan Ditolak');
            });
        }
        return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    public function getDetail($id_kedatangan)
    {
        // Coba cari data di KedatanganTamu atau KedatanganEkspedisi
        $tamu = KedatanganTamu::find($id_kedatangan);
        $ekspedisi = KedatanganEkspedisi::find($id_kedatangan);

        // Cek apakah datanya ada
        if ($tamu) {
            // Format waktu untuk tamu
            $tamu->formatWaktu = Carbon::parse($tamu->waktu_perjanjian)
                ->translatedFormat('H:i l, d-m-Y');
            // Set type menjadi tamu
            $tamu->type = 'tamu';

            // Kirim view untuk tamu
            return view('components.card_detail', ['item' => $tamu])->render();
        } elseif ($ekspedisi) {
            // Format waktu untuk ekspedisi
            $ekspedisi->formatWaktu = Carbon::parse($ekspedisi->waktu_kedatangan)
                ->translatedFormat('H:i l, d-m-Y');
            // Set type menjadi kurir
            $ekspedisi->type = 'kurir';

            // Kirim view untuk ekspedisi
            return view('components.card_detail', ['item' => $ekspedisi])->render();
        }

        // Jika tidak ditemukan, kembalikan null atau pesan error
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
}
