<?php

namespace App\Jobs\Issuer;

use App\Models\User;
use App\Models\Issuer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Issuer\ApproveIssuerToPreparerEmails;

class SendIssuerApprovedNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Issuer $issuer) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('name', $this->issuer->prepared_by)->first();

        Log::info("Send to PreparedBy User Email:\n" . json_encode($user->email, JSON_PRETTY_PRINT) );

        // Make sure the user exists and has an email
        if ($user && $user->email) {
            Mail::to($user->email)->send(new ApproveIssuerToPreparerEmails($this->issuer, $user));
        }
    }
}
