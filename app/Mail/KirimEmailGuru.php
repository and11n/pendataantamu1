<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimEmailGuru extends Mailable
{
    use Queueable, SerializesModels;

    public $kedatangan;
    // public $tamu;

    public function __construct($kedatangan, $tamu)
    {
        $this->kedatangan = $kedatangan;
        // $this->tamu = $tamu;
        
    }

    public function build()
    {
        return $this->view('pegawai.email.kirimEmail')
            ->subject('Pemberitahuan Kedatangan Tamu');
    }
}
