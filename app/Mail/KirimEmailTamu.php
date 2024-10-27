<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Storage;

class KirimEmailTamu extends Mailable
{
    use Queueable, SerializesModels;
    public $kedatangan;
    public $status;
    public $tamu;
    public $qrCodePath;

    public function __construct($kedatangan, $tamu)
    {
        $this->kedatangan = $kedatangan;
        $this->status = $kedatangan->status;
        $this->tamu = $tamu;
        $this->qrCodePath = 'qrcodes/' . $kedatangan->id_kedatangan . '.png';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Buku Tamu SMKN 11 Bandung',
            to: [new Address($this->tamu->email, $this->tamu->nama)]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pegawai.email.kirimEmailTamu',
        );
    }

    public function build()
    {
        $subject = '';
        if ($this->status == 'Diterima') {
            $subject = 'Selamat permintaan pertemuan anda Diterima';
        } elseif ($this->status == 'Ditolak') {
            $subject = 'Mohon maaf, permintaan pertemuan anda Ditolak';
        }

        return $this->view('pegawai.email.kirimEmailTamu')
                    ->subject($subject)
                    // ->body('Kunjungan Diterima')
                    ->attachData(
                        base64_decode($this->kedatangan->qr_code),
                        'qr_code.png',
                        ['mime' => 'image/png']
                    )
                    ->with([
                        'kedatangan' => $this->kedatangan,
                        'qrCodePath' => $this->qrCodePath,
                        'emailSubject' => $subject,
                        'status' => $this->status,
                    ]);
    }

    public function attachments(): array
    {
        return [];
    }

}
