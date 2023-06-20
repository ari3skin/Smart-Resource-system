<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationRequestApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $last_name;
    public $type;
    public $username;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $type, $username)
    {
        //
        $this->first_name = $data->first_name;
        $this->last_name = $data->last_name;
        $this->type = $type;
        $this->username = $username;
        $this->password = 'arcadian_user_resource_123';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Registration Request Approval',
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
            markdown: 'emails.registration_request',
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
