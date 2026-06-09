<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use Illuminate\Http\Request;

class SalesTeamApiController extends Controller
{
    public function validateCode(Request $request)
    {
        $request->validate([
            'team_code' => 'required|string|size:4',
        ]);

        $team = SalesTeam::with(['activeMembers' => fn ($q) => $q->orderBy('name')])
            ->where('code', $request->team_code)
            ->where('is_active', true)
            ->first();

        if (!$team) {
            return $this->json('Invalid team code', ['is_valid' => false], 404);
        }

        return $this->json('Team code is valid', [
            'is_valid' => true,
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'code' => $team->code,
                'members' => $team->activeMembers->map(fn ($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'is_leader' => $m->is_leader,
                ]),
            ],
        ]);
    }
}
