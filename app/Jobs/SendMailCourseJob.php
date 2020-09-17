<?php

namespace App\Jobs;

use App\Notifications\NewCourseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendMailCourseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout;

    public $users;
    public $course;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $course)
    {
        $this->users = $users;
        $this->course = $course;
        $this->tries = config('const.job.tries');
        $this->timeout = config('const.job.timeout');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::sendNow($this->users, new NewCourseNotification($this->course), ['mail']);
    }
}
