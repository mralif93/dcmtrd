<?php

namespace App\Jobs\Issuer;

use App\Models\User;
use App\Models\Issuer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Issuer\PendingIssuerForApprovalEmails;

class SendCreatedIssuerToApproval implements ShouldQueue
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
        $users = User::where('department', 'DEBT CAPITAL MARKET & TRUST UNIT')->get();

        Log::info("SendCreatedIssuerToApproval job started:\nIssuer:\n" . json_encode($this->issuer->toArray(), JSON_PRETTY_PRINT));
        Log::info("Users:\n" . json_encode($users->toArray(), JSON_PRETTY_PRINT));

        foreach ($users as $user) {
            Mail::to($user->email)->send(new PendingIssuerForApprovalEmails($this->issuer, $user));
        }
    }
}
