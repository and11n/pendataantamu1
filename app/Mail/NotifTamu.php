<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifTamu extends Mailable
{
    use Queueable, SerializesModels;

    public $kedatanganTamu;

    public function __construct($kedatanganTamu)
    {
        $this->kedatanganTamu = $kedatanganTamu;
    }

    public function build()
    {
        return $this->subject('Foto Tamu Berhasil Dikirim')
        ->view('email.fotoTamu')
        ->with(['kedatangan_tamu' => $this->kedatanganTamu]);
    }
    /**
     * Create a new message instance.
     */

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notif Tamu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.frontoffice',
        );
    }

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
