<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    @yield('style')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body>
    <nav style="border-bottom: 1px solid rgb(214, 214, 214); z-index: 10;"
        class="p-1 shadow-sm d-flex align-items-center justify-content-between w-full">
        <div class="d-flex align-items-center gap-4">
            <div style="margin-top: -13px; margin-left: 15px;"><img src="{{ asset('img/logo.jpg') }}" alt="logo"
                    style="height: 50px;"></div>
            <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" class="btn"><img
                    src="{{ asset('img/hamburger.png') }}" alt="menu" style="height: 17px;"></button>
        </div>
        <div class="d-flex gap-3 justify-content-center align-items-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrScanModal">
                <i class="bi bi-qr-code-scan" style="font-size: 1.2rem;"></i>
            </button>
            <div>
                <button style="background-color: #F5F7FA;" class="btn rounded-circle p-2">
                    <img src="{{ asset('img/setting.png') }}" alt="" style="height: 25px;">
                </button>
            </div>
            <div>
                <button style="background-color: #F5F7FA;" class="btn rounded-circle p-2">
                    <img src="{{ asset('img/notif.png') }}" alt="" style="height: 25px;">
                </button>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="font-size: 1rem;">
                        {{ Auth::user()->nama_user }}
                    </button>
                    <ul class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        {{-- <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li> --}}
                    </ul>
                </div>
            </div>
            <div style="margin-left: -10px;">
                <img src="{{ asset('img/user.png') }}" alt="" style="height: 32px;">
            </div>
        </div>

        <!-- Modal untuk Scan QR Code -->
        <div class="modal fade" id="qrScanModal" tabindex="-1" aria-labelledby="qrScanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrScanModalLabel">Scan QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="reader" style="width:100%; height: 400px;"></div>
                        <div id="result" style="margin-top: 10px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Tamu -->
        <div class="modal fade" id="tamuDetailModal" tabindex="-1" aria-labelledby="tamuDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tamuDetailModalLabel">Detail Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> <span id="modalTamuName"></span></p>
                        <p><strong>Email:</strong> <span id="modalTamuEmail"></span></p>
                        <p><strong>No Telepon:</strong> <span id="modalTamuPhone"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="takePhotoBtn">Ambil Foto</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Kamera -->
        <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="cameraSection">
                        <video id="video" autoplay style="width: 100%; height: auto;"></video>
                    </div>
                    <div class="modal-body text-center" id="previewSection" style="display: none;">
                        <img id="foto-preview" src="" alt="Foto Preview"
                            style="width: 100%; margin-top: 10px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="snap" class="btn btn-primary mt-2">Ambil Foto</button>
                        <button type="button" id="backToCamera" class="btn btn-secondary"
                            style="display: none;">Foto
                            Kembali</button>
                        <button type="button" id="save-photo" class="btn btn-primary"
                            style="display: none;">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" name="photo">

    </nav>


    <div style="background-color: #F5F7FA; width: 100%; min-height: 100vh;" class="d-flex flex-column gap-2 p-3">
        @yield('content')
    </div>
    <div style="margin-top: 54px; width: 200px;" class="offcanvas offcanvas-start" data-bs-scroll="true"
        data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div style="color: #B1B1B1; padding-left: 0px; padding-right: 0px;"
            class="offcanvas-body mt-4 ps-3 d-flex flex-column gap-2">
            <x-sidebar-item :href="route('frontoffice.dashboard')" :active="request()->routeIs('frontoffice.dashboard')" :img="asset('img/home.png')" :activeimg="asset('img/home-active.png')">
                Dashboard
            </x-sidebar-item>
            <x-sidebar-item :href="route('fo.pegawai')" :active="request()->routeIs('fo.pegawai')" :img="asset('img/pegawai.png')" :activeimg="asset('img/pegawai-active.png')">
                Pegawai
            </x-sidebar-item>
            <x-sidebar-item :href="route('frontoffice.kunjungan')" :active="request()->routeIs('frontoffice.kunjungan')" :img="asset('img/kunjungan.png')" :activeimg="asset('img/kunjungan-active.png')">
                Kunjungan
            </x-sidebar-item>
            <x-sidebar-item :href="route('frontoffice.laporan')" :active="request()->routeIs('frontoffice.laporan') || request()->routeIs('laporanKurir')" :img="asset('img/laporan.png')" :activeimg="asset('img/laporan-active.png')">
                Laporan
            </x-sidebar-item>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    {{-- <script>
        let html5QrcodeScanner = null;

        document.getElementById('qrScanModal').addEventListener('shown.bs.modal', function (e) {
            function onScanSuccess(decodedText, decodedResult) {
                alert('Kode QR terdeteksi: ' + decodedText);
                $('#qrScanModal').modal('hide'); // Menutup modal setelah scan berhasil
            }

            function onScanFailure(error) {
                console.warn(`Error scan kode = ${error}`);
            }

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { fps: 10, qrbox: {width: 250, height: 250} },
                /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        document.getElementById('qrScanModal').addEventListener('hidden.bs.modal', function (e) {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then((ignore) => {
                    console.log("Pemindaian kode QR dihentikan.");
                }).catch((err) => {
                    console.log("Gagal menghentikan pemindaian.");
                });
            }
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("reader");
            const qrScanModal = document.getElementById('qrScanModal');
            const tamuDetailModal = document.getElementById('tamuDetailModal');
            const cameraModal = document.getElementById('cameraModal');
            const takePhotoBtn = document.getElementById('takePhotoBtn');
            const snapBtn = document.getElementById('snap');
            const backToCameraBtn = document.getElementById('backToCamera');
            const savePhotoBtn = document.getElementById('save-photo');
            const video = document.getElementById('video');
            const fotoPreview = document.getElementById('foto-preview');
            let stream;

            qrScanModal.addEventListener('shown.bs.modal', function() {
                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                    console.log("Kode QR terdeteksi: " + decodedText);
                    html5QrCode.stop().then(() => {
                        console.log('QR Code scanning berhenti.');
                        const qrModalInstance = bootstrap.Modal.getInstance(qrScanModal);
                        qrModalInstance.hide();
                        processQRCode(decodedText);
                    }).catch((err) => {
                        console.error('Gagal menghentikan QR Code scanning:', err);
                    });
                };

                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                };

                html5QrCode.start({
                        facingMode: "environment"
                    }, config, qrCodeSuccessCallback)
                    .catch((err) => {
                        console.error('Error saat memulai QR Code scanning:', err);
                    });
            });

            qrScanModal.addEventListener('hidden.bs.modal', function() {
                html5QrCode.stop().catch(err => console.error('Gagal menghentikan QR Code scanning:', err));
            });

            function processQRCode(decodedText) {
                fetch(`/fo/get-tamu-detail/${decodedText}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('modalTamuName').innerText = data.name;
                            document.getElementById('modalTamuEmail').innerText = data.email;
                            document.getElementById('modalTamuPhone').innerText = data.phone;
                            document.getElementById('id').value = decodedText;
                            const tamuDetailModalInstance = new bootstrap.Modal(tamuDetailModal);
                            tamuDetailModalInstance.show();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching tamu details:', error);
                        alert('Terjadi kesalahan saat memproses QR code.');
                    });
            }

            takePhotoBtn.addEventListener('click', function() {
                bootstrap.Modal.getInstance(tamuDetailModal).hide();
                startCamera();
            });

            snapBtn.addEventListener('click', capturePhoto);
            backToCameraBtn.addEventListener('click', startCamera);
            savePhotoBtn.addEventListener('click', savePhotoAndUpdateArrival);

            function startCamera() {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(streamObj) {
                        stream = streamObj;
                        video.srcObject = stream;
                        document.getElementById('cameraSection').style.display = 'block';
                        document.getElementById('previewSection').style.display = 'none';
                        snapBtn.style.display = 'inline-block';
                        backToCameraBtn.style.display = 'none';
                        savePhotoBtn.style.display = 'none';
                        new bootstrap.Modal(cameraModal).show();
                    })
                    .catch(function(error) {
                        console.error("Error accessing the camera", error);
                        alert("Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin.");
                    });
            }

            function capturePhoto() {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                fotoPreview.src = canvas.toDataURL('image/jpeg');
                document.getElementById('cameraSection').style.display = 'none';
                document.getElementById('previewSection').style.display = 'block';
                snapBtn.style.display = 'none';
                backToCameraBtn.style.display = 'inline-block';
                savePhotoBtn.style.display = 'inline-block';
            }

            function savePhotoAndUpdateArrival() {
                const photoPreview = document.getElementById('foto-preview');
                const photoData = photoPreview.src; // Make sure the photoPreview element exists and has src
                const idTamu = document.getElementById('id').value; // Fetch the id from hidden input field

                if (!photoData || !idTamu) {
                    alert('Photo or ID missing!');
                    return;
                }

                console.log('Sending data:', {
                    photo: photoData,
                    id: idTamu
                });

                fetch("{{ route('update-kedatangan') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            photo: photoData, // Send the photo data (base64 encoded image)
                            id: idTamu // Send the id
                        })
                    })
                    // .then(response => {
                    //     if (!response.ok) {
                    //         return response.text().then(text => {
                    //             throw new Error('Server response: ' + text);
                    //         });
                    //     }
                    //     return response.json();
                    // })
                    // .then(data => {
                    //     // Handle success response
                    //     console.log('Success:', data);
                    //     alert('Photo saved successfully!');
                    // })
                    // .catch(error => {
                    //     console.error('Error:', error);
                    //     alert('Terjadi kesalahan: ' + error.message);
                    // });
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Foto berhasil disimpan dan waktu kedatangan diperbarui');
                            bootstrap.Modal.getInstance(cameraModal).hide();
                        } else {
                            alert('Gagal menyimpan foto dan memperbarui waktu kedatangan: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan foto dan memperbarui waktu kedatangan: ' + error
                            .message);
                    });
            }

            function dataURItoBlob(dataURI) {
                const byteString = atob(dataURI.split(',')[1]);
                const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                const ab = new ArrayBuffer(byteString.length);
                const ia = new Uint8Array(ab);
                for (let i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                return new Blob([ab], {
                    type: mimeString
                });
            }

            cameraModal.addEventListener('hidden.bs.modal', function() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });
        });
    </script>
    @yield('script')
</body>

</html>
