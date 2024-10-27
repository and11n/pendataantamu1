<!DOCTYPE html>
<html>
<head>
    <title>Email Pemberitahuan</title>
</head>
<body>
    {{-- <h1>Halo, {{ $nama_user }}</h1> --}}
    <h2>Ada paket baru nih</h2>
    <p>atas nama {{ $nama_kurir }}</p>
    <p>ekspedisi: {{ $ekspedisi }}</p>
    <p>Berikut adalah foto kurir tersebut:</p>
    <img src="{{ asset($foto) }}" alt="QR Code">
</body>
</html>
