<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\User;
use App\Mail\LeadAssigned;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLeadAssignedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lead;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Lead $lead, User $user) {
        $this->lead = $lead;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle() 
    {
        Mail::to($this->user->email)->send(new LeadAssigned($this->lead));
    }
}
