<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAccount;

class AdminOnlySeeder extends Seeder
{
    public function run(): void
    {
        UserAccount::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('AdminPass123'),
                'role' => 'admin',
                'force_password_change' => false,
            ]
        );
    }
}
