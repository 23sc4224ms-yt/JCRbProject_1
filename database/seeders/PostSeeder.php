<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(3)->create();
        }

        // Reset sample posts so reseeding gives clean readable content.
        Post::query()->delete();

        $samplePosts = [
            [
                'title' => 'Enrollment Schedule Update',
                'content' => 'Enrollment for the next semester starts on April 15. Please complete your requirements before the deadline.',
            ],
            [
                'title' => 'Midterm Examination Notice',
                'content' => 'Midterm exams will begin next week. Check your subject schedules and room assignments posted by your department.',
            ],
            [
                'title' => 'Scholarship Application Reminder',
                'content' => 'Students who want to apply for scholarship grants must submit complete documents on or before April 30.',
            ],
        ];

        foreach ($users as $index => $user) {
            foreach ($samplePosts as $post) {
                Post::create([
                    'user_id' => $user->id,
                    'title' => $post['title'],
                    'content' => $post['content'] . ' (Author #' . ($index + 1) . ')',
                ]);
            }
        }
    }
}
