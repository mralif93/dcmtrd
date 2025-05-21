<?php

namespace App\Jobs\ListSecurity;

use App\Models\User;
use App\Models\SecurityDocRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ListSecurity\ListSecurityRequestSubmited;

class SendListSecurityRequestEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected SecurityDocRequest $securityReq)
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
            Mail::to($user->email)->send(new ListSecurityRequestSubmited($this->securityReq, $user));
        }
    }
}
