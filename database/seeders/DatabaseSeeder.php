<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

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

        User::factory(2)->create();

        $this->call([
            InitialAccountsSeeder::class,
            DegreeSeeder::class,
            StudentSeeder::class,
            PostSeeder::class,
        ]);
    }
}
