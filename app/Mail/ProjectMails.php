<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectMails extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $last_name;
    public $type;
    public $project_title;
    public $project_description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manager, $type, $project)
    {
        //
        if ($type == "approve_project") {
            $this->type = $type;
            $this->first_name = $manager->first_name;
            $this->last_name = $manager->last_name;

            $project = Project::all()->where('id', '=', $project->id)->first();
            $this->project_title = $project->project_title;
            $this->project_description = $project->project_description;

        } elseif ($type = "reject_project") {
            $this->type = $type;
            $this->first_name = $manager->first_name;
            $this->last_name = $manager->last_name;

            $project = Project::all()->where('id', '=', $project->id)->first();
            $this->project_title = $project->project_title;
            $this->project_description = $project->project_description;
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
            subject: 'Project Mails',
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

    protected function getMarkdown()
    {
        if ($this->type == 'approve_project') {
            return 'emails.project_approved';
        } elseif ($this->type == 'reject_project') {
            return 'emails.project_rejected';
        }

        return 'emails.registration_request';
    }
}
