<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PegawaiImport;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wali = Pegawai::with('user');
        $data = Pegawai::paginate(10);
        return view('admin/pgww', compact('data', 'wali'));
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
        // dd($request->all());
        $request->validate([
            'nama_user' => 'required',
            'email' => 'required',
            'ptk' => 'required',
            'no_telp' => 'required',
            'nip' => 'required|unique:pegawais,nip',
            'password' => 'required',
        ]);

        // dd($request->all());
        $user = User::create([
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Pegawai::create([
            'nip' => $request->nip,
            'id_user' => $user->id,
            'ptk' => $request->ptk,
            'no_telp' => $request->no_telp,
        ]);
        // return redirect()->back();
        // $newPgw = new Pegawai();
        // $newPgw->nama = $request->nama;
        // $newPgw->NIP = $request->NIP;
        // $newPgw->no_telp = $request->no_telp;
        // $newPgw->ptk = $request->ptk;
        // $newPgw->email = $request->email;
        // $newPgw->password = Hash::make($request->password);
        // $newPgw->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        DB::table('pegawais')->where('id', $request->id)->update([

            'nama' => $request->nama,
            'NIP' => $request->NIP,
            'no_telp' => $request->no_telp,
            'ptk' => $request->ptk,
            'email' => $request->email,
            // save();
            // dd($newPgw);
        ]);
        return redirect()->back();
    }
    public function pegawaiSearch(Request $request)
    {
        $searchTerm = $request->search != null ? $request->search : "";
        // return response()->json($request->all());
        $datas = Pegawai::where(function ($query) use ($searchTerm) {
            $query->where('nama', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere('NIP', 'like', "%{$searchTerm}%")
                ->orWhere('no_telp', 'like', "%{$searchTerm}%")
            ;
        })
            ->where('ptk', $request->ptk)
            ->orderBy('created_at', 'desc')
            ->paginate($request->entry);
        return response()->json(compact('datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $pegawai = Pegawai::where('id_user', $request->id);
        $pegawai->delete();
        return redirect()->back();
    }

    public function import_excel()
    {
        return view('admin.pgww');
    }

    public function import_excel_post(Request $request)
    {
        // $request->validate([
        //     'excel_file' => [
        //         'validate',
        //         'file'
        //     ]
        // ]);

        Excel::import(new PegawaiImport, $request->file('excel_file'));

        return redirect()->back();
    }
}
