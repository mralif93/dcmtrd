<?php

namespace App\Jobs\TrusteeFee;

use App\Models\User;
use App\Models\TrusteeFee;
use App\Mail\TrusteeFeeSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTrusteeFeeSubmittedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected TrusteeFee $trusteeFee) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emails = ['roslimsyah@artrustees.com.my', 'mohamad.azahari@artrustees.com.my'];

        $users = User::whereIn('email', $emails)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new TrusteeFeeSubmitted($this->trusteeFee, $user));
        }
    }
}
