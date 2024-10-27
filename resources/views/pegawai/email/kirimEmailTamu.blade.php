<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Pemberitahuan permintaan kunjungan</h1>

    <p>{{$emailSubject}}</p>

    @if ($status == 'Diterima')
        <p>Terima Kasih Permintaan Pertemuan {{ $status }}</p>
    @elseif ($status == 'Ditolak')
        <p>Mohon maaf, permintaan pertemuan anda {{ $status }}</p>
        <p>dengan keterangan {{ $kedatangan->alasan }}</p>
    @endif
</body>

</html>
