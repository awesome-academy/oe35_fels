<?php

namespace App\Http\Controllers\Fels;

use App\Http\Controllers\Controller;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showStatistics()
    {
        $user = Auth::user();
        $userId = $user->id;
        $related = [
            'words',
            'courses',
            'lessons',
        ];
        $userStatistic = $this->userRepository->getUserCountStatistic($userId, $related);

        return view('front-end.users.storyboard', [
            'userStatistic' => $userStatistic,
            ]);
    }

    public function getChartData()
    {
        $data = $this->makeChartFormat();
        $userId = Auth::user()->id;
        $result = $this->userRepository->getTotalWordMonth($userId);

        if (! isset($result['errorMsg'])) {
            foreach ($result as $value) {
                $indexMonth = $value->month - 1;
                $data['month'][$indexMonth] = $value->totalWord;
            }
        }

        return $data;
    }

    public function makeChartFormat()
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
            'month' => [
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
}
