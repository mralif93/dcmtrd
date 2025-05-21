<?php

namespace App\Jobs\Compliance;

use App\Models\User;
use App\Models\ComplianceCovenant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\Compliance\ComplianceApproved;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComplianceApprovalEmail implements ShouldQueue
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
        $user = User::where('name', $this->complianceCovenant->prepared_by)->first();

        // Make sure the user exists and has an email
        if ($user && $user->email) {
            Mail::to($user->email)->send(new ComplianceApproved($this->complianceCovenant, $user));
        }
    }
}
