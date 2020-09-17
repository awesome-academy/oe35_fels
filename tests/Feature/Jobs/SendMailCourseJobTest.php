<?php

namespace Tests\Feature\Jobs;

use App\Jobs\SendMailCourseJob;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendMailCourseJobTest extends TestCase
{
    use WithoutMiddleware;

    protected $course;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $role = factory(Role::class)->create();
        $this->user = factory(User::class)->create([
            'role_id' => $role->id,
        ]);
        $this->course = factory(Course::class)->create();
    }

    public function test_handle_queue_jobs()
    {
        Queue::fake();
        $user = $this->user;
        $course = $this->course;

        SendMailCourseJob::dispatch($user, $course);

        Queue::assertPushed(SendMailCourseJob::class);
    }
}
