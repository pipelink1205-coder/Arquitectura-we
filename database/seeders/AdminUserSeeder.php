<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@we.local');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrador WE',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'WeAdmin2026!')),
                'is_admin' => true,
            ]
        );
    }
}
