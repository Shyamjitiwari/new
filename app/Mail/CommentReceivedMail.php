<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $blog;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comment, $blog)
    {
        $this->blog = $blog;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('mails.commentReceived')->subject('Comment received.');
    }
}
