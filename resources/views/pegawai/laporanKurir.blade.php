@extends('layouts.pegawai')
@section('title', 'Laporan')
@section('content')
    <div class="d-flex gap-5">
        <div>
            <h4>Laporan</h4>
            <h6>Laporan Kurir</h6>
        </div>
        <a href="{{ route('pegawai.laporan') }}">
            <button class="btn text-white" style="background-color: gray;">Tamu</button>
        </a>
        <a href="{{ route('pegawai.laporanKurir') }}">
            <button class="btn text-white" style="background-color: gray;">Kurir</button>
        </a>
    </div>
    <div class="d-flex flex-column gap-3 bg-white p-3 shadow">
        <div class="d-flex gap-3 align-items-center bg-white p-3 shadow">
            {{-- <div>Show</div>
            <select onchange="search()" class="form-select" style="width: 5rem" name="entries" id="entries">
                <option selected value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <div>Entries</div> --}}
            <form action="{{ route('pegawai.laporanKurir') }}" method="GET">
                <div class="d-flex bg-white p-3 shadow" style="border-radius: 15px; border: 1px solid rgb(220, 225, 255); align-items: center;">
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
                <form method="GET" action="{{ route('pegawai.laporanKurir') }}" id="filterForm">
                <select class="form-select" name="lama" id="lama"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" {{ request('lama') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="day" {{ request('lama') == 'day' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ request('lama') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ request('lama') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                </select>
                </form>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('pegawai.exportKurir.pdf') }}" class="btn btn-primary">Export to PDF</a>
            </div>
        </div>
        {{-- <form action="/laporan/kurir" method="post">
            @csrf
            <input type="text" name='search' value="a">
            <input type="number" name='entry' value="10">
            <input type="text" name='lama' value="month">
            <button type="submit">Submit</button>
        </form> --}}
        <div class="d-flex flex-column gap-3 bg-white p-3 shadow" id="myTable">
            {{-- <div class="d-flex justify-content-center">
                {{ $datas->links('pagination::bootstrap-5') }}
            </div>

            @if (count($datas) < 1)
                Data Kosong
            @else --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Kurir</th>
                            <th>Ekspedisi</th>
                            <th>Pegawai Penerima</th>
                            <th>Tanggal & Waktu</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kedatanganEkspedisi as $kurir)
                            <tr>
                                <td>{{ $kurir->ekspedisi->nama_kurir }}</td>
                                <td>{{ $kurir->ekspedisi->ekspedisi }}</td>
                                <td>{{ $kurir->pegawai->user->nama_user }}</td>
                                <td>{{ $kurir->created_at }}</td>
                                <td>
                                    <!-- Icon Orang untuk membuka modal -->
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#detail{{ $kurir->id }}" class="btn">
                                        <i class="bi bi-person-rolodex"></i>
                                    </button>

                                    <!-- Modal yang hanya menampilkan foto -->
                                    <div class="modal fade" id="detail{{ $kurir->id }}" tabindex="-1" aria-labelledby="detail{{ $kurir->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detail{{ $kurir->id }}Label">Foto Kurir</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @if ($kurir->foto != null)
                                                        <img src="{{ Storage::url($kurir->foto) }}" alt="Foto Kurir" class="img-fluid">
                                                    @else
                                                        <p>Foto tidak tersedia</p>
                                                    @endif
                                                </div>
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
                {{ $kedatanganEkspedisi->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/laporanKurir.js') }}"></script>
@endsection
