@extends('layouts.frontoffice')
@section('title', 'Pegawai')
@section('content')
    <div>
        <h4>Pegawai</h4>
    </div>
    <h5>Input Data Pegawai</h5>
    <div class="bg-white d-flex flex-column gap-3 p-5 rounded shadow">
        <div class="d-flex justify-content-between">
            <h5>Data Pegawai</h5>
            <div class="d-flex w-50 gap-3">
                <form method="GET" action="{{ route('fo.pegawai') }}" id="filterForm" class="d-flex w-50 gap-3">
                    <select class="form-select" name="body_ptk" id="body_ptk" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('body_ptk') == 'all' ? 'selected' : '' }}>PTK</option>
                        <option value="produktif rpl" {{ request('body_ptk') == 'produktif rpl' ? 'selected' : '' }}>Produktif RPL</option>
                        <option value="matematika" {{ request('body_ptk') == 'matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="produktif akl" {{ request('body_ptk') == 'produktif akl' ? 'selected' : '' }}>Produktif AKL</option>
                        <option value="inggris" {{ request('body_ptk') == 'inggris' ? 'selected' : '' }}>Inggris</option>
                    </select>

                    <div style="background-color: #F5F7FA;width:60rem" class="rounded-pill d-flex gap-1 justify-content-center align-items-center p-1 px-3">
                        <label for="search">
                            <img height="20" width="20" src="{{ asset('img/magnifying-glass 1.png') }}" alt="search">
                        </label>
                        <input oninput="document.getElementById('filterForm').submit()" placeholder="Search"
                               style="border: none;background-color: #F5F7FA;"
                               class="form-control rounded-pill" type="text" name="search" id="search_2" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="container">
            <form action="{{ route('import-excel') }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                {{ @csrf_field() }}
                <div class="form-group d-flex align-items-center mb-0">
                    <label for="file" class="mr-2 mb-0">File</label>
                    <input type="file" class="form-control-file mr-2" name="excel_file" id="file">
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div> --}}

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
