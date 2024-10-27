<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - GuBook</title>
    <link href="{{ asset('css/us.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            {{-- <div class="logo">
                <img src="{{ asset('img/logo2.png') }}"  alt="GuBook Logo">
            </div> --}}
            <div class="nav-links">
                <a href="{{route('beranda')}}">Beranda</a>
                <a href="{{route('datGuru')}}">Pegawai</a>
                <a href="{{route('about')}}">Tentang</a>
            </div>
        </nav>
    </header>
    <img src="{{ asset('img/school-bg.png') }}" class="heroSection">

    <main>
        <section class="hero">
            <h1>Tentang Kami</h1>
            <p>GuBook atau Guest Book adalah platform manajemen tamu sekolah yang inovatif, dirancang khusus untuk memudahkan proses pendataan tamu di sekolah. Dengan antarmuka yang user-friendly dan fitur-fitur canggih, GuBook membantu sekolah dalam mencatat, mengelola, dan memantau kunjungan tamu dengan lebih efisien dan terorganisir.</p>
            <a href="{{route('kedTamu')}}" style="text-decoration: none;" class="cta-button">Buat Pertemuan</a>
        </section>

        <section class="features">
            <h2>Mengapa Kami Penting?</h2>
            <div class="feature-cards">
                <div class="card">
                    <img src="{{asset('img/check-icon.png')}}" alt="Keamanan Terjamin">
                    <h3>Keamanan Terjamin</h3>
                    <p>Sistem keamanan data yang canggih untuk melindungi informasi penting.</p>
                </div>
                <div class="card">
                    <img src="{{asset('img/people-icon.png')}}" alt="Manajemen Pengguna">
                    <h3>Manajemen Pengguna</h3>
                    <p>Pengelolaan akun dan hak akses yang fleksibel dan mudah.</p>
                </div>
                <div class="card">
                    <img src="{{asset('img/chart-icon.png')}}" alt="Pelaporan Ringkas">
                    <h3>Pelaporan Ringkas</h3>
                    <p>Generasi laporan otomatis untuk analisis data yang cepat.</p>
                </div>
            </div>
        </section>

        <section class="contact">
            <div class="card" style="width: 40rem; height: auto; background-color:#E3F2FD">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15844.002498366064!2d107.5583301!3d-6.8905271!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6bd6aaaaaab%3A0xf843088e2b5bf838!2sSMK%20Negeri%2011%20Bandung!5e0!3m2!1sen!2sid!4v1725437798559!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            </div>
            <div class="contact-info">
                <div class="card" style="width: 32rem; height: 32rem; background-color:#E3F2FD">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"><br>
                        <h5 class="card-title" style="font-size: 2.2rem; text-align:center;">Kontak</h5>
                        <p class="card-text" style="font-size: 1.5rem; text-align:center;">Silahkan Hubungi Kami dibawah ini</p><br>
                        <div style="text-align: center;">
                            <a href="tel:+62226652442" class="card-link" style="text-decoration: none; color:#666666; font-size:1.25rem;">
                                <i class="bi bi-telephone"></i> (022) 6652442
                            </a><br><br>
                            <a href="https://web.facebook.com/smkn11bdg/?_rdc=1&_rdr" class="card-link" style="text-decoration: none; color:#666666; font-size:1.25rem;">
                                <i class="bi bi-facebook"></i> Wargi Sabelas
                            </a><br><br>
                            <a href="https://www.instagram.com/info.smkn11bandung" class="card-link" style="text-decoration: none; color:#666666; font-size:1.25rem;">
                                <i class="bi bi-instagram"></i> @info.smkn11bdg
                            </a><br><br>
                            <a href="https://www.youtube.com/c/SMKN11BANDUNG" class="card-link" style="text-decoration: none; color:#666666; font-size:1.25rem;">
                                <i class="bi bi-youtube"></i> SMKN11BANDUNG
                            </a><br><br>
                            <a href="mailto:smkn11bdg@gmail.com" class="card-link" style="text-decoration: none; color:#666666; font-size:1.25rem;">
                                <i class="bi bi-envelope"></i> smkn11bdg@gmail.com
                            </a>
                        </div>
                      </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="{{asset('img/sek-f.png')}}" alt="Logo 1">
                <img src="{{asset('img/log-f.png')}}" alt="Logo 2">
            </div>
            {{-- <div class="footer-links"> --}}
                <div>
                    <h4><a href="{{route('beranda')}}" style="text-decoration: none; color:white">Beranda</a></h4>
                    <ul>
                        <li><a href="{{route('kedTamu')}}" style="text-decoration: none; color:white">Tamu</a></li>
                        <li><a href="{{route('kedKurir')}}" style="text-decoration: none; color:white">Kurir</a></li>
                    </ul>
                </div>
                <div>
                    <h4><a href="{{route('datGuru')}}" style="text-decoration: none; color:white"></a>Pegawai</h4>
                    <ul>
                        <li><a href="{{route('datGuru')}}" style="text-decoration: none; color:white">Guru</a></li>
                        <li><a href="{{route('datTendik')}}" style="text-decoration: none; color:white">Tendik</a></li>
                    </ul>
                </div>
                <div>
                    <h4><a href="{{route('about')}}" style="text-decoration: none; color:white"></a>Tentang</h4>
                    <p><a href="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15844.002498366064!2d107.5583301!3d-6.8905271!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6bd6aaaaaab%3A0xf843088e2b5bf838!2sSMK%20Negeri%2011%20Bandung!5e0!3m2!1sen!2sid!4v1725437798559!5m2!1sen!2sid" class="card-link" style="text-decoration: none; color:white">Jl. Raya Cilember Sukaraja,<br>Kec. Cicendo, Kota Bandung</a></p>
                </div>
            {{-- </div> --}}
        </div>
        <div class="copyright">
            <p>GuBook &copy; 2024 </p>
        </div>
    </footer>
</body>
</html>
