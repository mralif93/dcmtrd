<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendPaymentScheduleReminders;
use App\Console\Commands\SendTrusteeFeeReminderEmail;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Artisan::command('app:send-payment-schedule-reminders', function () {
    $this->call(SendPaymentScheduleReminders::class);
})->purpose('Send payment schedule reminders')->daily()->withoutOverlapping();

Artisan::command('app:send-trustee-fee-reminder-email', function () {
    $this->call(SendTrusteeFeeReminderEmail::class);
})->purpose('Send trustee fee reminder emails')->daily()->withoutOverlapping();
