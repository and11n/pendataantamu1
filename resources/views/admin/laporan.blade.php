@extends('layouts.admin')
@section('title', 'Laporan')
@section('content')
    <div class="d-flex gap-5">
        <div>
            <h4>Laporan</h4>
            <h6>Laporan Tamu</h6>
        </div>
        <a href="{{ route('admin.laporan') }}">
            <button class="btn text-white" style="background-color: gray;">Tamu</button>
        </a>
        <a href="{{ route('admin.laporanKurir') }}">
            <button class="btn text-white" style="background-color: gray;">Kurir</button>
        </a>
    </div>

    <div class="d-flex flex-column gap-3 bg-white p-3 shadow">
        <div class="d-flex gap-3 align-items-center bg-white p-3 shadow">
            <form action="{{ route('admin.laporan') }}" method="GET">
                <div class="d-flex gap-3" style="border-radius: 15px; border: 1px solid rgb(220, 225, 255); align-items: center;">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Start Date" class="mx-2">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="End Date">
                    <button type="submit" class="btn btn-primary mx-2">Search</button>
                </div>
            </form>
            <div class="d-flex gap-3">
                <form method="GET" action="{{ route('admin.laporan') }}" id="filterForm">
                    <select class="form-select" name="status" id="status" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.export.excel') }}" class="btn btn-primary">Export to Excel</a>
                <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger">Export to PDF</a>
            </div>
        </div>

        <div class="d-flex flex-column gap-3 bg-white p-3 shadow" id="myTable">
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
        </div>
        <div class="d-flex justify-content-center">
            {{ $kedatanganTamu->links('pagination::bootstrap-5') }}
        </div>
        {{-- <div class="drawer drawer-end col-span-1 z-10">
            <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <label for="my-drawer-4" class="drawer-button btn font-normal">
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 2.00245C4.73478 2.00245 4.48043 2.10781 4.29289 2.29534C4.10536 2.48288 4 2.73723 4 3.00245C4 3.26767 4.10536 3.52202 4.29289 3.70956C4.48043 3.89709 4.73478 4.00245 5 4.00245C5.26522 4.00245 5.51957 3.89709 5.70711 3.70956C5.89464 3.52202 6 3.26767 6 3.00245C6 2.73723 5.89464 2.48288 5.70711 2.29534C5.51957 2.10781 5.26522 2.00245 5 2.00245ZM2.17 2.00245C2.3766 1.41692 2.75974 0.909884 3.2666 0.55124C3.77346 0.192596 4.37909 0 5 0C5.62091 0 6.22654 0.192596 6.7334 0.55124C7.24026 0.909884 7.6234 1.41692 7.83 2.00245H15C15.2652 2.00245 15.5196 2.10781 15.7071 2.29534C15.8946 2.48288 16 2.73723 16 3.00245C16 3.26767 15.8946 3.52202 15.7071 3.70956C15.5196 3.89709 15.2652 4.00245 15 4.00245H7.83C7.6234 4.58798 7.24026 5.09502 6.7334 5.45366C6.22654 5.81231 5.62091 6.0049 5 6.0049C4.37909 6.0049 3.77346 5.81231 3.2666 5.45366C2.75974 5.09502 2.3766 4.58798 2.17 4.00245H1C0.734784 4.00245 0.48043 3.89709 0.292893 3.70956C0.105357 3.52202 0 3.26767 0 3.00245C0 2.73723 0.105357 2.48288 0.292893 2.29534C0.48043 2.10781 0.734784 2.00245 1 2.00245H2.17ZM11 8.00245C10.7348 8.00245 10.4804 8.10781 10.2929 8.29534C10.1054 8.48288 10 8.73723 10 9.00245C10 9.26767 10.1054 9.52202 10.2929 9.70956C10.4804 9.89709 10.7348 10.0025 11 10.0025C11.2652 10.0025 11.5196 9.89709 11.7071 9.70956C11.8946 9.52202 12 9.26767 12 9.00245C12 8.73723 11.8946 8.48288 11.7071 8.29534C11.5196 8.10781 11.2652 8.00245 11 8.00245ZM8.17 8.00245C8.3766 7.41692 8.75974 6.90988 9.2666 6.55124C9.77346 6.1926 10.3791 6 11 6C11.6209 6 12.2265 6.1926 12.7334 6.55124C13.2403 6.90988 13.6234 7.41692 13.83 8.00245H15C15.2652 8.00245 15.5196 8.10781 15.7071 8.29534C15.8946 8.48288 16 8.73723 16 9.00245C16 9.26767 15.8946 9.52202 15.7071 9.70956C15.5196 9.89709 15.2652 10.0025 15 10.0025H13.83C13.6234 10.588 13.2403 11.095 12.7334 11.4537C12.2265 11.8123 11.6209 12.0049 11 12.0049C10.3791 12.0049 9.77346 11.8123 9.2666 11.4537C8.75974 11.095 8.3766 10.588 8.17 10.0025H7C6.73478 10.0025 6.48043 9.89709 6.29289 9.70956C6.10536 9.52202 6 9.26767 6 9.00245C6 8.73723 6.10536 8.48288 6.29289 8.29534C6.48043 8.10781 6.73478 8.00245 7 8.00245H8.17ZM5 14.0025C4.73478 14.0025 4.48043 14.1078 4.29289 14.2953C4.10536 14.4829 4 14.7372 4 15.0025C4 15.2677 4.10536 15.522 4.29289 15.7096C4.48043 15.8971 4.73478 16.0025 5 16.0025C5.26522 16.0025 5.51957 15.8971 5.70711 15.7096C5.89464 15.522 6 15.2677 6 15.0025C6 14.7372 5.89464 14.4829 5.70711 14.2953C5.51957 14.1078 5.26522 14.0025 5 14.0025ZM2.17 14.0025C2.3766 13.4169 2.75974 12.9099 3.2666 12.5512C3.77346 12.1926 4.37909 12 5 12C5.62091 12 6.22654 12.1926 6.7334 12.5512C7.24026 12.9099 7.6234 13.4169 7.83 14.0025H15C15.2652 14.0025 15.5196 14.1078 15.7071 14.2953C15.8946 14.4829 16 14.7372 16 15.0025C16 15.2677 15.8946 15.522 15.7071 15.7096C15.5196 15.8971 15.2652 16.0025 15 16.0025H7.83C7.6234 16.588 7.24026 17.095 6.7334 17.4537C6.22654 17.8123 5.62091 18.0049 5 18.0049C4.37909 18.0049 3.77346 17.8123 3.2666 17.4537C2.75974 17.095 2.3766 16.588 2.17 16.0025H1C0.734784 16.0025 0.48043 15.8971 0.292893 15.7096C0.105357 15.522 0 15.2677 0 15.0025C0 14.7372 0.105357 14.4829 0.292893 14.2953C0.48043 14.1078 0.734784 14.0025 1 14.0025H2.17Z" fill="black" />
                    </svg>
                </label>
            </div>
            <div class="drawer-side">
                <label for="my-drawer-4" class="drawer-overlay"></label>
                <ul class="menu p-4 w-80 bg-base-100">
                    <li>
                        <a href="{{ route('admin.laporan') }}">Laporan Tamu</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporanKurir') }}">Laporan Kurir</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings') }}">Settings</a>
                    </li>
                </ul>
            </div>
        </div> --}}
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/laporan.js') }}"></script>
@endsection
