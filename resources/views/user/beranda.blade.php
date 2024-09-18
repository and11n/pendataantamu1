<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuBook</title>
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
</head>
<body>
    <img src="{{ asset('img/Rectangle 2.svg')}}" class="img" alt="">
    <div class="main-container">
        <header>
            <div class="logo">
                <img src="{{ asset('img/logo2.png') }}"  alt="GuBook Logo">
            </div>
            <nav>
                <a href="{{route('beranda')}}">Beranda</a>
                <a href="{{route('datGuru')}}">Pegawai</a>
                <a href="{{route('about')}}">Tentang</a>
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

        <div class="content-container">
            <div class="left-section">
                <h1>SELAMAT DATANG</h1>
                <p>Datanglah Dengan Senang Hati<br>Kami Layani Sepenuh Hati</p>
                <a href="{{route('kedTamu')}}" style="text-decoration: none; color:black" class="cta-button">Buat Pertemuan</a>
            </div>
            <div class="right-section">
                <div class="circular-image">
                    <img src="{{ asset('img/sekolah.jpeg') }}" alt="Sekolah">
                </div>
            </div>
        </div>
    </div>

    <script>
        // document.querySelector('.cta-button').addEventListener('click', function() {
        //     alert('Fitur pembuatan pertemuan akan segera tersedia!');
        // });

        function showLoginPopup() {
            document.getElementById('loginPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('loginPopup').style.display = 'none';
        }

        // function proceedLogin() {
        //     // Implementasi logika login di sini
        //     alert('Melanjutkan ke proses login...');
        //     closePopup();
        // }
    </script>
</body>
</html>
