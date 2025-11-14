<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        ActivityLogger::log(
            action: 'auth.login',
            description: 'Pengguna berhasil login',
            properties: [
                'email' => $event->user->email,
            ],
            user: $event->user
        );
    }
}
