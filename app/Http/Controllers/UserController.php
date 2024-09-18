<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\Pegawai;
use App\Models\KedatanganTamu;
use App\Models\Ekspedisi;
use App\Models\KedatanganEkspedisi;
use DNS2D;


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

        if ($tamu) {
            // Create a new arrival record
            $kedatangan = KedatanganTamu::create([
                'id_pegawai' => $request->id_pegawai,
                'id_tamu' => $tamu->id_tamu,
                'instansi' => $request->instansi,
                'tujuan' => $request->tujuan,
                'waktu_perjanjian' => $request->waktu_perjanjian,
                'qr_code' => null, // Placeholder for QR code path
            ]);

              $qrCodeContent = "$kedatangan->id";
             $qrCodePng = DNS2D::getBarcodePNG($qrCodeContent, 'QRCODE');

        // Dekode base64 string ke data mentah (raw binary data)
        // $qrCodeRawData = $qrCodePng;

        // Simpan QR code ke storage sebagai file PNG
        // $fileName = 'public/qrcodes/' . $kedatanganTamu->id_kedatangan . '.png';
        // Storage::put($fileName, $qrCodeRawData);

        // return base64_decode($qrCodePng);

        // Simpan nama file ke database (opsional)
        $kedatangan->qr_code = $qrCodePng;
        $kedatangan->save();

            return redirect()->back()->with('success', 'Janji temu berhasil dibuat');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat janji temu');
    }


    public function kurir()
    {
        $pegawai = Pegawai::all();
        return view('user.kedKurir', compact('pegawai'));
    }

    public function tambahkurir(Request $request)
{
    // dd($request->all());
    $request->validate([
        'nama_kurir' => 'required|string|max:255',
        'ekspedisi' => 'required|string|max:255',
        'no_telp' => 'required|string|max:15',
    ]);

    $ekspedisi = Ekspedisi::create([
        'nama_kurir' => $request->nama_kurir    ,
        'ekspedisi' => $request->ekspedisi,
        'no_telp' => $request->no_telp,
    ]);

    if ($ekspedisi) {
        // dd($request->all());
        KedatanganEkspedisi::create([
            'id_ekspedisi' => $ekspedisi->id_ekspedisi,
            'id_pegawai' => $request->id_pegawai,
            'foto' => $request->foto,
            'tanggal_waktu' => $request->tanggal_waktu,
        ]);

        return redirect()->back()->with('success', 'yeay');
    }
}


    public function guru()
    {
        $wali = Pegawai::with('user');
        $data = Pegawai::with('user')->paginate(10);
        // dd($data);
        return view('user.datGuru', compact('data', 'wali'));
    }

    public function tendik()
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


