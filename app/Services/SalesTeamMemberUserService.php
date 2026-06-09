<?php

namespace App\Services;

use App\Enum\MediaTypeEnum;
use App\Models\SalesTeam;
use App\Models\User;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Hash;

class SalesTeamMemberUserService
{
    public function createUserForMember(SalesTeam $team, array $memberData): User
    {
        $profilePicture = MediaRepository::storeByPath(
            public_path('media/blank-user.png'),
            'user/profile_picture',
            MediaTypeEnum::IMAGE
        );

        $user = User::create([
            'name' => $memberData['name'],
            'email' => $memberData['email'],
            'password' => Hash::make($memberData['password']),
            'sales_team_id' => $team->id,
            'media_id' => $profilePicture?->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        if (!$user->hasRole('sales_counselor')) {
            $user->assignRole('sales_counselor');
        }

        return $user;
    }

    public function updateUserForMember(User $user, SalesTeam $team, array $memberData): void
    {
        $update = [
            'name' => $memberData['name'],
            'email' => $memberData['email'],
            'sales_team_id' => $team->id,
        ];

        if (!empty($memberData['password'])) {
            $update['password'] = Hash::make($memberData['password']);
        }

        $user->update($update);

        if (!$user->hasRole('sales_counselor')) {
            $user->assignRole('sales_counselor');
        }
    }
}
