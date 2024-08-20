@extends('layouts.pegawai')
@section('title', 'Laporan')
@section('content')
    <div class="d-flex gap-5">
        <div>
            <h4>Laporan</h4>
            <h6>Laporan Tamu</h6>
        </div>
        <a href="{{ route('pegawai.laporan') }}">
            <button class="btn text-white" style="background-color: gray;">Tamu</button>
        </a>
        <a href="{{ route('pegawai.laporanKurir') }}">
            <button class="btn text-white" style="background-color: gray;">Kurir</button>
        </a>
    </div>
    <div class="d-flex flex-column gap-3">
        <div class="d-flex gap-3 align-items-center">
            <div>Show</div>
            <select onchange="search()" class="form-select" style="width: 5rem" name="entries" id="entries">
                <option selected value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <div>Entries</div>
            <div class="d-flex bg-white p-3 shadow" style="border-radius: 15px;border:1px solid rgb(220, 225, 255)">
                <img width="24" height="24" src="{{ asset('img/akar-icons_search.png') }}" alt="search">
                <input oninput="search()" class="bg-white" style="border: none;" type="text" name="search"
                    id="search_2">
                <img width="24" height="24" src="{{ asset('img/uil_calender.png') }}" alt="calendar">
            </div>
            <select onchange="search()" class="form-select" name="lama" id="lama">
                <option value="all">Semua</option>
                <option value="day">Hari Ini</option>
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
            </select>
            <button class="btn btn-primary" style="width: 20rem">Export File</button>
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
                            <th>No. Telp.</th>
                            <th>Alamat</th>
                            <th>Pegawai</th>
                            <th>Tanggal & Waktu</th>
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->no_telp }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->pegawai->nama }}</td>
                                @if (in_array($data->status, ['menunggu', 'ditolak', 'tidakDatang']))
                                    <td>{{ $data->waktu_perjanjian }}</td>
                                @elseif (in_array($data->status, ['diterima', 'selesai']))
                                    <td>{{ $data->waktu_kedatangan }}</td>
                                @endif
                                <td>{{ $data->instansi }}</td>
                                <td>{{ $data->status }}</td>
                                <td>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#detail{{ $data->id }}" class="btn"><img
                                            src="{{ asset('img/detail.png') }}" alt="detail"></button>
                                    <div class="modal fade" id="detail{{ $data->id }}" tabindex="-1"
                                        aria-labelledby="detail{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="detail{{ $data->id }}Label">Detail
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Nama Tamu : {{ $data->nama }}
                                                    Bertemu Dengan : {{ $data->pegawai->nama }}
                                                    Waktu Pertemuan : {{ $data->waktu_kedatangan }}
                                                    <form id="formKeterangan" action="{{ route('ubahKeteranganTamu') }}"
                                                        method="post">
                                                        @csrf
                                                        Keterangan :
                                                        <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control">{{ $data->keterangan }}</textarea>
                                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                                    </form>
                                                    @if ($data->foto != null)
                                                        <img src="{{ asset('img/tamu/' . $data->foto) }}" alt="">
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button"
                                                        onclick="document.getElementById('formKeterangan').submit()"
                                                        class="btn btn-primary">Simpan Keterangan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            {{-- @endif --}}
            {{-- <div class="d-flex justify-content-center">
                {{ $datas->links('pagination::bootstrap-5') }}
            </div> --}}
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/laporan.js') }}"></script>
@endsection
