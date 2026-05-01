<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->admin()->create([
            'name'  => 'Admin',
            'email' => 'admin@jhub.com',
        ]);

        // Employers with jobs
        $employers = User::factory()->employer()->count(5)->create();

        // Job Seekers
        $seekers = User::factory()->jobSeeker()->count(20)->create();

        // Jobs per employer
        $employers->each(function ($employer) use ($seekers) {
            $jobs = Job::factory()->count(4)->create(['employer_id' => $employer->id]);

            // Applications from job seekers
            $jobs->each(function ($job) use ($seekers) {
                $seekers->random(3)->each(function ($seeker) use ($job) {
                    Application::factory()->create([
                        'job_id'        => $job->id,
                        'job_seeker_id' => $seeker->id,
                    ]);
                });

                // Comments
                Comment::factory()->count(2)->create([
                    'job_id'  => $job->id,
                    'user_id' => $seekers->random()->id,
                ]);
            });
        });

        // Notifications
        User::all()->each(function ($user) {
            Notification::factory()->count(2)->create(['user_id' => $user->id]);
        });
    }
}
