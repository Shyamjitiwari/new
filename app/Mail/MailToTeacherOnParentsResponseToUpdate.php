<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailToTeacherOnParentsResponseToUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public $m;
    public $feedback;
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacher, $m, $feedback, $student)
    {
        $this->teacher = $teacher;
        $this->m = $m;
        $this->feedback = $feedback;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.message_to_teacher_on_update_reply')->subject('Parent has given feedback!');
    }
}
