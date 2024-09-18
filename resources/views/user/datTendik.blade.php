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
        <div class="search-box">
            <input type="text" placeholder="Search..." id="search">
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows will be populated here -->
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
