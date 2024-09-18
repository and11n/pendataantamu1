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
            <div style="background-color: #F5F7FA;width:60rem" class="rounded-pill d-flex gap-1 justify-content-center align-items-center p-1 px-3">
                <label for="search">
                    <img height="20" width="20" src="{{ asset('img/magnifying-glass 1.png') }}" alt="search">
                </label>
                <input oninput="search()" placeholder="Search"
                       style="border: none;background-color: #F5F7FA;"
                       class="form-control rounded-pill" type="text" name="search" id="search_2">
            </div>
        </div>

        {{-- <form action="{{ route('searchTamu') }}" method="GET">
    <input type="text" name="search" placeholder="Cari nama tamu" class="form-control">
    <button type="submit" class="btn btn-primary">Cari</button>
</form> --}}

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
                                    {{-- Detail data tamu ditampilkan di sini --}}
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
@push('myscript')
        <script>
        document.getElementById('search_2').addEventListener('input', function() {
            filterTable();
        });

        document.getElementById('body_ptk').addEventListener('change', function() {
            filterTable();
        });

        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            var selectFilter = document.getElementById('body_ptk').value.toLowerCase();
            input = document.getElementById('searchInput');
            filter = input.value.toLowerCase();
            table = document.querySelector('tbody');
            tr = table.getElementsByTagName('tr');

            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = 'none';
                td = tr[i].getElementsByTagName('td');
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().includes(filter) &&
                            (selectFilter === "" || td[3].textContent.toLowerCase().includes(selectFilter))) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }

        </script>

@endpush
