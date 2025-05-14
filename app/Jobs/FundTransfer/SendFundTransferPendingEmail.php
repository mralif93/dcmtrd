<?php

namespace App\Jobs\FundTransfer;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\PlacementFundTransfer;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\FundTransfer\FundTransferSubmitted;

class SendFundTransferPendingEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected PlacementFundTransfer $placementFundTransfer)
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
            Mail::to($user->email)->send(new FundTransferSubmitted($this->placementFundTransfer, $user));
        }
    }
}
