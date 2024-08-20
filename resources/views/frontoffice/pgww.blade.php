@extends('layouts.frontoffice')
@section('title', 'Pegawai')
@section('content')
    <div>
        <h4>Pegawai</h4>
    </div>
    <h5>Input Data Pegawai</h5>
    <form action="{{ route('addPegawai') }}" method="POST" class="d-flex gap-4 w-full bg-white p-5 shadow"
        style="border-radius: 20px">
        @csrf
        <div class="w-50 d-flex flex-column gap-4">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input required type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input required type="email" class="form-control" id="email" name="email"
                    placeholder="Masukkan Email">
            </div>
            <div>
                <label for="ptk">PTK</label>
                <select required class="form-select" name="ptk" aria-label="PTK">
                    <option selected disabled>Pilih</option>
                    <option value="guru">Guru</option>
                    <option value="tendik">Tendik</option>
                </select>
            </div>
        </div>
        <div class="w-50 d-flex flex-column gap-4">
            <div class="form-group">
                <label for="no_telp">No Telp</label>
                <input required type="number" inputmode="numeric" class="form-control" id="no_telp" name="no_telp"
                    placeholder="Masukkan No HP">
            </div>
            <div class="form-group">
                <label for="NIP">NIP</label>
                <input required type="number" inputmode="numeric" class="form-control" id="NIP" name="NIP"
                    placeholder="Masukkan NIP">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input required type="password" class="form-control" id="password" name="password"
                    placeholder="Masukkan Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    <div class="bg-white d-flex flex-column gap-3 p-5 rounded shadow">
        <div class="d-flex justify-content-between">
            <h5>Data Pegawai</h5>
            <div class="d-flex w-50 gap-3">
                <select onchange="search()" class="form-select" style="width: 20rem" name="body_ptk" id="body_ptk">
                    <option selected value="guru">Guru</option>
                    <option value="tendik">Tendik</option>
                </select>
                <div style="background-color: #F5F7FA;width:60rem"
                    class="rounded-pill d-flex gap-1 justify-content-center align-items-center p-1 px-3">
                    <label for="search">
                        <img height="20" width="20" src="{{ asset('img/magnifying-glass 1.png') }}" alt="search">
                    </label>
                    <input oninput="search()" placeholder="Search" style="border: none;background-color: #F5F7FA;"
                        class="form-control rounded-pill" type="text" name="search" id="search_2">
                </div>

                {{-- <button class="btn btn-primary" style="width: 20rem">Import <span><img
                            src="{{ asset('img/import.png') }}" alt="im"></span></button> --}}
            </div>
        </div>
        <div class="container">
            <form action="{{ route('import-excel') }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                {{ @csrf_field() }}
                <div class="form-group d-flex align-items-center mb-0">
                    <label for="file" class="mr-2 mb-0">File</label>
                    <input type="file" class="form-control-file mr-2" name="excel_file" id="file">
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div>

        <div class="d-flex flex-column gap-4" id="myTable">
            <div class="d-flex justify-content-center">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>PTK</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $dat)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dat->nama }}</td>
                            <td>{{ $dat->no_telp }}</td>
                            <td>{{ $dat->ptk }}</td>
                            <td>{{ $dat->NIP }}</td>
                            <td>{{ $dat->email }}</td>
                            <td class="d-flex gap-5">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $dat->id }}">
                                    <img src="{{ asset('img/edit.png') }}" alt="edit">
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{ $dat->id }}" tabindex="-1" aria-labelledby="editModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Pegawai</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('editPegawai', ['id' => $dat->id]) }}" method="post">
                                                <div class="modal-body d-flex gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{ $dat->id }}">
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="form-group">
                                                            <label for="nama">Nama</label>
                                                            <input required value="{{ $dat->nama }}" type="text"
                                                                class="form-control"
                                                                id="{{ $dat->id . 'nama' }}" name="nama"
                                                                placeholder="Masukkan Nama">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input value="{{ $dat->email }}" required type="email"
                                                                class="form-control"
                                                                id="{{ $dat->id . 'email' }}" name="email"
                                                                placeholder="Masukkan Email">
                                                        </div>
                                                        <div>
                                                            <label for="ptk">PTK</label>
                                                            <select required class="form-select" name="ptk"
                                                                aria-label="PTK">
                                                                <option {{ $dat->ptk == 'guru' ? 'selected' : '' }}
                                                                    value="guru">Guru</option>
                                                                <option {{ $dat->ptk == 'tendik' ? 'selected' : '' }}
                                                                    value="tendik">Tendik</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="form-group">
                                                            <label for="no_telp">No Telp</label>
                                                            <input value="{{ $dat->no_telp }}" required type="text"
                                                                inputmode="numeric" class="form-control"
                                                                id="{{ $dat->id . 'no_telp' }}"
                                                                name="no_telp"
                                                                placeholder="Masukkan No HP">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="NIP">NIP</label>
                                                            <input value="{{ $dat->NIP }}" required type="number"
                                                                inputmode="numeric" class="form-control"
                                                                id="{{ $dat->id . 'NIP' }}"
                                                                name="NIP"
                                                                placeholder="Masukkan NIP">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a onclick="return confirm('Yakin ingin hapus?')"
                                    href="{{ route('deletePegawaiAdmin', $dat->id) }}">
                                    <button class="btn">
                                        <img src="{{ asset('img/hapus.png') }}" alt="hapus">
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/pegawai.js') }}"></script>
@endsection
