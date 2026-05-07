<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudTramite extends Mailable
{
    use Queueable, SerializesModels;

    public array $datos;
    public string $tramiteNombre;

    public function __construct(array $datos, string $tramiteNombre)
    {
        $this->datos = $datos;
        $this->tramiteNombre = $tramiteNombre;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de trámite — ' . $this->tramiteNombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-tramite',
        );
    }
}