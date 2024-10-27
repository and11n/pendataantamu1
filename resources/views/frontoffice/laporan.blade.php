@extends('layouts.frontoffice')
@section('title', 'Laporan')
@section('content')
    <div class="d-flex gap-5">
        <div>
            <h4>Laporan</h4>
            <h6>Laporan Tamu</h6>
        </div>
        <a href="{{ route('frontoffice.laporan') }}">
            <button class="btn text-white" style="background-color: gray;">Tamu</button>
        </a>
        <a href="{{ route('frontoffice.laporanKurir') }}">
            <button class="btn text-white" style="background-color: gray;">Kurir</button>
        </a>
    </div>
    <div class="d-flex flex-column gap-3 bg-white p-3 shadow">
        <div class="d-flex gap-3 align-items-center bg-white p-3 shadow">
            <form action="{{ route('frontoffice.laporan') }}" method="GET">
                <div class="d-flex gap-3"
                    style="border-radius: 15px; border: 1px solid rgb(220, 225, 255); align-items: center;">
                    {{-- <img width="24" height="24" src="{{ asset('img/akar-icons_search.png') }}" alt="search">
                    <input class="bg-white border-0" type="text" name="search" id="search_2"
                        value="{{ request('search') }}" placeholder="Search...">
                    <img width="24" height="24" src="{{ asset('img/uil_calender.png') }}" alt="calendar"> --}}

                    <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Start Date" class="mx-2">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="End Date">
                    <button type="submit" class="btn btn-primary mx-2">Search</button>
                </div>
            </form>
            <div class="d-flex gap-3">
                <form method="GET" action="{{ route('frontoffice.laporan') }}" id="filterForm">
                    <select class="form-select" name="status" id="status"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
            <div class="d-flex gap-3">
                {{-- <a href="{{ route('FO.export.excel') }}" class="btn btn-primary">Export to Excel</a> --}}
                <a href="{{ route('frontoffice.export.pdf') }}" class="btn btn-primary">Export to PDF</a>
            </div>
        </div>

        {{-- <form action="/laporan/tamu" method="post">
            @csrf
            <input type="text" name='search' value="a">
            <input type="number" name='entry' value="10">
            <input type="text" name='lama' value="month">
            <button type="submit">Submit</button>
        </form> --}}

        <div class="d-flex flex-column gap-3" id="myTable">
            {{-- <div class="d-flex justify-content-center">
                {{ $datas->links('pagination::bootstrap-5') }}
            </div>
            @if (count($datas) < 1)
                Data Kosong
            @else --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tamu</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Pegawai</th>
                            <th>Tanggal & Waktu</th>
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kedatanganTamu as $tamu)
                            <tr>
                                <td>{{ $tamu->tamu->nama }}</td>
                                <td>{{ $tamu->tamu->no_telp }}</td>
                                <td>{{ $tamu->tamu->alamat }}</td>
                                <td>{{ $tamu->pegawai->user->nama_user }}</td>
                                @if (in_array($tamu->status, ['menunggu', 'ditolak', 'tidakDatang']))
                                    <td>{{ $tamu->waktu_perjanjian }}</td>
                                @elseif (in_array($tamu->status, ['diterima', 'selesai']))
                                    <td>{{ $tamu->waktu_kedatangan }}</td>
                                @endif
                                <td>{{ $tamu->instansi }}</td>
                                <td>{{ $tamu->status }}</td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail{{ $tamu->id }}"
                                        class="btn"><img src="{{ asset('img/detail.png') }}" alt="detail"></button>
                                    <div class="modal fade" id="detail{{ $tamu->id }}" tabindex="-1"
                                        aria-labelledby="detail{{ $tamu->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detail{{ $tamu->id }}Label">Detail
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>Nama Tamu :</b> {{ $tamu->tamu->nama }}</p>
                                                    <p><b>Dengan :</b> {{ $tamu->pegawai->user->nama_user }}</p>
                                                    <p><b>No Telepon :</b> {{$tamu->tamu->no_telp}}</p>
                                                    <p><b>Waktu Perjanjian :</b> {{ $tamu->waktu_perjanjian }}</p>
                                                    <p><b>Waktu Kedatangan :</b> {{ $tamu->waktu_kedatangan }}</p>
                                                    <b>Foto:</b> <img src="{{ asset('storage/' . $tamu->foto)}}" alt="Foto Tamu" class="img-fluid"><br>
                                                    {{-- @if ($tamu->foto)
                                                        <img src="{{ Storage::url($tamu->foto)}}" alt="Foto Tamu" class="img-fluid">
                                                    @else
                                                        <p>foto tidak tersedia tersedia.</p>
                                                    @endif --}}
                                                    {{-- <form id="formKeterangan" action="{{ route('ubahKeteranganTamu') }}"
                                                                method="post">
                                                                @csrf
                                                                Keterangan :
                                                                <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control">{{ $tamu->keterangan }}</textarea>
                                                                <input type="hidden" name="id" value="{{ $tamu->id }}">
                                                            </form>
                                                            @if ($tamu->foto != null)
                                                                <img src="{{ asset('img/tamu/' . $tamu->foto) }}" alt="">
                                                            @endif --}}
                                                </div>
                                                {{-- <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button"
                                                            onclick="document.getElementById('formKeterangan').submit()"
                                                            class="btn btn-primary">Simpan Keterangan</button>
                                                    </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            {{-- @endif --}}
            <div class="d-flex justify-content-center">
                {{ $kedatanganTamu->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/laporan.js') }}"></script>
@endsection
