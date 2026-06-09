<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Services\SalesLeaderboardService;
use Illuminate\Http\Request;

class RevenueLeaderboardController extends Controller
{
    public function __construct(
        private SalesLeaderboardService $leaderboardService
    ) {}

    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $reportDate = $request->get('report_date', now()->toDateString());

        if (!in_array($period, ['daily', 'weekly', 'monthly', 'overall'])) {
            $period = 'daily';
        }

        $data = $this->leaderboardService->getDashboardData($period, $reportDate);

        return view('revenue-leaderboard.index', [
            'period' => $period,
            'reportDate' => $reportDate,
            'data' => $data,
        ]);
    }

    public function data(Request $request)
    {
        $period = $request->get('period', 'daily');
        $reportDate = $request->get('report_date', now()->toDateString());

        if (!in_array($period, ['daily', 'weekly', 'monthly', 'overall'])) {
            $period = 'daily';
        }

        return response()->json(
            $this->leaderboardService->getDashboardData($period, $reportDate)
        );
    }
}
