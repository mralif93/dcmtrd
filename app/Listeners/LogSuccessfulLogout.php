<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogout
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
    public function handle(Logout $event): void
    {
        Audit::create([
            'user_id' => $event->user->id,
            'user_type' => 'App\Models\User',
            'event' => 'logout',
            'auditable_type' => 'App\Models\User',
            'auditable_id' => $event->user->id,
            'old_values' => [],
            'new_values' => [
                'Email Logout' => $event->user->email,
                'Name Logout' => $event->user->name,
            ],
            'url' => request()->url(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'tags' => 'authentication',
        ]);
    }
}
