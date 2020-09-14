<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\NewCourseNotification;
use App\Repositories\ModelsInterface\CourseRepositoryInterface;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use App\Traits\JsonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class NotifyCourseController extends Controller
{
    use JsonData;

    private $courseRepository;
    private $userRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->userRepository = $userRepository;
    }

    public function sendNotify(Request $request)
    {
        try {
            $courseId = $request->course_id;
            $course = $this->courseRepository->findById($courseId);
            $users = $this->userRepository->getUserByRole(config('const.seeder.role_id'));

            if (isset($users['errorMsg'])) {

                return $this->jsonMsgResult(trans('messages.social.unknown_error'), false, 500);
            } else {
                // notification
                Notification::sendNow($users, new NewCourseNotification($course), ['database']);

                // pusher notification real-time
                $options = [
                    'cluster' => 'ap1',
                    'encrypted' => true,
                ];
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options,
                );
                $pusher->trigger('notify-course', 'new-course-event', $course);

                return $this->jsonMsgResult(false, trans('messages.json.success'), 200);
            }
        } catch (\Exception $e) {

            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    public function markReadNotify($userId)
    {
        try {
            $result = $this->userRepository->markAllReadNotify($userId);
            if (isset($result['errorMsg'])) {
                return $this->jsonMsgResult(trans('messages.social.unknown_error'), false, 500);
            }

            return $this->jsonMsgResult(false, true, 200);
        } catch (\Exception $e) {

            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }
}
