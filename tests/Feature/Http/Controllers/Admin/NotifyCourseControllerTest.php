<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyCourseControllerTest extends TestCase
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

    public function test_send_notify_to_user()
    {
        Notification::fake();
        $user = $this->user;
        $course = $this->course;
        $user->notify(new NewCourseNotification($course));

        Notification::assertSentTo(
            $user,
            NewCourseNotification::class,
            function ($notification, $channels) use ($user, $course) {
                $data = $notification->toArray($user)->toArray();
                $this->assertEquals($course->id, $data['id']);
                $this->assertEquals($course->name, $data['name']);
                $this->assertContains($course->description, $data);

                return $notification->course->id === $course->id;
            }
        );
    }
}
