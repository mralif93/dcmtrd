<?php

namespace App\Jobs\TrusteeFee;

use App\Models\User;
use App\Models\TrusteeFee;
use App\Mail\TrusteeFeeRejected;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTrusteeFeeRejectedNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected TrusteeFee $trusteeFee)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('name', $this->trusteeFee->prepared_by)->first();

        if ($user && $user->email) {
            Mail::to($user->email)->send(new TrusteeFeeRejected($this->trusteeFee, $user));
        }
    }
}
