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
        <form action="{{ route('datTendik') }}" method="GET" class="mb-3">
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
                    <th>#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>196508011993031010</td>
                    <td>Asep Rachmat, S.Pd</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>196508231991122001</td>
                    <td>Ela Solihat, S.Pd</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>197507212014101003</td>
                    <td>Hata, S.Kom</td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
            {{-- <div class="d-flex justify-content-center">
                {{ $data->links('pagination::bootstrap-5') }}
            </div> --}}
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
