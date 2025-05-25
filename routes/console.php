<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendPaymentScheduleReminders;
use App\Console\Commands\SendTrusteeFeeReminderEmail;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Artisan::command('app:send-payment-schedule-reminders', function () {
//     $this->call(SendPaymentScheduleReminders::class);
// })->purpose('Send payment schedule reminders')->daily()->withoutOverlapping();

// Artisan::command('app:send-trustee-fee-reminder-email', function () {
//     $this->call(SendTrusteeFeeReminderEmail::class);
// })->purpose('Send trustee fee reminder emails')->daily()->withoutOverlapping();


Schedule::command('app:send-payment-schedule-reminders')->daily()->withoutOverlapping();
Schedule::command('app:send-trustee-fee-reminder-email')->daily()->withoutOverlapping();