<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OwenIt\Auditing\Models\Audit;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        Audit::create([
            'user_id' => $event->user->id,
            'user_type' => 'App\Models\User',
            'event' => 'login',
            'auditable_type' => 'App\Models\User',
            'auditable_id' => $event->user->id,
            'old_values' => [],
            'new_values' => [
                'Email Login' => $event->user->email,
                'Name Login' => $event->user->name,
            ],
            'url' => request()->url(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'tags' => 'authentication',
        ]);
    }
}
