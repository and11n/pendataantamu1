@extends('layouts.user')

@section('content')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
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
        <form action="{{ route('tambahkedKurir') }}" method="POST"
            class="d-flex flex-column gap-4 w-full bg-white p-5 shadow" style="border-radius: 20px">
            @csrf
            <div class="d-flex gap-4">
                <div class="w-50 d-flex flex-column gap-4">
                    <div class="form-group">
                        <input required type="text" class="form-control" style="text-decoration: none; color:#666666;" id="nama_kurir" name="nama_kurir"
                            placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                        <select required class="form-select" style="text-decoration: none; color:#666666;" name="ekspedisi" aria-label="Ekspedisi">
                            <option selected disabled>Pilih Ekspedisi</option>
                            <option value="jne">JNE</option>
                            <option value="jnt">JNT</option>
                            <option value="anterAja">AnterAja</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required class="form-select" style="text-decoration: none; color:#666666;" name="id_pegawai" aria-label="Pegawai">
                            <option value="">Pilih Pegawai</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->nip }}">{{ $p->user->nama_user }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input required type="number" class="form-control" style="text-decoration: none; color:#666666;" id="no_telp" name="no_telp"
                            placeholder="Masukkan No HP">
                    </div>
                    <div class="form-group">
                        <input required type="date" class="form-control" style="text-decoration: none; color:#666666;" id="tanggal_waktu" name="tanggal_waktu">
                    </div>
                    {{-- <div class="form-group"> --}}
                        <button type="button" class="form-control" style="text-decoration: none; color:#666666; text-align:left" data-bs-toggle ="modal" data-bs-target="#exampleModal">Buka Kamera</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Silahkan Foto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Apply CSS to flip the video element -->
                                        <video id="video" class="w-100 rounded-lg" width="320" height="240" autoplay style="transform: scaleX(-1);"></video>
                                        <canvas id="canvas" width="320" height="240" style="display: none"></canvas>
                                        <img class="rounded-lg" id="foto-preview" src="" alt="Foto Preview" style="display: none" />
                                        <div class="d-flex justify-content-center mt-2">
                                            <button type="button" id="snap" class="btn btn-primary">
                                                <img src="{{ asset('img/camera-solid1.svg') }}" alt="Kurir Icon" style="width: 50px; height: 50px;">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                                        <button type="button" id="save" class="btn btn-primary" style="display: none">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="foto-data" name="foto">

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const video = document.getElementById('video');
                                const canvas = document.getElementById('canvas');
                                const snapButton = document.getElementById('snap');
                                const saveButton = document.getElementById('save');
                                const closeButton = document.getElementById('close');
                                const fotoPreview = document.getElementById('foto-preview');
                                const fotoLabel = document.getElementById('foto-label');
                                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                                let stream;
                                let fotoTaken = false;

                                function startCamera() {
                                    navigator.mediaDevices.getUserMedia({ video: true })
                                        .then(function(s) {
                                            stream = s;
                                            video.srcObject = stream;
                                            video.play();
                                        })
                                        .catch(function(err) {
                                            console.log("An error occurred: " + err);
                                        });
                                }

                                function stopCamera() {
                                    if (stream) {
                                        stream.getTracks().forEach(function(track) {
                                            track.stop();
                                        });
                                    }
                                }

                                document.getElementById('exampleModal').addEventListener('show.bs.modal', function(e) {
                                    if (fotoTaken) {
                                        video.style.display = 'none';
                                        fotoPreview.style.display = 'block';
                                        snapButton.style.display = 'none';
                                        saveButton.style.display = 'inline-block';
                                    } else {
                                        video.style.display = 'block';
                                        fotoPreview.style.display = 'none';
                                        snapButton.style.display = 'inline-block';
                                        saveButton.style.display = 'none';
                                        startCamera();
                                    }
                                });

                                document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function(e) {
                                    stopCamera();
                                });

                                snapButton.addEventListener('click', function() {
                                    const context = canvas.getContext('2d');

                                    // Flip the canvas horizontally before drawing the video frame
                                    context.save();
                                    context.scale(-1, 1); // Flip horizontally
                                    context.drawImage(video, -canvas.width, 0, canvas.width, canvas.height);
                                    context.restore();

                                    const dataURL = canvas.toDataURL('image/jpeg');
                                    fotoPreview.src = dataURL;
                                    fotoPreview.style.display = 'block';
                                    video.style.display = 'none';
                                    snapButton.style.display = 'none';
                                    saveButton.style.display = 'inline-block';
                                    fotoTaken = true;

                                    // Hide the label when the photo is taken
                                    fotoLabel.style.display = 'none';

                                    stopCamera();
                                });

                                saveButton.addEventListener('click', function() {
                                    document.getElementById('foto-data').value = fotoPreview.src;
                                    modal.hide();
                                });

                                closeButton.addEventListener('click', function() {
                                    fotoTaken = false;
                                    fotoPreview.src = '';
                                    video.style.display = 'block';
                                    fotoPreview.style.display = 'none';
                                    snapButton.style.display = 'inline-block';
                                    saveButton.style.display = 'none';
                                });
                            });
                        </script>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-warning" style="border-radius: 9px;">Kirim</button>
            </div>

            {{-- </div> --}}
            </div>
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
@endsection
