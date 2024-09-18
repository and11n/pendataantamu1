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
                        <p style="color:#718EBF">Total</p>
                        <h4>{{ $countTamuHari }} Tamu</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 402.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Total</p>
                        <h4>{{ $countKurirHari }} Kurir</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 400.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Total Guru</p>
                        <h4>{{ $countGuru }}</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex mycard bg-white shadow p-3 px-4">
                <div class="align-self-start">
                    <img src="{{ asset('img/Group 400.png') }}" alt="">
                </div>
                <div style="width: 100%" class="d-flex flex-column align-items-center">
                    <div>
                        <p style="color:#718EBF">Total</p>
                        {{-- <h4>{{ $countKurirBulan }} Tendik</h4> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h5>Grafik Tamu - Kurir (Bulanan)</h5>
    <div class="card" style=" display: flex; justify-content: center; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);">
        <canvas id="myChart" style="height: 400px;"></canvas>
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
        // Mengambil data dari variabel PHP ke JavaScript
        const data = @json($chartData);

        const ctx = document.getElementById("myChart").getContext('2d');

        // Membuat grafik menggunakan Chart.js
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels, // Label untuk sumbu x (bulan)
                datasets: [
                    {
                        label: "Kurir",
                        data: data.kurir, // Data kurir per bulan
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: "Tamu",
                        data: data.tamu, // Data tamu per bulan
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
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

