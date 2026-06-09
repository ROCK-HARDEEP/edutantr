<?php

namespace App\Services;

use App\Models\SalesTeamMember;
use App\Models\Transaction;
use App\Models\User;

class SalesCounselorService
{
    public function __construct(
        private SalesLeaderboardService $leaderboardService
    ) {}

    public function getDashboardStats(SalesTeamMember $member): array
    {
        $transactions = $this->paidTransactionsForMember($member);

        return [
            'total_students' => $this->managedStudentsQuery($member)->count(),
            'total_courses' => \App\Repositories\CourseRepository::query()->whereNull('organization_id')->count(),
            'total_revenue' => (float) (clone $transactions)->sum('payment_amount'),
            'total_payments' => (clone $transactions)->count(),
        ];
    }

    public function getManagedStudents(SalesTeamMember $member, ?string $search = null)
    {
        return $this->managedStudentsQuery($member)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(25)
            ->withQueryString();
    }

    public function studentBelongsToCounselor(User $student, SalesTeamMember $member): bool
    {
        if ($student->sales_team_member_id === $member->id) {
            return true;
        }

        return Transaction::query()
            ->where('user_id', $student->id)
            ->where('sales_team_member_id', $member->id)
            ->exists();
    }

    public function managedStudentsQuery(SalesTeamMember $member)
    {
        return User::query()
            ->where('is_admin', false)
            ->where('is_org', false)
            ->whereDoesntHave('instructor')
            ->whereDoesntHave('organization')
            ->where(function ($query) use ($member) {
                $query->where('sales_team_member_id', $member->id)
                    ->orWhereHas('transactions', function ($q) use ($member) {
                        $q->where('sales_team_member_id', $member->id);
                    });
            });
    }

    public function getLeaderboardData(string $period, SalesTeamMember $member): array
    {
        $data = $this->leaderboardService->getDashboardData($period);
        $counselorBoard = $data['counselor_leaderboard'];

        $myRank = $counselorBoard->first(function ($row) use ($member) {
            return ($row['counselor_name'] ?? '') === $member->name;
        });

        return array_merge($data, [
            'my_rank' => $myRank,
            'my_member_id' => $member->id,
        ]);
    }

    private function paidTransactionsForMember(SalesTeamMember $member)
    {
        return Transaction::query()
            ->where('is_paid', true)
            ->where('sales_team_member_id', $member->id);
    }
}
