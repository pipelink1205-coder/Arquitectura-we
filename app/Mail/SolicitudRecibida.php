<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Solicitud $solicitud)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consulta web: '.$this->solicitud->servicio.' — '.$this->solicitud->nombre,
            replyTo: $this->solicitud->correo
                ? [new Address($this->solicitud->correo, $this->solicitud->nombre)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.solicitud');
    }
}
