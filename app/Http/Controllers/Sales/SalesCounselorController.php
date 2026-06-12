<?php

namespace App\Http\Controllers\Sales;

use App\Enum\MediaTypeEnum;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\MediaRepository;
use App\Services\SalesCounselorService;
use App\Services\SalesLeaderboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Support\MediaStorage;

class SalesCounselorController extends Controller
{
    public function __construct(
        private SalesCounselorService $counselorService,
        private SalesLeaderboardService $leaderboardService
    ) {}

    private function member()
    {
        return Auth::user()->salesTeamMember()->with('team')->first();
    }

    public function dashboard()
    {
        $member = $this->member();
        $stats = $this->counselorService->getDashboardStats($member);

        return view('sales.dashboard', compact('member', 'stats'));
    }

    public function courses(Request $request)
    {
        $search = $request->cat_search ? strtolower($request->cat_search) : null;

        $courses = CourseRepository::query()
            ->with(['instructor.user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('instructor.user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->whereNull('organization_id')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('sales.courses', compact('courses'));
    }

    public function leaderboard(Request $request)
    {
        $period = $request->get('period', 'daily');
        $reportDate = $request->get('report_date', now()->toDateString());

        if (!in_array($period, ['daily', 'weekly', 'monthly', 'overall'])) {
            $period = 'daily';
        }

        $data = $this->leaderboardService->getDashboardData($period, $reportDate);

        return view('sales.leaderboard', compact('period', 'reportDate', 'data'));
    }

    public function leaderboardData(Request $request)
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

    public function profile()
    {
        $member = $this->member();
        $user = Auth::user();

        return view('sales.profile', compact('member', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $member = $this->member();
        if ($member) {
            $member->update(['name' => $validated['name']]);
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function updateProfileImage(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'required|image|max:2048',
        ]);

        $profilePicture = MediaRepository::storeByRequest(
            $request->file('profile_picture'),
            'user/profile_picture',
            MediaTypeEnum::IMAGE
        );

        if ($profilePicture && $user->profilePicture) {
            MediaStorage::delete($user->profilePicture);
        }

        $user->media_id = $profilePicture ? $profilePicture->id : $user->media_id;
        $user->save();

        return back()->with('success', 'Profile picture updated');
    }
}
