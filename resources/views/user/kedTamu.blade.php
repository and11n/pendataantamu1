@extends('layouts.user')

@section('content')
    <div class="form1">
        <link href="{{ asset('css/user.css') }}" rel="stylesheet" />
        <section class="icons-section">
            <div class="icon">
                <a href="{{ route('kedTamu') }}" style="text-decoration: none;">
                    <img src="{{ asset('img/tamu.svg') }}" alt="Tamu Icon">
                    <p style="text-decoration: none;">TAMU</p>
                </a>
            </div>
            <div class="icon">
                <a href="{{ route('kedKurir') }}" style="text-decoration: none;">
                    <img src="{{ asset('img/kurir.svg') }}" alt="Kurir Icon">
                    <p style="text-decoration: none;">KURIR</p>
                </a>
            </div>
        </section>

        <section class="form-section">
            <form action="{{ route('tambahkedTamu') }}" method="POST" class="d-flex flex-column gap-4 w-full p-5 shadow z-3"
                style="border-radius: 20px">
                <img src="{{ asset('img/sekolah2.png') }}" class="sekolah2" alt="">


                @csrf
                <div class="d-flex gap-4">
                    <div class="w-50 d-flex flex-column gap-4">
                        <div class="form-group">
                            <input required type="text" class="form-control" style="text-decoration: none; color:#666666;" id="nama" name="nama"
                                placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" style="text-decoration: none; color:#666666;" id="alamat" name="alamat"
                                placeholder="Masukkan Alamat">
                        </div>
                        <div class="form-group">
                            <select required class="form-select" style="text-decoration: none; color:#666666;" name="id_pegawai" aria-label="Pegawai">
                                <option selected disabled>Pilih Pegawai</option>
                                @foreach ($pegawai as $p)
                                <option value="{{ $p->nip }}">{{ $p->user->nama_user }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" style="text-decoration: none; color:#666666;" id="tujuan" name="tujuan"
                                placeholder="Masukkan Tujuan">
                        </div>
                    </div>
                    <div class="w-50 d-flex flex-column gap-4">
                        <div class="form-group">
                            <input required type="email" class="form-control" style="text-decoration: none; color:#666666;" id="email" name="email"
                                placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <input required type="number" class="form-control" style="text-decoration: none; color:#666666;" id="no_telp" name="no_telp"
                                placeholder="Masukkan No HP">
                        </div>
                        <div class="form-group">
                            <input required type="date" class="form-control" style="text-decoration: none; color:#666666;" id="waktu_perjanjian" name="waktu_perjanjian">
                        </div>
                        <div class="form-group">
                            <input required type="text" class="form-control" style="text-decoration: none; color:#666666;" id="instansi" name="instansi"
                                placeholder="Masukkan Instansi">
                        </div>
                    </div>
                </div>
                <div class="w-full d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary me-4" style="border-radius: 9px;">Batal</button>
                    <button type="submit" class="btn btn-warning" style="border-radius: 9px;">Kirim</button>
                </div>
            </form>
        </section>
        <footer class="footer mt-auto py-3 bs-primary-bg-subtle">
            {{-- <div class="container text-center">
            <div class="footer-links">
                <a href="#" class="text-muted mx-2">Privacy Policy</a>
                <a href="#" class="text-muted mx-2">Terms of Service</a>
                <a href="#" class="text-muted mx-2">Contact</a>
            </div>
        </div> --}}
        </footer>
    </div>
@endsection
