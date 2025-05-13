<?php

namespace App\Jobs\ListSecurity;

use App\Models\User;
use App\Models\ListSecurity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ListSecurity\ListSecurityRejected;

class SendListSecurityRejectedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ListSecurity $listSecurity)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('name', $this->listSecurity->prepared_by)->first();

        if ($user && $user->email) {
            Mail::to($user->email)->send(new ListSecurityRejected($this->listSecurity, $user));
        }
    }
}
