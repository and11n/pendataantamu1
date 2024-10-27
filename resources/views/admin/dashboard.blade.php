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
                        <p style="color:#718EBF">Total Bulan Ini</p>
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
                        <p style="color:#718EBF">Total Bulan Ini</p>
                        <h4>{{ $countKurirBulan }} Kurir</h4>
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
                        <h4>{{ $countGuru }} Guru</h4>
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
                        <h4>3 Tendik</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="dashboard-container">
        <div class="chart-container">
            <div class="d-flex justify-content-end mb-3">
                <h5 class="text-center flex-grow-1">Grafik Tamu - Kurir</h5>
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <select class="form-select form-select-sm" name="bulan" aria-label="Pilih Bulan" onchange="this.form.submit()" style="width: 150px;">
                        <option value="all" {{ request('bulan') == 'all' ? 'selected' : '' }}>Pilih Bulan</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <canvas id="myChart" style="height: 400px;"></canvas>
        </div>
        <div class="accordion-container">
            <div class="accordion" id="accordionPricing">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tamu yang akan datang hari ini
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionPricing">
                        <div class="accordion-body">
                           @if ($tamuDatang->isEmpty())
                           <p><b>Tidak ada tamu yang akan datang</b></p >
                           @else
                           @foreach ($tamuDatang as $td)
                           <div class="card shadow-sm">
                            <div class="card-header py-2 px-3 small text-muted">
                              {{$td->waktu_perjanjian}}
                            </div>
                            <div class="card-body p-3">
                              <div class="mb-1 fw-semibold">{{$td->tamu->nama}}</div>
                              <div class="small text-muted">{{$td->pegawai->user->nama_user}}</div>
                              <div class="small text-secondary">{{ $td->status }}</div>
                            </div>
                          </div>
                           @endforeach
                           @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Tamu yang menunggu konfirmasi hari ini
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionPricing">
                        <div class="accordion-body">
                           @if ($tamuMenunggu->isEmpty())
                           <p><b>Tidak ada tamu yang menunggu konfirmasi</b></p>
                           @else
                           @foreach ($tamuMenunggu as $tm)
                           <div class="card shadow-sm">
                            <div class="card-header py-2 px-3 small text-muted">
                              {{$tm->waktu_perjanjian}}
                            </div>
                            <div class="card-body p-3">
                              <div class="mb-1 fw-semibold">{{$tm->tamu->nama}}</div>
                              <div class="small text-muted">{{$tm->pegawai->user->nama_user}}</div>
                              <div class="small text-secondary">{{ $tm->status }}</div>
                            </div>
                           </div>
                           @endforeach
                           @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Tamu yang ditolak
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionPricing">
                        <div class="accordion-body">
                           @if ($tamuDitolak->isEmpty())
                           <p><b>Tidak ada tamu yang Ditolak</b></p>
                           @else
                           @foreach ($tamuDitolak as $tt)
                           <div class="card shadow-sm">
                            <div class="card-header py-2 px-3 small text-muted">
                                {{$tt->waktu_perjanjian}}
                            </div>
                            <div class="card-body p-3">
                                <div class="mb-1 fw-semibold">{{$tt->tamu->nama}}</div>
                                <div class="small text-muted">{{$tt->pegawai->user->nama_user}}</div>
                                <div class="small text-secondary">{{ $tt->status }}</div>
                            </div>
                          </div>
                           @endforeach
                           @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Daftar kurir terbaru perhari ini
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionPricing">
                        <div class="accordion-body">
                            @if ($kurirHari->isEmpty())
                            <p><b>Tidak ada tamu yang Ditolak</b></p>
                            @else
                            @foreach ($kurirHari as $kurir)
                            <div class="card shadow-sm">
                             <div class="card-header py-2 px-3 small text-muted">
                                 {{$kurir->tanggal_waktu}}
                             </div>
                             <div class="card-body p-3">
                                 <div class="mb-1 fw-semibold">{{$kurir->ekspedisi->nama_kurir}}</div>
                                 <div class="small text-muted">{{$kurir->pegawai->user->nama_user}}</div>
                                 {{-- <div class="small text-secondary">{{ $kurir->ekspedisi->foto }}</div> --}}
                             </div>
                           </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
<style>
    .mycard {
            width: 25%;
            border-radius: 30px;
            /* gap: 4rem; */
        }
    .dashboard-container {
        display: flex;
        justify-content: space-between; /* Memastikan elemen diatur dengan jarak yang tepat */
        align-items: flex-start; /* Mengatur agar konten berada di atas */
        width: 100%; /* Mengatur lebar penuh */
        margin-top: 20px; /* Menambahkan jarak atas */
    }
    .chart-container {
        width: 60%; /* Mengatur lebar grafik menjadi setengah dari dashboard */
        border-radius: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        padding: 20px; /* Menambahkan padding untuk estetika */
    }
    .accordion-container {
        width: 38%; /* Mengatur lebar accordion menjadi sedikit lebih kecil dari setengah */
        border-radius: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        padding: 20px; /* Menambahkan padding untuk estetika */
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
                x: {
                ticks: {
                    autoSkip: false, // Ensure all labels (dates) are shown
                }
            },
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
</script>
@endsection
