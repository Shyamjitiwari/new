<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadAssignedMailToAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $lead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $lead)
    {
        $this->user = $user;
        $this->lead = $lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.LeadAssignedMailToAdmin');
    }
}
