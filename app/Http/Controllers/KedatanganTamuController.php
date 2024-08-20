<?php

namespace App\Http\Controllers;

use App\Models\KedatanganTamu;
use Illuminate\Http\Request;

class KedatanganTamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function keterangan(Request $request)
    {
        $data = KedatanganTamu::find($request->id);
        $data->keterangan = $request->keterangan;
        $data->save();
        return redirect()->back();
    }

    public function terima($id)
    {
        $data = KedatanganTamu::find($id);
        $data->status = 'diterima';
        $data->save();
        return redirect()->back();
    }

    public function tolak($id)
    {
        $data = KedatanganTamu::find($id);
        $data->status = 'ditolak';
        $data->save();
        return redirect()->back();
    }

    public function kedatangan($id)
    {
        $data = KedatanganTamu::find($id);
        $data->status = 'selesai';
        $data->waktu_kedatangan = now();
        $data->save();
        return redirect()->back();
    }
    public function gagal($id)
    {
        $data = KedatanganTamu::find($id);
        $data->status = 'tidakDatang';
        $data->save();
        return redirect()->back();
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

    }

    /**
     * Display the specified resource.
     */
    public function show(KedatanganTamu $kedatanganTamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KedatanganTamu $kedatanganTamu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KedatanganTamu $kedatanganTamu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KedatanganTamu $kedatanganTamu)
    {
        //
    }
}
