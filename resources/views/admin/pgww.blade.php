@extends('layouts.admin')
@section('title', 'Pegawai')
@section('content')
    <div>
        <h4>Pegawai</h4>
    </div>
    <h5>Input Data Pegawai</h5>
    <form action="{{ route('addPegawaiAdmin') }}" method="POST" class="d-flex gap-4 w-full bg-white p-5 shadow"
        style="border-radius: 20px">
        @csrf
        <div class="w-50 d-flex flex-column gap-4">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input required type="text" class="form-control" id="nama_user" name="nama_user"
                    placeholder="Masukkan Nama User">
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
                    <option value="produktif rpl">Produktif RPL</option>
                    <option value="matematika">Matematika</option>
                    <option value="produktif akl">Produktif AKL</option>
                    <option value="inggris">Inggris</option>
                </select>
            </div>
        </div>
        <div class="w-50 d-flex flex-column gap-4">
            <div class="form-group">
                <label for="no_telp">No Telp</label>
                <input required type="number"  class="form-control" id="no_telp" name="no_telp"
                    placeholder="Masukkan No HP">
            </div>
            <div class="form-group">
                <label for="NIP">NIP</label>
                <input required type="number" inputmode="numeric" class="form-control" id="nip" name="nip"
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
                <form method="GET" action="{{ route('admin.pegawai') }}" id="filterForm">
                    <select class="form-select" name="body_ptk" id="body_ptk"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('body_ptk') == 'all' ? 'selected' : '' }}>PTK</option>
                        <option value="produktif rpl" {{ request('body_ptk') == 'produktif rpl' ? 'selected' : '' }}>Produktif RPL</option>
                        <option value="matematika" {{ request('body_ptk') == 'matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="produktif akl" {{ request('body_ptk') == 'produktif akl' ? 'selected' : '' }}>Produktif AKL</option>
                        <option value="inggris" {{ request('body_ptk') == 'inggris' ? 'selected' : '' }}>Inggris</option>
                    </select>
                </form>
                <div style="background-color: #F5F7FA;width:60rem;">
                    <form action="{{ route('admin.pegawai') }}" method="GET">
                        <div class="input-group">
                            <div class="position-relative" style="max-width: 150px;">
                                <select name="search_field" id="searchField" class="form-control" style="appearance: none; border-radius: 0.75rem; padding-right: 30px;">
                                    <option value="nama_user">Nama</option>
                                    <option value="no_telp">No Telp</option>
                                    <option value="ptk">PTK</option>
                                    <option value="nip">NIP</option>
                                    <option value="email">Email</option>
                                </select>
                                <!-- Custom arrow icon -->
                                <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="fa fa-caret-down"></i> <!-- Ensure Font Awesome is included -->
                                </span>
                            </div>
                            <input type="text" name="search" id="searchInput" class="form-control rounded-pill" style="border: none; background-color: #F5F7FA;" placeholder="Cari Nama" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <form action="{{ route('admin_import-excel') }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                {{ @csrf_field() }}
                <div class="form-group d-flex align-items-center mb-0">
                    <label for="file" class="mr-2 mb-0">File</label>
                    <input type="file" class="form-control-file mr-2" name="excel_file" id="file">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Import</button>
                <!-- Link ke file template di public/format -->
                <a href="{{ asset('format/template_import_pegawai.xlsx') }}" class="btn btn-success">Download Template</a>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $dat)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dat->user->nama_user }}</td>
                            <td>{{ $dat->no_telp }}</td>
                            <td>{{ $dat->ptk }}</td>
                            <td>{{ $dat->nip }}</td>
                            <td>{{ $dat->user->email }}</td>
                            <td class="d-flex gap-5">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $dat->id_user }}">
                                    <img src="{{ asset('img/edit.png') }}" alt="edit">
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{ $dat->id_user }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Pegawai</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('editPegawaiAdmin', ['id' => $dat->id_user]) }}" method="POST">
                                                <div class="modal-body d-flex gap-2">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $dat->id_user }}">
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="form-group">
                                                            <label for="nama_user">Nama</label>
                                                            <input required value="{{ $dat->user->nama_user }}" type="text" class="form-control" id="nama_user{{ $dat->id_user }}" name="nama_user" placeholder="Masukkan Nama">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input value="{{ $dat->user->email }}" required type="email" class="form-control" id="email{{ $dat->id_user }}" name="email" placeholder="Masukkan Email">
                                                        </div>
                                                        <div>
                                                            <label for="ptk">PTK</label>
                                                            <select required class="form-select" name="ptk" aria-label="ptk">
                                                                <option {{ $dat->ptk == 'produktif_rpl' ? 'selected' : '' }} value="produktif_rpl">Produktif RPL</option>
                                                                <option {{ $dat->ptk == 'matematika' ? 'selected' : '' }} value="matematika">Matematika</option>
                                                                <option {{ $dat->ptk == 'produktif_akl' ? 'selected' : '' }} value="produktif_akl">Produktif AKL</option>
                                                                <option {{ $dat->ptk == 'inggris' ? 'selected' : '' }} value="inggris">Inggris</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="form-group">
                                                            <label for="no_telp">No Telp</label>
                                                            <input value="{{ $dat->no_telp }}" required type="text" inputmode="numeric" class="form-control" id="no_telp{{ $dat->id_user }}" name="no_telp" placeholder="Masukkan No HP">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nip">NIP</label>
                                                            <input value="{{ $dat->nip }}" required type="number" inputmode="numeric" class="form-control" id="nip{{ $dat->id_user }}" name="nip" placeholder="Masukkan NIP">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <a onclick="return confirm('Yakin ingin hapus?')">
                                    <form action="{{ route('deletePegawaiAdmin', ['id' => $dat->id_user]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn">
                                            <img src="{{ asset('img/hapus.png') }}" alt="hapus">
                                        </button>
                                    </form>
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
    <script>
        document.getElementById('searchField').addEventListener('change', function() {
            const searchInput = document.getElementById('searchInput');
            const selectedOption = this.options[this.selectedIndex].text;
            searchInput.placeholder = `Cari ${selectedOption}`;
        });
    </script>
@endsection
