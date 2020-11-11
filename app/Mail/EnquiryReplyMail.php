<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $number;
    public $email;
    public $reply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name = null, $number = null, $description = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->reply = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.enquiryReply')->subject('Enquiry Reply');    
    }
}
