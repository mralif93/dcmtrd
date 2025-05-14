<?php

namespace App\Jobs\FundTransfer;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\PlacementFundTransfer;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\FundTransfer\FundTransferApproved;

class SendFundTransferApprovedEmail implements ShouldQueue
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
        $user = User::where('name', $this->placementFundTransfer->prepared_by)->first();

        // Make sure the user exists and has an email
        if ($user && $user->email) {
            Mail::to($user->email)->send(new FundTransferApproved($this->placementFundTransfer, $user));
        }
    }
}
