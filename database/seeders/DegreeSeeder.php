<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Degree;
use App\Models\Course;
use App\Models\Teacher;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degree = Degree::firstOrCreate(['name' => 'BSIT']);
        $teacher = Teacher::first();
        $electives = collect(range(1, 5))->map(fn ($number) => "ELECTIVE {$number}")->all();

        Course::where('degree_id', $degree->id)
            ->whereIn('name', ['Information Technology', 'Computer Science'])
            ->delete();

        foreach ($electives as $elective) {
            Course::updateOrCreate(
                ['name' => $elective],
                [
                    'degree_id' => $degree->id,
                    'teacher_id' => $teacher?->id,
                ]
            );
        }
    }
}
