<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @yield('style')

</head>

<body>
   <nav style="border-bottom: 1px solid rgb(214, 214, 214); z-index: 10;"
    class="p-1 shadow-sm d-flex align-items-center justify-content-between w-full">
    <div class="d-flex align-items-center gap-4">
        <div style="margin-top: -13px; margin-left: 15px;"><img src="{{ asset('img/logo.jpg') }}" alt="logo" style="height: 50px;"></div>
        <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" class="btn"><img
                src="{{ asset('img/hamburger.png') }}" alt="menu" style="height: 17px;"></button>
    </div>
    <div class="d-flex gap-3 justify-content-center align-items-center">
        {{-- <div style="background-color: #F5F7FA; height: 35px;"
            class="rounded-pill d-flex gap-2 justify-content-center align-items-center p-1 px-3">
            <label for="search">
                <img height="20" width="20" src="{{ asset('img/magnifying-glass 1.png') }}" alt="search">
            </label>
            <input placeholder="Search" style="border: none; background-color: #F5F7FA; font-size: 0.9rem;"
                class="form-control rounded-pill" type="text" name="search" id="search">
        </div> --}}
        <div>
            <button style="background-color: #F5F7FA;" class="btn rounded-circle p-2">
                <img src="{{ asset('img/setting.png') }}" alt="" style="height: 25px;">
            </button>
        </div>
        <div>
            <button style="background-color: #F5F7FA;" class="btn rounded-circle p-2">
                <img src="{{ asset('img/notif.png') }}" alt="" style="height: 25px;">
            </button>
        </div>
        <div>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="font-size: 1rem;">
                    {{ Auth::user()->nama_user }}
                </button>
                <ul class="dropdown-menu">
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    {{-- <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li> --}}
                </ul>
            </div>
        </div>
        <div style="margin-left: -10px;">
            <img src="{{ asset('img/user.png') }}" alt="" style="height: 32px;">
        </div>
    </div>
</nav>


<div style="background-color: #F5F7FA; width: 100%; min-height: 100vh;" class="d-flex flex-column gap-2 p-3">
    @yield('content')
</div>
<div style="margin-top: 54px; width: 200px;" class="offcanvas offcanvas-start" data-bs-scroll="true"
    data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div style="color: #B1B1B1; padding-left: 0px; padding-right: 0px;" class="offcanvas-body mt-4 ps-3 d-flex flex-column gap-2">
        <x-sidebar-item :href="route('frontoffice.dashboard')" :active="request()->routeIs('dashboard')" :img="asset('img/home.png')" :activeimg="asset('img/home-active.png')">
            Dashboard
        </x-sidebar-item>
        <x-sidebar-item :href="route('fo.pegawai')" :active="request()->routeIs('pegawai')" :img="asset('img/pegawai.png')" :activeimg="asset('img/pegawai-active.png')">
            Pegawai
        </x-sidebar-item>
        <x-sidebar-item :href="route('frontoffice.kunjungan')" :active="request()->routeIs('kunjungan')" :img="asset('img/kunjungan.png')" :activeimg="asset('img/kunjungan-active.png')">
            Kunjungan
        </x-sidebar-item>
        <x-sidebar-item :href="route('fo.laporan')" :active="request()->routeIs('laporan') || request()->routeIs('laporanKurir')" :img="asset('img/laporan.png')" :activeimg="asset('img/laporan-active.png')">
            Laporan
        </x-sidebar-item>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @yield('script')
</body>

</html>
