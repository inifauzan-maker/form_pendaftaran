<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@artcamp.test'],
            [
                'name' => 'Super Admin',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('SuperSecret123!'),
            ]
        );
    }
}
