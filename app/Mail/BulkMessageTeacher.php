<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BulkMessageTeacher extends Mailable
{
    use Queueable, SerializesModels;

    public $m;
    public $user;
    public $sub;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $message
     */
    public function __construct($user,$m,$sub)
    {
        $this->m = $m;
        $this->user = $user;
        $this->sub = $sub;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.bulk_message_teacher')->subject($this->sub);
    }
}
