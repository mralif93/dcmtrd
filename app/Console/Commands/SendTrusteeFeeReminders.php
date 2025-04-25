<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TrusteeFee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\TrusteeFee\SendTrusteeFeeReminderEmail;

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
    protected $description = 'Send reminders for Trustee Fees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay(); // today = 2025-05-19 (for example)

        $reminderFields = [
            'first_reminder',
            'second_reminder',
            'third_reminder',
        ];

        foreach ($reminderFields as $field) {
            $fees = TrusteeFee::whereDate($field, $today)
                ->whereNotNull('prepared_by')
                ->get();

            if ($fees->isEmpty()) {
                $this->info("No reminders for $field today.");
                continue;
            }

            Log::info("Sending reminders for $field on $today:", $fees->toArray());

            foreach ($fees as $fee) {
                // Ensure you don't send duplicate emails for the same date
                $message = "[$field Reminder] TrusteeFee #{$fee->id} is due today ({$fee->$field}).\nPrepared by: {$fee->prepared_by}";
                $this->info($message);

                // Find the issuer's email and send the reminder

                $user = User::where('name', $fee->prepared_by)->first();

                if ($user && $user->email) {
                    // Check if an email has already been sent for this fee on the same day
                    if (!isset($sentReminders[$fee->id])) {
                        SendTrusteeFeeReminderEmail::dispatch($user, $fee);
                        $sentReminders[$fee->id] = true;
                    }
                }
            }
        }

        $this->info('Trustee fee reminders check completed.');
    }
}
