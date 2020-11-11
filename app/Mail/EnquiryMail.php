<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $number;
    public $email;
    public $subject;
    public $description;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param null $number
     * @param null $subject
     * @param null $description
     */
    public function __construct($email, $name = null, $number = null, $subject = null, $description = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->subject = $subject;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.enquiry')->subject('Enquiry');
    }
}
