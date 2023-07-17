<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamMails extends Mailable
{
    use Queueable, SerializesModels;

    public $employer;
    public $names;
    public $teamInfo;
    public $type;
    public $taskInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employer, $names, $teamInfo, $type)
    {
        //
        if ($type == "create_team") {
            $this->employer = $employer;
            $this->names = $names;
            $this->teamInfo = $teamInfo;
            $this->type = $type;

        } elseif ($type == "approve_team") {
            $this->employer = $employer;
            $this->names = $names;
            $this->teamInfo = $teamInfo;
            $this->type = $type;
        } elseif ($type == "reject_team") {

            $this->employer = $employer;
            $this->names = $names;
            $this->teamInfo = $teamInfo;
            $this->type = $type;
        } elseif ($type == "team_task_creation") {

            $this->employer = $employer;
            $this->teamInfo = $names;
            $this->taskInfo = $teamInfo;
            $this->type = $type;
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
            markdown: $this->getMarkdown(),
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

    protected function getSubject()
    {
        if ($this->type == 'approve_team') {
            return 'Team Update Status: Approved';
        } elseif ($this->type == 'reject_team') {
            return 'Team Update Status: Rejected';
        } elseif ($this->type == 'create_team') {
            return 'Team Creation';
        } elseif ($this->type == "team_task_creation") {
            return "New Team Task Assignment";
        }
    }

    protected function getMarkdown()
    {
        if ($this->type == 'approve_team') {

            return 'emails.team_approved';

        } elseif ($this->type == 'reject_team') {

            return 'emails.team_rejected';

        } elseif ($this->type == 'create_team') {

            return 'emails.team_creations';
        }elseif ($this->type =="team_task_creation"){
            return 'emails.team_task_notices';
        }
    }
}
