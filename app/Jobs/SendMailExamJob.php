<?php

namespace App\Jobs;

use App\Mail\NotDoneExamMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailExamJob implements ShouldQueue
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

    public $user;
    public $courses;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $courses)
    {
        $this->user = $user;
        $this->courses = $courses;
        $this->tries = config('const.job.tries');
        $this->timeout = config('const.job.time');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->user->email;

        Mail::to($email)->send(new NotDoneExamMail($this->user, $this->courses));
    }
}
