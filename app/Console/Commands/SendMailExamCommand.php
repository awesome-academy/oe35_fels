<?php

namespace App\Console\Commands;

use App\Jobs\SendMailExamJob;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMailExamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:exam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to user who not finish the exam of the course had learned';

    protected $userRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();

        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // get active users
            $roleId = config('const.seeder.role_id');
            $users = $this->userRepo->getUserByRole($roleId);

            foreach ($users as $user) {
                // Get courses which user had learned but not do the lesson
                $courses = $this->userRepo->getCoursesNotDoLesson($user->id);

                if (! $courses->isEmpty()) {
                    SendMailExamJob::dispatchNow($user, $courses);
                }
            }

        } catch (\Exception $e) {

            return Log::info($e->getMessage());
        }
    }
}
