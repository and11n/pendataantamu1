@extends('layouts.user')

@section('content')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">

<div class="container">
    <header>
        <h1>Guru dan Tenaga Pendidik</h1>
        <div class="buttons">
            <a href="{{route('datGuru')}}" class="btn guru">Guru</a>
            <a href="{{route('datTendik')}}" class="btn tendik">Tendik</a>
        </div>
    </header>

    <main>
        <form action="{{ route('datGuru') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari pegawai" value="{{ request('search') }}">
                {{-- <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div> --}}
            </div>
        </form>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $dat)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $dat->nip }}</td>
                        <td>{{ $dat->user->nama_user }}</td>
                        <td>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#detail{{ $dat->nip }}" class="btn">
                                <img src="{{ asset('img/detail1.png') }}" alt="detail">
                            </button>
                            <div class="modal fade" id="detail{{ $dat->nip }}" tabindex="-1" aria-labelledby="detail{{ $dat->nip }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="detail{{ $dat->nip }}Label">Detail</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="w-50 d-flex flex-column gap-4">
                                                <div>
                                                    <label for="nama_user">Nama</label>
                                                    <p>{{ $dat->user->nama_user }}</p>
                                                </div>
                                                <div>
                                                    <label for="email">Email</label>
                                                    <p>{{ $dat->user->email }}</p>
                                                </div>
                                                <div>
                                                    <label for="ptk">PTK</label>
                                                    <p>{{ $dat->ptk }}</p>
                                                </div>
                                                <div>
                                                    <label for="nip">NIP</label>
                                                    <p>{{ $dat->nip }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            <div class="d-flex justify-content-center">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>
</div>
<footer class="footer mt-auto py-3 bs-primary-bg-subtle">
    {{-- <div class="container text-center">
            <div class="footer-links">
                <a href="#" class="text-muted mx-2">Privacy Policy</a>
                <a href="#" class="text-muted mx-2">Terms of Service</a>
                <a href="#" class="text-muted mx-2">Contact</a>
            </div>
        </div> --}}
</footer>
@endsection

@section('script')
    <script src="{{ asset('js/pegawai.js') }}"></script>
@endsection
