<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Notifikasi Kedatangan Tamu</h1>
    <p>Kepada Yth. {{ $kedatangan->pegawai->user->nama_user }},</p>
    <p>Terdapat kunjungan hari ini di jam {{ \Carbon\Carbon::parse($kedatanganTamu->waktu_kedatangan)->format('H:i') }}</p>
    <ul>
        <li>Nama Tamu: {{ $kedatanganTamu->tamu->nama }}</li>
        <li>Email Tamu: {{ $kedatanganTamu->tamu->email }}</li>
    </ul>
    <p>Terima kasih atas perhatiannya.</p>
</body>
</html>

