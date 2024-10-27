<!DOCTYPE html>
<html lang="id">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        @yield('style')
    </head>
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/logo3.png') }}" alt="GuBook Logo">
        </div>
        <nav>
            <a href="{{ route('beranda') }}">Beranda</a>
            {{-- <a href="{{ route('datGuru') }}">Pegawai</a> --}}
            <a href="{{ route('about') }}">Tentang</a>
            <div id="loginPopup" class="popup" style="display: none;">
                <div class="popup-content">
                    <img src="{{ asset('img/pop1.png') }}" alt="Login Illustration" class="popup-image">
                    <h2>Khusus Pegawai,<br>Apakah anda yakin ingin masuk?</h2>
                    <div class="buttons">
                        <button class="btn-no" onclick="closePopup()">TIDAK</button>
                        <a href="{{ route('loginui') }}" class="btn-yes" onclick="proceedLogin()">YA</a>
                    </div>
                </div>
            </div>
            <button onclick="showLoginPopup()" class="login-btn">Login</button>
            {{-- <a href="{{route('loginn')}}"  class="login-btn">Login</a> --}}
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main class="bg-white">
        @yield('content')
        {{-- <img src="{{asset('img/sekolah2.png')}}" class="sekolah2" alt=""> --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (Session::has('success'))
                    Swal.fire({
                        title: "Terimakasih😉!",
                        text: "{{ Session::get('success') }}",
                        icon: "success"
                    });
                @endif
            });

                        function showLoginPopup() {
                        document.getElementById('loginPopup').style.display = 'block';
                    }

                    function closePopup() {
                        document.getElementById('loginPopup').style.display = 'none';
                    }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </main>
</body>

</html>
