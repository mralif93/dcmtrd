<?php

namespace App\Jobs\ListSecurity;

use App\Models\User;
use App\Models\ListSecurity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ListSecurity\ListSecuritySubmited;

class SendListSecuritySubmittedEmail implements ShouldQueue
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
        $emails = ['roslimsyah@artrustees.com.my', 'mohamad.azahari@artrustees.com.my'];

        $users = User::whereIn('email', $emails)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ListSecuritySubmited($this->listSecurity, $user));
        }
    }
}
