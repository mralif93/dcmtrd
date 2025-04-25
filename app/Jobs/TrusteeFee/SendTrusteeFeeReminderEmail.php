<?php

namespace App\Jobs\TrusteeFee;

use App\Models\User;
use App\Models\TrusteeFee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\TrusteeFee\NotifyTrusteeFeeReminders;

class SendTrusteeFeeReminderEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected User $user, protected TrusteeFee $fee) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new NotifyTrusteeFeeReminders($this->fee));
    }
}
