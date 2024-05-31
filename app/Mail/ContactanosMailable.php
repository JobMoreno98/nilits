<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\alumnos_model;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $alumno;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(alumnos_model $alumno = null)
    {
        $this->alumno = $alumno;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('ezequielmora.chk@gmail.com', 'Ezequiel Mora'),
            subject: 'Confirmación de Registro de Aspirante',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'aspirantes.contactanos',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
