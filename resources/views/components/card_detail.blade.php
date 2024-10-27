@php
    $statusColors = [
        'diterima' => 'outline-green-400',
        'ditolak' => 'outline-red-400',
        'menunggu' => 'outline-orange-400',
    ];
@endphp
<div class="w-full flex flex-col col-span-3 gap-6 rounded-4.5">
    <div class="flex items-center justify-center w-full avatar">
        <div
            class="rounded-full flex items-center justify-center w-25 h-25 outline outline-4 {{ $statusColors[$item->status] ?? 'outline-green-400' }}">
            <img src="{{ asset('assets/user.jpg') }}" class="h-full rounded-full" alt="">
        </div>
    </div>
    <div class="flex justify-around w-full gap-2">
        <div class="flex flex-col items-center justify-center w-full gap-2">
            @if ($item->tamu)
                <h6 class="text-sm font-semibold leading-0 text-grey">Nama Tamu</h6>
            @else
                <h6 class="text-sm font-semibold leading-0 text-grey">Nama Kurir</h6>
            @endif
            <h6 class="text-base text-darkGray">{{ $item->tamu->nama ?? $item->ekspedisi->nama_kurir }}</h6>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-2">
            <h6 class="text-sm font-semibold leading-0 text-grey">Bertemu Dengan</h6>
            <h6 class="text-base text-darkGray">{{ $item->user->nama }}</h6>
        </div>
        @if ($item->tamu)
            <div class="flex flex-col items-center justify-center w-full gap-2">
                <h6 class="text-sm font-semibold leading-0 text-grey">Waktu Pertemuan</h6>
                <h6 class="text-sm text-darkGray">{{ $item->formatWaktu }}</h6>
            </div>
        @endif
    </div>
    <div class="w-full px-4">
        <h2 class="px-2 mb-2 text-lg font-semibold leading-4">Detail Lainnya</h2>
        <div class="bg-lightRed p-4 rounded-4.5 ">
            {{-- @if ($item->ekspedisi)
                <div class="flex mb-2">
                    <span class="w-1/6 font-semibold">Waktu Kedatangan</span>
                    <span class="w-5/6">: {{ $item->formatWaktu }}</span>
                </div>
            @endif --}}
            <div class="flex mb-2">
                @if ($item->tamu)
                    <span class="w-1/6 font-semibold">Email</span>
                @else
                    <span class="w-1/6 font-semibold">Ekspedisi</span>
                @endif
                <span class="w-5/6">: {{ $item->tamu->email ?? $item->ekspedisi->ekspedisi }}</span>
            </div>
            <div class="flex mb-2">
                <span class="w-1/6 font-semibold">No. Telpon</span>
                <span class="w-5/6">: {{ $item->tamu->no_telpon ?? $item->ekspedisi->no_telpon }}</span>
            </div>
            @if ($item->tamu)
                <div class="flex mb-2">
                    <span class="w-1/6 font-semibold">Alamat</span>
                    <span class="w-5/6">: {{ $item->tamu->alamat ?? '-' }}</span>
                </div>
                <div class="flex mb-2">
                    <span class="w-1/6 font-semibold">Instansi</span>
                    <span class="w-5/6">: {{ $item->instansi ?? '-' }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-semibold">Tujuan</span>
                    <div class="w-full h-24 px-3 py-2 overflow-auto rounded-lg bg-lightRed2">
                        {{ $item->tujuan ?? 'N/A' }}
                    </div>
                </div>
            @endif
        </div>
        <div class="flex w-full gap-4 my-4">
            <!-- Tombol Diterima -->
            @if ($item->tamu)
                @if ($item->status == 'menunggu')
                    <div class="w-1/2">
                        <form action="{{ route('status.update') }}" method="POST"
                            onsubmit="return handleFormSubmit(this, 'ditolak');">
                            @csrf
                            {{-- <input type="hidden" name="id_kedatangan" value="{{ $item->id_kedatangan }}"> --}}
                            <button type="submit"
                                class="w-full border-2 btn hover:text-light bg-lightRed border-primaryRed hover:border-primaryRed hover:bg-secondaryRed text-primaryRed btn-lg">
                                Ditolak
                            </button>
                        </form>
                    </div>

                    <div class="w-1/2">
                        <form action="{{ route('status.update') }}" method="POST"
                            onsubmit="return handleFormSubmit(this, 'diterima');">
                            @csrf
                            <input type="hidden" name="id_kedatangan" value="{{ $item->id_kedatangan }}">
                            <input type="hidden" name="status" value="diterima">
                            <button type="submit"
                                class="w-full btn bg-primaryRed hover:bg-secondaryRed text-light btn-lg">
                                Diterima
                            </button>
                        </form>
                    </div>
                @endif
            @endif

        </div>

    </div>
</div>
<div id="alasanModal" class="fixed inset-0 z-10 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="p-6 bg-white rounded shadow-lg">
            <h2 class="mb-4 text-lg font-bold">Alasan Penolakan</h2>
            <form id="formSubmit" action="{{ route('status.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kedatangan" value="{{ $item->id_kedatangan }}">
                <input type="hidden" name="status" value="ditolak">
                <textarea name="alasan" class="w-full p-2 mb-4 border"></textarea>
                <button type="submit" class="btn bg-primaryRed text-light">Kirim</button>
            </form>
        </div>
    </div>
</div>

<script>
    function handleFormSubmit(form, status) {
        if (status === 'ditolak') {
            // Tampilkan modal untuk memberikan alasan penolakan
            document.getElementById('alasanModal').classList.remove('hidden');
            document.getElementById('formSubmit').onsubmit = function() {
                form.submit();
            };
            return false; // Mencegah submit form secara langsung
        }

        // if (status === 'diterima') {
        //     // Handle pengiriman QR code
        //     fetch(form.action, {
        //         method: form.method,
        //         body: new FormData(form),
        //         headers: {
        //             'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        //             'Accept': 'application/json',
        //         }
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             const qrCodeImg = document.createElement('img');
        //             qrCodeImg.src = 'data:image/png;base64,' + data.qr_code;
        //             qrCodeImg.alt = 'QR Code';
        //             qrCodeImg.style.width = '100%';

        //             const qrCodeContent = document.getElementById('qrCodeContent');
        //             qrCodeContent.innerHTML = '';
        //             qrCodeContent.appendChild(qrCodeImg);

        //             const downloadBtn = document.getElementById('downloadBtn');
        //             downloadBtn.href = qrCodeImg.src;
        //             downloadBtn.download = 'qr_code.png';

        //             document.getElementById('qrCodeModal').classList.remove('hidden');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('Terjadi kesalahan dalam mengirim data. Silakan coba lagi.', error);
        //     });
        //     return false; // Mencegah submit form secara langsung
        // }

        return true; // Submit form secara normal
    }
</script>
