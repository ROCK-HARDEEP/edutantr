<?php

namespace App\Services;

use App\Models\SalesTeam;
use App\Models\SalesTeamMember;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SalesLeaderboardService
{
    public function getDateRange(string $period): array
    {
        return match ($period) {
            'daily' => [now()->startOfDay(), now()->endOfDay()],
            'weekly' => [now()->startOfWeek(), now()->endOfWeek()],
            'monthly' => [now()->startOfMonth(), now()->endOfMonth()],
            default => [null, null],
        };
    }

    public function paidTransactionsQuery(?Carbon $start = null, ?Carbon $end = null)
    {
        return Transaction::query()
            ->where('is_paid', true)
            ->whereNotNull('sales_team_id')
            ->when($start && $end, fn ($q) => $q->whereBetween('paid_at', [$start, $end]));
    }

    public function getCounselorLeaderboard(string $period = 'daily'): Collection
    {
        [$start, $end] = $this->getDateRange($period);

        $rows = $this->paidTransactionsQuery($start, $end)
            ->select(
                'sales_team_member_id',
                DB::raw('COUNT(*) as payments_count'),
                DB::raw('SUM(payment_amount) as revenue')
            )
            ->whereNotNull('sales_team_member_id')
            ->groupBy('sales_team_member_id')
            ->orderByDesc('revenue')
            ->get();

        $members = SalesTeamMember::with('team')
            ->whereIn('id', $rows->pluck('sales_team_member_id'))
            ->get()
            ->keyBy('id');

        return $rows->map(function ($row, $index) use ($members) {
            $member = $members->get($row->sales_team_member_id);

            return [
                'rank' => $index + 1,
                'counselor_name' => $member?->name ?? 'Unknown',
                'team_name' => $member?->team?->name ?? '-',
                'payments_count' => (int) $row->payments_count,
                'revenue' => (float) $row->revenue,
            ];
        })->values();
    }

    public function getTeamDailyProgress(?Carbon $date = null): Collection
    {
        $date = $date ?? now();
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();

        $teams = SalesTeam::with(['activeMembers' => fn ($q) => $q->orderBy('name')])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $teamRevenue = $this->paidTransactionsQuery($start, $end)
            ->select('sales_team_id', DB::raw('SUM(payment_amount) as revenue'))
            ->groupBy('sales_team_id')
            ->pluck('revenue', 'sales_team_id');

        $memberStats = $this->paidTransactionsQuery($start, $end)
            ->select(
                'sales_team_member_id',
                'sales_team_id',
                DB::raw('COUNT(*) as payments_count'),
                DB::raw('SUM(payment_amount) as revenue')
            )
            ->whereNotNull('sales_team_member_id')
            ->groupBy('sales_team_member_id', 'sales_team_id')
            ->get()
            ->keyBy('sales_team_member_id');

        return $teams->map(function (SalesTeam $team) use ($teamRevenue, $memberStats) {
            $achieved = (float) ($teamRevenue[$team->id] ?? 0);
            $target = (float) $team->daily_target;
            $progress = $target > 0 ? min(100, round(($achieved / $target) * 100, 1)) : 0;

            $members = $team->activeMembers->map(function ($member) use ($memberStats) {
                $stat = $memberStats->get($member->id);

                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'is_leader' => $member->is_leader,
                    'payments_count' => (int) ($stat->payments_count ?? 0),
                    'revenue' => (float) ($stat->revenue ?? 0),
                ];
            });

            return [
                'id' => $team->id,
                'name' => $team->name,
                'code' => $team->code,
                'daily_target' => $target,
                'achieved' => $achieved,
                'progress' => $progress,
                'members' => $members,
            ];
        })->sortByDesc('achieved')->values();
    }

    public function getTopPerformer(string $period = 'daily'): ?array
    {
        $leaderboard = $this->getCounselorLeaderboard($period);

        return $leaderboard->first();
    }

    public function getTopTeamLeaderOfDay(): ?array
    {
        $teams = $this->getTeamDailyProgress();
        $topTeam = $teams->first();

        if (!$topTeam || $topTeam['achieved'] <= 0) {
            return null;
        }

        $leader = collect($topTeam['members'])->firstWhere('is_leader', true)
            ?? collect($topTeam['members'])->sortByDesc('revenue')->first();

        if (!$leader) {
            return null;
        }

        return [
            'name' => $leader['name'],
            'team_name' => $topTeam['name'],
            'revenue' => $leader['revenue'],
            'payments_count' => $leader['payments_count'],
            'team_achieved' => $topTeam['achieved'],
            'team_target' => $topTeam['daily_target'],
        ];
    }

    public function getDailyTeamReport(Carbon $date): array
    {
        $teams = $this->getTeamDailyProgress($date);

        return [
            'date' => $date->toDateString(),
            'teams' => $teams,
            'total_revenue' => $teams->sum('achieved'),
        ];
    }

    public function getDashboardData(string $period = 'daily', ?string $reportDate = null): array
    {
        $reportCarbon = $reportDate ? Carbon::parse($reportDate) : now();

        $counselorBoard = $this->getCounselorLeaderboard($period);
        $topThree = $counselorBoard->take(3)->values();
        $teamsToday = $this->getTeamDailyProgress(now());
        $topTeam = $teamsToday->first();

        return [
            'period' => $period,
            'top_performer' => $this->getTopPerformer($period),
            'top_three' => $topThree,
            'top_team_leader' => $this->getTopTeamLeaderOfDay(),
            'counselor_leaderboard' => $counselorBoard,
            'teams' => $teamsToday,
            'top_team' => $topTeam,
            'daily_report' => $this->getDailyTeamReport($reportCarbon),
            'rankings' => [
                'daily' => $this->getCounselorLeaderboard('daily'),
                'weekly' => $this->getCounselorLeaderboard('weekly'),
                'monthly' => $this->getCounselorLeaderboard('monthly'),
                'overall' => $this->getCounselorLeaderboard('overall'),
            ],
        ];
    }

    public function formatCurrency(float $amount): string
    {
        return '₹' . number_format($amount, 0, '.', ',');
    }
}
