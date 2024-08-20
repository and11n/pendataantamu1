@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div>
        <h4>Dashboard</h4>
    </div>
    <div>
        <h5>Kunjungan</h5>
        <div class="d-flex gap-5">
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 494.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Hari Ini</p>
                        <h4>{{ $countTamuHari }} Tamu</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 400.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Bulan Ini</p>
                        <h4>{{ $countTamuBulan }} Tamu</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 402.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Hari Ini</p>
                        <h4>{{ $countKurirHari }} Kurir</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 401.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Bulan Ini</p>
                        <h4>{{ $countKurirBulan }} Kurir</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h5>Grafik Tamu - Kurir</h5>
    <div class="" style="max-width: 50%">
        <canvas id="myChart"></canvas>
    </div>

@endsection
@section('style')
    <style>
        .mycard {
            width: 25%;
            border-radius: 30px;
            /* gap: 4rem; */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('script')
    <script>
        const ctx = document.getElementById("myChart").getContext('2d');
        // console.log(data);

        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels,
                datasets: [{
                        label: "Kurir",
                        data: data.kurir,
                        borderWidth: 1,
                    },
                    {
                        label: "Tamu",
                        data: data.tamu,
                        borderWidth: 1,
                    }
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
@endsection
