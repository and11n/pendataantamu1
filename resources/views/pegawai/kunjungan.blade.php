@extends('layouts.pegawai')
@section('title', 'Kunjungan')
@section('content')
    <div class="d-flex gap-4">
        <div style="width: 85%" class="d-flex flex-column justify-content-between">
            {{-- <div>
                <h4>Home/Kunjungan</h4>
                <h6>Kunjungan</h6>
            </div> --}}

            <div class="d-flex gap-4">
                <!-- Box untuk status 'Belum Datang' -->
                <div style="width: 33%; border-radius: 20px"
                    class="bg-white d-flex justify-content-center align-items-center gap-3 p-3 py-5 shadow">
                    <div>
                        <img style="height: fit-content" src="{{ asset('img/belum datang.png') }}" alt="belum datang">
                    </div>
                    <div>
                        <div>{{ $tamuBelumDatang ?? '0' }} orang</div>
                        <h6>Belum Datang</h6>
                    </div>
                </div>

                <!-- Box untuk status 'Selesai' -->
                <div style="width: 33%; border-radius: 20px"
                    class="bg-white d-flex justify-content-center align-items-center gap-3 p-3 py-5 shadow">
                    <div>
                        <img style="height: fit-content" src="{{ asset('img/selesai.png') }}" alt="selesai">
                    </div>
                    <div>
                        <div>{{ $tamuSelesai ?? '0' }} orang</div>
                        <h6>Selesai</h6>
                    </div>
                </div>

                <!-- Box untuk status 'Tidak Hadir' -->
                <div style="width: 33%; border-radius: 20px"
                    class="bg-white d-flex justify-content-center align-items-center gap-3 p-3 py-5 shadow">
                    <div>
                        <img style="height: fit-content" src="{{ asset('img/tidak hadir.png') }}" alt="tidak hadir">
                    </div>
                    <div>
                        <div>{{ $tamuGagal ?? '0' }} orang</div>
                        <h6>Tidak Hadir</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-3 shadow" style="border-radius: 25px; width: 300px; height: 300px;">
            <h5>Data Tamu</h5>
            <canvas id="ola"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card h-80 w-12" style="overflow-y: auto; max-height: 500px;">
                <div class="card-body">
                    <form action="{{ route('pegawai.kunjungan') }}" method="GET" id="searchForm" style="position: sticky; top: 0; background-color: white; z-index: 100; padding-bottom: 10px;">
                        <h5 class="card-title">Kunjungan Diterima</h5>
                        <select class="form-select" name="status" id="status" onchange="document.getElementById('searchForm').submit()">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Sudah Datang</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Belum Datang</option>
                        </select>
                        <input type="text" name="search" class="form-control mb-3" placeholder="Cari Nama Pengunjung" id="searchInput">
                    </form>                    
                    @forelse ($listKunjungan as $kedatangan)
                        @if ($kedatangan->status != 'menunggu' && $kedatangan->tamu)
                            <div class="mb-3">
                                <h6>Kedatangan Tamu</h6>
                                <p>
                                    <strong>Nama Pengunjung:</strong>
                                    {{ $kedatangan->tamu->nama }}
                                    <br>
                                    <strong>Pegawai yang Dikunjungi:</strong>
                                    {{ $kedatangan->pegawai->user->nama_user }}<br>
                                    <strong>Waktu Kedatangan:</strong>
                                    {{ $kedatangan->waktu_perjanjian }}
                                </p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $kedatangan->id }}">
                                    Detail
                                </button>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endif
                    @empty
                        <p class="text-center">Tidak ada kunjungan yang ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card h-80 w-12" style="overflow-y: auto; max-height: 500px;">
                <div class="card-body">
                    <form action="{{ route('pegawai.kunjungan') }}" method="GET" style="position: sticky; top: 0; background-color: white; z-index: 100; padding-bottom: 10px;">
                        <h5 class="card-title">Aktivitas Kunjungan</h5>
                    </form>
                    @forelse ($listKunjungan as $kedatangan)
                        @if ($kedatangan->status === 'menunggu' && $kedatangan->tamu)
                            <div class="mb-3">
                                <h5 class="card-title">Kedatangan Tamu</h5>
                                <p class="card-text">
                                    <strong>Nama Pengunjung:</strong>
                                    {{ $kedatangan->tamu->nama }}<br>
                                    <strong>Pegawai yang Dikunjungi:</strong>
                                    {{ $kedatangan->pegawai->user->nama_user }}<br>
                                    <strong>Waktu Kedatangan:</strong>
                                    {{ $kedatangan->waktu_perjanjian }}
                                </p>
                                <form action="{{ route('update.status') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $kedatangan->id }}">
                                    <button type="submit" name="status" value="diterima" class="btn btn-warning">Terima</button>
                                </form>
    
                                <form action="{{ route('update.status') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $kedatangan->id }}">
                                    <button type="button" class="btn btn-danger" onclick="toggleAlasanField(this)">Tolak</button>
                                    <div class="alasanField" style="display: none;">
                                        <input type="hidden" name="status" value="ditolak">
                                        <label for="alasan">Alasan Penolakan:</label>
                                        <textarea name="alasan" class="form-control" required></textarea>
                                        <button type="submit" class="btn btn-info">Kirim Alasan</button>
                                    </div>
                                </form>
    
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $kedatangan->id }}">
                                    Detail
                                </button>
                                <div class="modal fade" id="detailModal{{ $kedatangan->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $kedatangan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $kedatangan->id }}">Detail Kedatangan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nama:</strong> {{ $kedatangan->nama }}</p>
                                                <p><strong>Tanggal:</strong> {{ $kedatangan->tanggal }}</p>
                                                <p><strong>Jenis:</strong> Tamu</p>
                                                <p><strong>ID:</strong> {{ $kedatangan->id }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endif
                    @empty
                        <p class="text-center">Tidak ada kunjungan yang ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    

@endsection
@section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ola').getContext('2d');

        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent default form submission
                const form = document.getElementById('searchForm');
                form.submit(); // Submit the form
            }
        });

        function toggleAlasanField(button) {
        const alasanField = button.closest('form').querySelector('.alasanField');
        alasanField.style.display = (alasanField.style.display === 'none') ? 'block' : 'none';
    }

        const data = {
            diterima: {{ $diterima ?? 0 }},
            ditolak: {{ $ditolak ?? 0 }},
            menunggu: {{ $menunggu ?? 0 }},
            diterimaPersen: {{ $diterimaPersen ?? 0 }},
            ditolakPersen: {{ $ditolakPersen ?? 0 }},
            menungguPersen: {{ $menungguPersen ?? 0 }}
        };

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    `Diterima: ${data.diterima} Orang`,
                    `Ditolak: ${data.ditolak} Orang`,
                    `Menunggu: ${data.menunggu} Orang`
                ],
                datasets: [{
                    label: 'Persentase',
                    data: [data.diterimaPersen, data.ditolakPersen, data.menungguPersen],
                    backgroundColor: ['#36a2eb', '#ff6384', '#ffce56'],
                    hoverOffset: 10
                }],
            },
            options: {
            responsive: true,
            maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,  // Ukuran kotak warna
                            padding: 15,   // Jarak antara kotak dan teks
                            font: {
                                size: 14   // Ukuran font teks legenda
                            }
                        }
                    },
                    datalabels: {
                        color: 'white',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: function(value, context) {
                            return Math.round(value) + '%'; // Menampilkan persentase
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>

    <script src="{{ asset('js/kunjungan.js') }}"></script>
@endsection
