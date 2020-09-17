<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Word;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use App\Traits\EloquentTraitable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use EloquentTraitable;

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $totalCourse = $this->countTotalRecord(Course::class);
        $totalLesson = $this->countTotalRecord(Lesson::class);
        $totalWord = $this->countTotalRecord(Word::class);
        $totalUser = $this->userRepo->countTotalUser();
        $totalActiveUser = $this->userRepo->countTotalActiveUser();
        // count total admin
        $roleIdAdmin = config('const.role.admin');
        $totalAdmin = $this->userRepo->getUserByRole($roleIdAdmin)->count();

        return view('back-end.dashboards.index', [
            'totalCourse' => $totalCourse,
            'totalLesson' => $totalLesson,
            'totalWord' => $totalWord,
            'totalUser' => $totalUser,
            'totalActiveUser' => $totalActiveUser,
            'totalAdmin' => $totalAdmin,
        ]);
    }

    public function getChartData(Request $request)
    {
        $datetime = $request->get('datetime');
        $result = $this->userRepo->getChartDataUser($datetime);

        switch ($datetime) {
            case 'month':
                $data = $this->makeChartMonthFormat();

                return $this->makeDataChart($result, $data);
                break;
            case 'quarter':
                $data = $this->makeChartQuarterFormat();

                return $this->makeDataChart($result, $data);
                break;

            case 'year':
                $data = [
                    'labels' => [],
                    'indexs' => [],
                ];

                if (! isset($result['errorMsg'])) {
                    foreach ($result as $key => $value) {
                        $data['labels'][$key] = $value->indexs;
                        $data['indexs'][$key] = $value->value;
                    }
                }

                return $data;
                break;

            default:
                break;
        }

        return $result;
    }

    public function makeDataChart($input, $data)
    {
        if (! isset($input['errorMsg'])) {
            foreach ($input as $value) {
                $index = $value->indexs - 1;
                $data['indexs'][$index] = $value->value;
            }
        }

        return $data;
    }

    public function makeChartMonthFormat()
    {
        $chart = [
            'labels' => [
                trans('messages.chart.label.jan'),
                trans('messages.chart.label.feb'),
                trans('messages.chart.label.mar'),
                trans('messages.chart.label.apr'),
                trans('messages.chart.label.may'),
                trans('messages.chart.label.june'),
                trans('messages.chart.label.july'),
                trans('messages.chart.label.aug'),
                trans('messages.chart.label.sept'),
                trans('messages.chart.label.oct'),
                trans('messages.chart.label.nov'),
                trans('messages.chart.label.dec'),
            ],
            'indexs' => [
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
            ],
        ];

        return $chart;
    }

    public function makeChartQuarterFormat()
    {
        $chart = [
            'labels' => [
                trans('messages.chart.quarter_label.1'),
                trans('messages.chart.quarter_label.2'),
                trans('messages.chart.quarter_label.3'),
                trans('messages.chart.quarter_label.4'),
            ],
            'indexs' => [
                '0',
                '0',
                '0',
                '0',
            ],
        ];

        return $chart;
    }
}
