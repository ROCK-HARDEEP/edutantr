<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesTeamStoreRequest;
use App\Http\Requests\SalesTeamUpdateRequest;
use App\Models\SalesTeam;
use App\Models\SalesTeamMember;
use App\Services\SalesTeamMemberUserService;
use Illuminate\Http\Request;

class SalesTeamController extends Controller
{
    public function __construct(
        private SalesTeamMemberUserService $memberUserService
    ) {}

    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;

        $teams = SalesTeam::withCount('members')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('sales-team.index', compact('teams'));
    }

    public function create()
    {
        return view('sales-team.create');
    }

    public function store(SalesTeamStoreRequest $request)
    {
        $team = SalesTeam::create([
            'name' => $request->name,
            'code' => $request->code,
            'daily_target' => $request->daily_target ?? 30000,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncMembers($team, $request->members ?? []);

        return to_route('sales-team.index')->with('success', 'Sales team created successfully');
    }

    public function edit(SalesTeam $salesTeam)
    {
        $salesTeam->load(['members.user']);

        return view('sales-team.edit', ['team' => $salesTeam]);
    }

    public function update(SalesTeamUpdateRequest $request, SalesTeam $salesTeam)
    {
        $salesTeam->update([
            'name' => $request->name,
            'code' => $request->code,
            'daily_target' => $request->daily_target ?? 30000,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $this->syncMembers($salesTeam, $request->members ?? [], true);

        return to_route('sales-team.index')->with('success', 'Sales team updated successfully');
    }

    public function destroy(SalesTeam $salesTeam)
    {
        $salesTeam->delete();

        return to_route('sales-team.index')->with('success', 'Sales team deleted successfully');
    }

    private function syncMembers(SalesTeam $team, array $members, bool $updating = false): void
    {
        $keptIds = [];

        foreach ($members as $memberData) {
            if (empty($memberData['name'])) {
                continue;
            }

            if ($updating && !empty($memberData['id'])) {
                $member = SalesTeamMember::where('sales_team_id', $team->id)
                    ->where('id', $memberData['id'])
                    ->first();

                if ($member) {
                    $member->update([
                        'name' => $memberData['name'],
                        'is_leader' => !empty($memberData['is_leader']),
                        'is_active' => array_key_exists('is_active', $memberData)
                            ? !empty($memberData['is_active'])
                            : true,
                    ]);

                    $this->syncMemberUser($team, $member, $memberData);

                    $keptIds[] = $member->id;
                    continue;
                }
            }

            $member = SalesTeamMember::create([
                'sales_team_id' => $team->id,
                'name' => $memberData['name'],
                'is_leader' => !empty($memberData['is_leader']),
                'is_active' => true,
            ]);

            $this->syncMemberUser($team, $member, $memberData);

            $keptIds[] = $member->id;
        }

        if ($updating) {
            SalesTeamMember::where('sales_team_id', $team->id)
                ->whereNotIn('id', $keptIds)
                ->delete();
        }
    }

    private function syncMemberUser(SalesTeam $team, SalesTeamMember $member, array $memberData): void
    {
        if (empty($memberData['email'])) {
            return;
        }

        if ($member->user_id && $member->user) {
            $this->memberUserService->updateUserForMember($member->user, $team, $memberData);
            return;
        }

        if (empty($memberData['password'])) {
            return;
        }

        $user = $this->memberUserService->createUserForMember($team, $memberData);
        $member->update(['user_id' => $user->id]);
    }
}
