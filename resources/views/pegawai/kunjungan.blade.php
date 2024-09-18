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
        <div class="bg-white p-3 shadow" style="border-radius: 25px">
            <h5>Data Tamu</h5>
            <div>
                <canvas id="ola"></canvas>
            </div>
        </div>
    </div>
    <div class="mt-5 bg-white p-4 shadow d-flex flex-column gap-2" style="border-radius: 20px">
        <div class="d-flex gap-2 my-3">
            <div class="d-flex bg-white p-3 shadow" style="border-radius: 15px;border:1px solid rgb(220, 225, 255)">
                <img width="24" height="24" src="{{ asset('img/akar-icons_search.png') }}" alt="search">
                <input oninput="search()" class="bg-white" style="border: none;" type="text" name="search"
                    id="search_2">
                <img width="24" height="24" src="{{ asset('img/uil_calender.png') }}" alt="calendar">
            </div>
            <select class="form-select" onchange="search()" name="status" id="status">
                <option value="menunggu">Menunggu</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
                <option value="tidakDatang">Tidak Datang</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div id="myTable">
            {{-- <div class="d-flex justify-content-center">
                {{ $datas->links('pagination::bootstrap-5') }}
            </div> --}}
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Pegawai</th>
                        <th>Waktu Perjanjian</th>
                        <th>Waktu Kedatangan</th>
                        <th colspan="2">status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawaiKunjungan as $dat)
                        <tr>
                            <td>{{ $dat->nama }}</td>
                            <td>{{ $dat->user->nama_user }}</td>
                            <td>{{ $dat->waktu_perjanjian }}</td>
                            <td>{{ $dat->waktu_kedatangan == null ? '-' : $dat->waktu_kedatangan }}</td>

                            @if ($dat->status == 'menunggu')
                                <td>
                                    <a href="{{ route('terimaTamu', $dat->id) }}">
                                        <button class="btn btn-success">Terima</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('tolakTamu', $dat->id) }}">
                                        <button class="btn btn-danger">Tolak</button>
                                    </a>
                                </td>
                            @elseif ($dat->status == 'diterima')
                                <td>
                                    <a href="{{ route('tambahKedatanganTamu', $dat->id) }}">
                                        <button class="btn btn-primary">Tambahkan Waktu Kedatangan</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('tamuGagal', $dat->id) }}">
                                        <button class="btn btn-danger">Tamu Tidak Datang</button>
                                    </a>
                                </td>
                            @elseif ($dat->status == 'selesai')
                                <td class="text-success" colspan="2">
                                    Selesai
                                </td>
                            @elseif ($dat->status == 'ditolak')
                                <td class="text-danger" colspan="2">
                                    Ditolak
                                </td>
                            @elseif ($dat->status == 'tidakDatang')
                                <td class="text-danger" colspan="2">
                                    Tidak Datang
                                </td>
                            @endif

                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" data-bs-toggle="modal" data-bs-target="#detail{{ $dat->id }}Modal" class="btn">
                                    <img src="{{ asset('img/detail.png') }}" alt="detail">
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="detail{{ $dat->id }}Modal" tabindex="-1" aria-labelledby="detail{{ $dat->id }}Modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="detail{{ $dat->id }}Label">Detail</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Nama Tamu : {{ $dat->nama }}<br>
                                                Bertemu Dengan : {{ $dat->pegawai->nama }}<br>
                                                Waktu Pertemuan : {{ $dat->waktu_kedatangan }}<br>
                                                <form id="formKeterangan{{ $dat->id }}" action="{{ route('ubahKeteranganTamu') }}" method="post">
                                                    @csrf
                                                    Keterangan :
                                                    <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control">{{ $dat->keterangan }}</textarea>
                                                    <input type="hidden" name="id" value="{{ $dat->id }}">
                                                </form>
                                                @if ($dat->foto != null)
                                                    <img src="{{ asset('img/tamu/' . $dat->foto) }}" alt="foto">
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" onclick="document.getElementById('formKeterangan{{ $dat->id }}').submit()" class="btn btn-primary">Simpan Keterangan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
            {{-- <div class="d-flex justify-content-center">
                {{ $dat->links('pagination::bootstrap-5') }}
            </div> --}}
        </div>
    </div>
     {{-- const data = @json($chartData) --}}

@endsection
@section('style')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    @endsection

    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('ola').getContext('2d');

                // Mengirim data dari Laravel ke JavaScript
                const data = {
                    diterima: @json($diterima),
                    ditolak: @json($ditolak),
                    menunggu: @json($menunggu),
                    diterimaPersen: @json($diterimaPersen),
                    ditolakPersen: @json($ditolakPersen),
                    menungguPersen: @json($menungguPersen)
                };

                // Inisialisasi Chart.js
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: [
                            `Diterima : ${data.diterima} Orang`,
                            `Ditolak : ${data.ditolak} Orang`,
                            `Menunggu : ${data.menunggu} Orang`
                        ],
                        datasets: [{
                            label: 'Persentase',
                            data: [data.diterimaPersen, data.ditolakPersen, data.menungguPersen],
                            backgroundColor: ['#36a2eb', '#ff6384', '#ffce56']
                        }],
                    },
                    options: {
                        plugins: {
                            datalabels: {
                                formatter: function(value, context) {
                                    return value + '%';
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
