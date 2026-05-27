<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Degree;
use App\Models\Student;
use App\Models\UserAccount;
use Illuminate\Support\Facades\DB;

class InitialAccountsSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Ensure BSIT degree exists
            $bsit = Degree::firstOrCreate(
                ['name' => 'BSIT'],
                ['description' => 'Bachelor of Science in Information Technology']
            );

            // Create student Jamvis Rosario if not exists
            $student = Student::where('email', 'jamvis@example.com')->first();
            if (! $student) {
                $student = Student::create([
                    'fname' => 'Jamvis',
                    'mname' => '',
                    'lname' => 'Rosario',
                    'age' => 21,
                    'degree_id' => $bsit->id,
                    'contact' => null,
                    'email' => 'jamvis@example.com',
                ]);
            }

            // Create user account for Jamvis
            $jamvis = UserAccount::where('username', 'jamvis')->first();
            if (! $jamvis) {
                UserAccount::create([
                    'name' => 'Jamvis Rosario',
                    'email' => 'jamvis@example.com',
                    'username' => 'jamvis',
                    'password' => Hash::make('12345678'),
                    'role' => 'student',
                    'force_password_change' => true,
                ]);
            }

            // Create teacher Napoleon Hermoso for BSIT
            UserAccount::updateOrCreate(
                ['username' => 'naps'],
                [
                    'name' => 'Napoleon Hermoso',
                    'email' => 'napoleon@example.com',
                    'password' => Hash::make('12345678'),
                    'role' => 'teacher',
                    'force_password_change' => false,
                ]
            );
        });
    }
}
