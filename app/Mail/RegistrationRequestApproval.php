<?php

namespace App\Mail;

use App\Models\User;
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
    public $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $type, $username)
    {
        //
        if ($type == 'Manager') {
            $UID = User::all()->where('employer_id', '=', $data->id)->first();
            $this->user_id = $UID->id;
            $this->first_name = $data->first_name;
            $this->last_name = $data->last_name;
            $this->type = $type;
            $this->username = $username;
            $this->password = 'arcadian_user_resource_123';

        } elseif ($type == 'Employee') {
            $UID = User::all()->where('employee_id', '=', $data->id)->first();
            $this->user_id = $UID->id;
            $this->first_name = $data->first_name;
            $this->last_name = $data->last_name;
            $this->type = $type;
            $this->username = $username;
            $this->password = 'arcadian_user_resource_123';
        }

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->getSubject(),
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

    protected function getSubject()
    {
        if ($this->type == 'Manager') {
            return 'Registration Request Approval for Manager';
        } elseif ($this->type == 'Employee') {
            return 'Registration Request Approval for Employee';
        }

        return 'Registration Request Approval';
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
