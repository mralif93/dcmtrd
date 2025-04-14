<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\TrusteeFee;
use Illuminate\Console\Command;
use Symfony\Component\Clock\now;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Issuer\PendingIssuerForApprovalEmails;

class SendTrusteeFeeReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-trustee-fee-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */ public function handle()
    {
        $today = now()->startOfDay();
        $daysBefore = 30;

        $reminderFields = [
            'first_reminder',
            'second_reminder',
            'third_reminder',
        ];

        foreach ($reminderFields as $field) {
            $fees = TrusteeFee::whereDate($field, $today->copy()->addDays($daysBefore))
                ->whereNotNull('prepared_by')
                ->get();

            Log::info("Sending reminders for $field: ", $fees->toArray());

            foreach ($fees as $fee) {
                $message = "[$field Reminder] TrusteeFee #{$fee->id} is due on {$fee->$field}.\nPrepared by: {$fee->prepared_by}";

                $this->info($message);
                // Mail::to($user->email)->send(new PendingIssuerForApprovalEmails($this->issuer, $user));

            }
        }

        $this->info('Trustee fee reminders check completed.');
    }
}
