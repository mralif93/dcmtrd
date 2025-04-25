<?php

namespace App\Jobs\Issuer;

use App\Models\User;
use App\Models\Issuer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Issuer\RejectIssuerToPreparerEmails;

class SendIssuerRejectedNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Issuer $issuer)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('name', $this->issuer->prepared_by)->first();

        if ($user && $user->email) {
            Mail::to($user->email)->send(new RejectIssuerToPreparerEmails($this->issuer, $user));
        }
    }
}
