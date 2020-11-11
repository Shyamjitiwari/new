<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InCompleteClassesReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = __('sms_and_email.subject_of_incomplete_marked_classes_email');
        return $this->from('cwuteam@codewithus.com')
                    ->subject($subject)->view('mail.incomplete_classes')
                    ->with('data',$this->data);
    }
}
