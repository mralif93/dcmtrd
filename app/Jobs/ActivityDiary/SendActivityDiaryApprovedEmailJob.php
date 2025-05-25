<?php

namespace App\Jobs\ActivityDiary;

use App\Models\User;
use App\Models\ActivityDiary;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ActivityDiary\ActivityDiaryApprovedEmail;

class SendActivityDiaryApprovedEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ActivityDiary $activityDiary)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('name', $this->activityDiary->prepared_by)->first();

        // Make sure the user exists and has an email
        if ($user && $user->email) {
            Mail::to($user->email)->send(new ActivityDiaryApprovedEmail($this->activityDiary, $user));
        }
    }
}
