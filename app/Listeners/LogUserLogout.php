<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Logout;

class LogUserLogout
{
    public function handle(Logout $event): void
    {
        ActivityLogger::log(
            action: 'auth.logout',
            description: 'Pengguna keluar dari sesi',
            properties: [
                'email' => $event->user?->email,
            ],
            user: $event->user
        );
    }
}
