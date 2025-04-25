<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PaymentSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSchedule\PaymentScheduleReminderEmail;

class SendPaymentScheduleReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-payment-schedule-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment reminders based on user-defined reminder_total_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $schedules = PaymentSchedule::whereDate('payment_date', '>=', $today)->get();

        $users = User::where('department', 'DEBT CAPITAL MARKET & TRUST UNIT')->get();

        // Log::info($schedules);

        foreach ($schedules as $schedule) {
            $reminderDays = is_numeric($schedule->reminder_total_date) ? (int) $schedule->reminder_total_date : 0;

            $reminderDate = Carbon::parse($schedule->payment_date)->subDays($reminderDays);

            if ($reminderDate->isSameDay($today)) {
                Log::info("Sending payment reminder for PaymentSchedule #{$schedule->id} on $today:", [
                    'payment_date' => $schedule->payment_date,
                    'reminder_date' => $reminderDate,
                ]);

                foreach ($users as $user) {
                    // Ensure you don't send duplicate emails for the same date
                    $message = "PaymentSchedule #{$schedule->id} is due today ({$schedule->payment_date}).\nPrepared by: {$user->name}";
                    $this->info($message);

                    // Send email to user (implement your email logic here)
                    Mail::to($user->email)->send(new PaymentScheduleReminderEmail($schedule, $user));
                }
            }
        }

        $this->info('Reminders checked.');
    }
}
