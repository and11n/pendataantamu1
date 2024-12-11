<!-- resources/views/FO/pdf/laporan-tamu.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kedatangan Tamu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 3px;
            border-bottom-style: solid;
            border-bottom-color: #000;
        }

        .header h1,
        .header h3 {
            margin: 0;
        }

        .header h1 {
            font-size: 24px;
        }

        .header h3 {
            font-size: 16px;
            color: #2f2f2f;
        }

        .header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: right;
        }

        .school-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .school-info h4 {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SMK Negeri 11 Bandung</h1>
        <h3>Jl. Budhi Cilember No. 23, Bandung</h3>
        <h3>Laporan Kedatangan Tamu</h3>
        @if ($titleHeader)
            <p>{{ $titleHeader }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah Kedatangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->jumlah_kedatangan }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Kedatangan</strong></td>
                <td><strong>{{ $data->sum('jumlah_kedatangan') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
