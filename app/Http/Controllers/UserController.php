<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\Pegawai;
use App\Models\KedatanganTamu;
use App\Models\Ekspedisi;
use App\Models\KedatanganEkspedisi;
use DNS2D;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS2D as BarcodeDNS2D;
use Illuminate\Support\Facades\Mail;
use App\Mail\KirimEmailTamu;
use App\Mail\KirimEmailGuru;
use App\Mail\KirimEmailKurir;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.beranda');
    }

    // public function loginpop()
    // {
    //     return view('user.login');
    // }

    public function register()
    {
        return view('auth.register');
    }

    public function tamu()
    {
        $pegawai = Pegawai::with('user')->get();
        return view('user.kedTamu', compact('pegawai'));
    }

    public function tambahtamu(Request $request)
{
    // dd($request->all());
    // Validate the request data
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'no_telp' => 'required|string|max:15',
        'email' => 'required|email|max:255',
        'id_pegawai' => 'required|integer',
        'instansi' => 'required|string|max:255',
        'tujuan' => 'required|string|max:255',
        'waktu_perjanjian' => 'required|date',
    ]);

    // Create a new guest record
    $tamu = Tamu::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'no_telp' => $request->no_telp,
        'email' => $request->email,
    ]);

        $token=Str::random(60);
        // Create a new arrival record
        $kedatangan = KedatanganTamu::create([
            'id_pegawai' => $request->id_pegawai,
            'id_tamu' => $tamu->id_tamu,
            'instansi' => $request->instansi,
            'tujuan' => $request->tujuan,
            'waktu_perjanjian' => $request->waktu_perjanjian,
            'qr_code' => null, // Placeholder for QR code path
            'token' => $token,
        ]);

        $pegawai = Pegawai::with('user')->find($request->id_pegawai);

        $qrCodeContent = "$kedatangan->id";
        $qrCodePng = DNS2D::getBarcodePNG($qrCodeContent, 'QRCODE');

        // Dekode base64 string ke data mentah (raw binary data)
        // $qrCodeRawData = $qrCodePng;

        // Simpan QR code ke storage sebagai file PNG
        $qrCodePath = 'public/qrcodes/' . $kedatangan->id_kedatangan . '.png';
        Storage::put($qrCodePath, $qrCodePng);

        // return base64_decode($qrCodePng);
        // Simpan nama file ke database (opsional)
        $kedatangan->qr_code = $qrCodePng;
        $kedatangan->save();

        if ($pegawai) {
            Mail::to($pegawai->user->email)->send(new KirimEmailGuru($kedatangan, $tamu));
        } else {
            // Handle error jika $pegawai tidak ditemukan
            return redirect()->back()->with('error', 'Pegawai tidak ditemukan');
        }

        return redirect()->back()->with('success', 'Janji temu berhasil dibuat');

}

    public function konfirmasiKedatangan($id, $token, $action)
    {
        $kedatangan = KedatanganTamu::findOrFail($id);
        $tamu = Tamu::findOrFail($kedatangan->id_tamu);

        if ($kedatangan->token !== $token) {
            return redirect()->back();
        }

        if ($action === 'terima') {
            $kedatangan->update(['status' => 'Diterima', 'token' => null]);
            $qrCodePath = 'qrcode/' . $kedatangan->id_kedatangan . 'png';
            Storage::disk('public')->put($qrCodePath, base64_decode($kedatangan->QR_code));
            $fullQr_code = public_path('storage/' . $qrCodePath);
            Mail::to($tamu->email)->send(new KirimEmailTamu($kedatangan, $tamu));

            return view('pegawai.email.confir', ['status' => 'diterima']);
        } elseif ($action === 'tolak') {
            $kedatangan->update(['status' => 'Ditolak', 'token' => null]);
            Mail::to($tamu->email)->send(new KirimEmailTamu($kedatangan, $tamu));

            return view('pegawai.email.alasan', ['status' => 'ditolak', 'id' => $id, 'token' => $token]);
        }

        // return view('pegawai.email.confir_terima');
    }

    public function submitTolak(Request $request, $id, $token)
    {
        // $kedatangan_tamu = KedatanganTamu::findOrFail($id);

        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);

        $kedatangan = KedatanganTamu::findOrFail($id);
        $tamu = Tamu::findOrFail($kedatangan->id_tamu);

        if ($kedatangan->token !== $token) {
            return view('pegawai.email.confir', ['status' => 'ditolak', 'nama' => $kedatangan->tamu->nama]);
        }

        $kedatangan->update([
            'status' => 'ditolak',
            'alasan' => $request->input('alasan'),
            'token' => null
        ]);

        Mail::to($tamu->email)->send(new KirimEmailTamu($kedatangan, $tamu));

        return view('pegawai.email.confir', ['status' => 'ditolak', 'nama' => $kedatangan->tamu->nama]);
    }

    public function updateStatusEmail($id, $token, $status)
    {
        // Temukan kedatangan berdasarkan ID
        $kedatangan = KedatanganTamu::find($id);

        // Validasi token yang dikirim dari email
        if (!$kedatangan || $kedatangan->token !== $token) {
            return redirect()->back()->with('error', 'Token tidak valid atau kedatangan tidak ditemukan.');
        }

        // Cek apakah status valid
        if (!in_array($status, ['diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Update status
        $kedatangan->Status = $status;

        // Jika statusnya Ditolak, arahkan ke form penolakan, jika Diterima simpan langsung
        if ($status === 'ditolak') {
            return view('pegawai.email.penolakan', compact('kedatangan'));
        } else {
            $kedatangan->save();
            return redirect()->back()->with('success', 'Status kunjungan telah diperbarui menjadi Diterima.');
        }
    }

    public function kurir()
    {
        $pegawai = Pegawai::all();
        return view('user.kedKurir', compact('pegawai'));
    }

    public function tambahkurir(Request $request)
{
    $pegawai = Pegawai::with('user')->get();

    // Simpan gambar
    $imageData = $request->input('image');
    $fileName = uniqid() . '.jpg';
    $filePath = 'public/uploads/' . $fileName;
    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    Storage::put($filePath, $image);

    // Validasi input
    $request->validate([
        'nama_kurir' => 'required|string|max:255',
        'ekspedisi' => 'required|string|max:255',
        'no_telp' => 'required|string|max:15',// Validate pegawai existence
    ]);

    // Simpan data ekspedisi
    $ekspedisi = Ekspedisi::create([
        'nama_kurir' => $request->nama_kurir,
        'ekspedisi' => $request->ekspedisi,
        'no_telp' => $request->no_telp,
    ]);

    if ($ekspedisi) {
        // Simpan data kedatangan
        $kedatangan = KedatanganEkspedisi::create([
            'id_ekspedisi' => $ekspedisi->id_ekspedisi,
            'id_pegawai' => $request->id_pegawai,
            'foto' => $fileName,
            'tanggal_waktu' => $request->tanggal_waktu,
        ]);

        // Retrieve Pegawai with email
        $kurirPegawai = Pegawai::with('user')->find($request->id_pegawai);

        // Kirim notifikasi email
        $this->kirimEmailKurir($kedatangan, $ekspedisi, $kurirPegawai);

        return redirect()->back()->with('success', 'Data kurir dan notifikasi email berhasil dikirim!');
    }
}

    public function kirimEmailKurir(KedatanganEkspedisi $kedatangan, Ekspedisi $kurir, Pegawai $kurirPegawai)
        {
            $emailData = [
                'nama_kurir' => $kurir->nama_kurir,
                'ekspedisi' => $kurir->ekspedisi,
                'tanggal_waktu' => $kedatangan->tanggal_waktu,
                'foto' => $kedatangan->foto
            ];

            $userEmail = $kurirPegawai->user->email; // Adjust according to your structure

            Mail::send('pegawai.email.kirimEmailKurir', $emailData, function ($message) use ($userEmail) {
                $message->to($userEmail)
                        ->subject('Pemberitahuan Paket');
            });

            return true;
        }


    public function guru(Request $request)
    {
        $query = Pegawai::with('user');

        if ($request->has('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('nama_user', 'like', $searchTerm);
                })
                ->orWhere('nip', 'like', $searchTerm);
            });
        }

        $data = $query->paginate(3);
        return view('user.datGuru', compact('data'));
    }

    public function tendik(Request $request)
    {
        return view('user.datTendik');
    }

    public function about()
    {
        return view('user.about');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


