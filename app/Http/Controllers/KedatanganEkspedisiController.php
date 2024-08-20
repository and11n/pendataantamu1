<?php

namespace App\Http\Controllers;

use App\Models\KedatanganEkspedisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KedatanganEkspedisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = KedatanganEkspedisi::orderBy("created_at", "desc")->paginate(10);
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
        $request->validate([
            "nama_kurir" => ["required"],
            "id_ekspedisi" => ["required", 'exists:expedisis,id'],
            "id_pegawai" => ["required", 'exists:pegawais,id'],
            "foto" => ["required", "file"],
        ]);
        $filee = $request->file("foto");

        $data = KedatanganEkspedisi::create([
            "nama_kurir" => $request->nama_kurir,
            "id_ekspedisi" => $request->id_ekspedisi,
            "id_pegawai" => $request->id_pegawai,
            "id_user" => Auth::user()->id,
        ]);
        $fileName = "kurir_" . $data->id . "." . $filee->getClientOriginalName();
        $filee->storeAs("img/kurir/", $fileName, 'public');
        $data->foto = $fileName;
        $data->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(KedatanganEkspedisi $kedatanganEkspedisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KedatanganEkspedisi $kedatanganEkspedisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KedatanganEkspedisi $kedatanganEkspedisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KedatanganEkspedisi $kedatanganEkspedisi)
    {
        //
    }
}
