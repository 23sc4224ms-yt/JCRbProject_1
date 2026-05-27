<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Degree;
use App\Models\Course;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get degrees
        $bsit = Degree::where('name', 'BSIT')->first();
        $hm = Degree::where('name', 'HM')->first();
        $bsoa = Degree::where('name', 'BSOA')->first();

        // Sample students data
        $students = [
            [
                'fname' => 'Janwis',
                'mname' => '',
                'lname' => 'Caguioa Rosario',
                'age' => 21,
                'degree_id' => $bsit?->id,
                'contact' => '09123456789',
                'email' => 'janwis@example.com',
            ],
            [
                'fname' => 'Jessie',
                'mname' => '',
                'lname' => 'Caguioa Rosario',
                'age' => 22,
                'degree_id' => $hm?->id,
                'contact' => '09123456790',
                'email' => 'jessie@example.com',
            ],
            [
                'fname' => 'Michael',
                'mname' => '',
                'lname' => 'Fatas Daias',
                'age' => 20,
                'degree_id' => $hm?->id,
                'contact' => '09123456791',
                'email' => 'michael@example.com',
            ],
            [
                'fname' => 'Trike',
                'mname' => '',
                'lname' => 'GAS MAHAL',
                'age' => 18,
                'degree_id' => $bsoa?->id,
                'contact' => '09123456792',
                'email' => 'trike@example.com',
            ],
        ];

        $electives = Course::whereIn('name', ['ELECTIVE 1', 'ELECTIVE 2', 'ELECTIVE 3', 'ELECTIVE 4', 'ELECTIVE 5'])
            ->orderBy('name')
            ->get();

        foreach ($students as $index => $student) {
            $createdStudent = Student::updateOrCreate(
                ['email' => $student['email']],
                $student
            );

            if ($electives->isNotEmpty()) {
                $createdStudent->courses()->syncWithoutDetaching([
                    $electives[$index % $electives->count()]->id,
                ]);
            }
        }
    }
}
