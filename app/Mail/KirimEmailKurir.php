<?php

namespace App\Mail;

use Faker\Provider\ar_EG\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class KirimEmailKurir extends Mailable
{
    use Queueable, SerializesModels;

    public $kedatangan;
    public $status;
    public $tamu;
    public $qrCodePath;
    public $ekspedisi;
    public $fotoPath;
    public $pegawaiTujuan;

    public function __construct($ekspedisi, $fotoPath, $pegawaiTujuan)
    {
        $this->ekspedisi = $ekspedisi;
        $this->fotoPath = $fotoPath;
        $this->pegawaiTujuan = $pegawaiTujuan;
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
        return $this->subject('Kurir Baru Ditambahkan')
                    ->view('pegawai.email.kurir')
                    ->attach(storage_path('app/public/' . $this->fotoPath));
    }

    /**
     * Create a new message instance.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
