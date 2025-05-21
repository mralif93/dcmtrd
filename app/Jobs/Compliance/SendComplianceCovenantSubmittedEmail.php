<?php

namespace App\Jobs\Compliance;

use App\Models\User;
use App\Models\ComplianceCovenant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Compliance\ComplianceCovenantSubmitted;

class SendComplianceCovenantSubmittedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ComplianceCovenant $complianceCovenant)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emails = ['roslimsyah@artrustees.com.my', 'mohamad.azahari@artrustees.com.my'];

        $users = User::whereIn('email', $emails)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ComplianceCovenantSubmitted($this->complianceCovenant, $user));
        }
    }
}
