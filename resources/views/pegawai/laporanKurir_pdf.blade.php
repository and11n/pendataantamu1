<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ekspedisi</title>
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
    <h1>Laporan Ekspedisi</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Kurir</th>
                <th>Ekspedisi</th>
                <th>Pegawai Penerima</th>
                <th>Tanggal & Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kedatanganEkspedisi as $kurir)
                <tr>
                    <td>{{ $kurir->ekspedisi->nama_kurir }}</td>
                    <td>{{ $kurir->ekspedisi->ekspedisi }}</td>
                    <td>{{ $kurir->pegawai->user->nama_user }}</td>
                    <td>{{ $kurir->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
