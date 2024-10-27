<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PegawaiImport;
use App\Models\KedatanganTamu;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the paginated data with the user relationship
        $data = Pegawai::with('user')->paginate(10);

        // Check if the request has the 'body_ptk' filter
        if ($request->has('body_ptk') && $request->body_ptk != 'all') {
            switch ($request->body_ptk) {
                case 'matematika':
                    // Filter by 'ptk' field for 'matematika'
                    $data = Pegawai::with('user')->where('ptk', 'matematika')->paginate(10);
                    break;
                case 'produktif rpl':
                    // Filter records created within the current week
                    $data = Pegawai::with('user')->where('ptk', 'produktif rpl')->paginate(10);
                    break;
                case 'produktif akl':
                    // Filter records created in the current month
                    $data = Pegawai::with('user')->where('ptk', 'Produktif AKL')->paginate(10);
                    break;
                case 'inggris':
                    // Filter records created in the current month
                    $data = Pegawai::with('user')->where('ptk', 'Inggris')->paginate(10);
                    break;
            }
        }

        // // Check if the request has the 'search' filter
        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $data = Pegawai::with('user')
        //         ->where('user.nama_user', 'like', '%' . $search . '%')
        //         ->orWhere('pegawai.ptk', 'like', '%' . $search . '%')
        //         ->orWhere('user.nama_user', 'like', '%' . $search . '%')
        //         ->paginate(10);
        // }

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

        $data = $query->paginate(10); // Execute the query and retrieve the filtered data

        // Return the view with the data and other variables
        return view('admin/pgww', compact('data'));
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
            'nama_user' => 'required',
            'email' => 'required',
            'ptk' => 'required',
            'no_telp' => 'required',
            'nip' => 'required|unique:pegawais,nip',
            'password' => 'required',
        ]);
        // dd($request->all());

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
    public function edit($id, Request $request)
    {
        // Validasi input
        // $request->validate([
            //     'nama_user' => 'required',
            //     'email' => 'required|email',
            //     'ptk' => 'required',
            //     'no_telp' => 'required',
            //     'nip' => 'required|unique:pegawais,nip', // Menambahkan pengecekan unique, kecuali untuk pegawai yang sedang diedit
            //     'password' => 'nullable', // Password bisa diisi atau tidak (optional)
            // ]);


            // Ambil data user berdasarkan ID
            $user = User::findOrFail($id);

            // Update data user
            $user->update([
                'nama_user' => $request->nama_user,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);


            // Update data pegawai
            Pegawai::where('id_user', $user->id)->update([
                'nip' => $request->nip,
                'ptk' => $request->ptk,
                'no_telp' => $request->no_telp,
            ]);

        // Redirect atau lakukan sesuatu setelah berhasil update
        return redirect()->route('admin.pegawai');
    }

    // public function pegawaiSearch(Request $request)
    // {
    //     $searchTerm = $request->search != null ? $request->search : "";
    //     // return response()->json($request->all());
    //     $datas = Pegawai::where(function ($query) use ($searchTerm) {
    //         $query->where('nama', 'like', "%{$searchTerm}%")
    //             ->orWhere('email', 'like', "%{$searchTerm}%")
    //             ->orWhere('NIP', 'like', "%{$searchTerm}%")
    //             ->orWhere('no_telp', 'like', "%{$searchTerm}%")
    //         ;
    //     })
    //         ->where('ptk', $request->ptk)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($request->entry);
    //     return response()->json(compact('datas'));
    // }

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

        $user = User::where('id', $request->id);
        $user->delete();
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
