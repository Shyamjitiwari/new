<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadAssignedMailToAdmin;
use App\Mail\LeadAssignedMailToUser;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user , $lead;
  
    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $lead)
    {
        $this->user = $user;
        $this->lead = $lead;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         
        Mail::to($this->user->email)->send(new LeadAssignedMailToUser($this->user, $this->lead));
        Mail::to('superadmin@app.com')->send(new LeadAssignedMailToAdmin($this->user, $this->lead));
        
    }
}
