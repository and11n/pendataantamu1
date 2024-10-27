<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tamu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e6f3ff;
        }
        @media screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Laporan Tamu</h1>
    <table>
        <thead>
            <tr>
                <th>Tamu</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Pegawai</th>
                <th>Tanggal & Waktu</th>
                <th>Instansi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kedatanganTamu as $tamu)
                <tr>
                    <td>{{ $tamu->tamu->nama }}</td>
                    <td>{{ $tamu->tamu->no_telp }}</td>
                    <td>{{ $tamu->tamu->alamat }}</td>
                    <td>{{ $tamu->pegawai->user->nama_user }}</td>
                    <td>{{ $tamu->waktu_kedatangan }}</td>
                    <td>{{ $tamu->instansi }}</td>
                    <td>{{ $tamu->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
