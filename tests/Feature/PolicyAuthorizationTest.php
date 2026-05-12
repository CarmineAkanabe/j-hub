<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Comment;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cannot_manage_another_employers_job(): void
    {
        $owner = User::factory()->employer()->create();
        $otherEmployer = User::factory()->employer()->create();
        $job = Job::factory()->create(['employer_id' => $owner->id]);

        $this->actingAs($otherEmployer)
            ->get(route('employer.jobs.show', $job))
            ->assertForbidden();

        $this->actingAs($otherEmployer)
            ->patch(route('employer.jobs.update', $job), [
                'title' => 'Updated title',
            ])
            ->assertForbidden();
    }

    public function test_employer_can_manage_their_own_job(): void
    {
        $employer = User::factory()->employer()->create();
        $job = Job::factory()->create(['employer_id' => $employer->id]);

        $this->actingAs($employer)
            ->get(route('employer.jobs.show', $job))
            ->assertOk();
    }

    public function test_job_seeker_cannot_view_another_job_seekers_application(): void
    {
        $employer = User::factory()->employer()->create();
        $owner = User::factory()->jobSeeker()->create();
        $otherSeeker = User::factory()->jobSeeker()->create();
        $job = Job::factory()->create(['employer_id' => $employer->id]);
        $application = Application::factory()->create([
            'job_id' => $job->id,
            'job_seeker_id' => $owner->id,
        ]);

        $this->actingAs($otherSeeker)
            ->get(route('jobseeker.applications.show', $application))
            ->assertForbidden();
    }

    public function test_employer_cannot_update_status_for_another_employers_application(): void
    {
        $owner = User::factory()->employer()->create();
        $otherEmployer = User::factory()->employer()->create();
        $seeker = User::factory()->jobSeeker()->create();
        $job = Job::factory()->create(['employer_id' => $owner->id]);
        $application = Application::factory()->create([
            'job_id' => $job->id,
            'job_seeker_id' => $seeker->id,
        ]);

        $this->actingAs($otherEmployer)
            ->patch(route('employer.applicants.updateStatus', $application), [
                'status' => ApplicationStatus::ACCEPTED->value,
            ])
            ->assertForbidden();
    }

    public function test_job_seeker_cannot_edit_another_job_seekers_comment(): void
    {
        $employer = User::factory()->employer()->create();
        $owner = User::factory()->jobSeeker()->create();
        $otherSeeker = User::factory()->jobSeeker()->create();
        $job = Job::factory()->create(['employer_id' => $employer->id]);
        $comment = Comment::factory()->create([
            'job_id' => $job->id,
            'user_id' => $owner->id,
        ]);

        $this->actingAs($otherSeeker)
            ->get(route('jobseeker.comments.edit', $comment))
            ->assertForbidden();
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.users.show', $admin))
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect(route('admin.users.show', $admin));

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
