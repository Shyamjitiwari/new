<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BulkMessageCustomSender extends Mailable
{
    use Queueable, SerializesModels;

    public $m;
    public $user;
    public $sub;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$m, $sub)
    {
        $this->user = $user;
        $this->m = $m;
        $this->sub = $sub;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.bulk_message_custom_sender')->subject($this->sub);
    }
}
