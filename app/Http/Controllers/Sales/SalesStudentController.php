<?php

namespace App\Http\Controllers\Sales;

use App\Enum\MediaTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesStudentStoreRequest;
use App\Http\Requests\SalesStudentUpdateRequest;
use App\Models\User;
use App\Repositories\MediaRepository;
use App\Services\SalesCounselorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SalesStudentController extends Controller
{
    public function __construct(
        private SalesCounselorService $counselorService
    ) {}

    private function member()
    {
        return Auth::user()->salesTeamMember()->with('team')->first();
    }

    public function index(Request $request)
    {
        $member = $this->member();
        $search = $request->get('search');
        $users = $this->counselorService->getManagedStudents($member, $search);

        return view('sales.students.index', compact('member', 'users', 'search'));
    }

    public function create()
    {
        return view('sales.students.create');
    }

    public function store(SalesStudentStoreRequest $request)
    {
        $member = $this->member();

        $profilePicture = $request->hasFile('profile_picture')
            ? MediaRepository::storeByRequest($request->file('profile_picture'), 'user/profile_picture', MediaTypeEnum::IMAGE)
            : MediaRepository::storeByPath(public_path('media/blank-user.png'), 'user/profile_picture', MediaTypeEnum::IMAGE);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'media_id' => $profilePicture?->id,
            'sales_team_id' => $member->sales_team_id,
            'sales_team_member_id' => $member->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return to_route('sales.students.index')->with('success', 'Student created successfully');
    }

    public function edit(User $user)
    {
        $member = $this->member();
        abort_unless($this->counselorService->studentBelongsToCounselor($user, $member), 403);

        return view('sales.students.edit', compact('user'));
    }

    public function update(SalesStudentUpdateRequest $request, User $user)
    {
        $member = $this->member();
        abort_unless($this->counselorService->studentBelongsToCounselor($user, $member), 403);

        if ($request->hasFile('profile_picture')) {
            $profilePicture = $user->profilePicture
                ? MediaRepository::updateByRequest($request->file('profile_picture'), $user->profilePicture, 'user/profile_picture', MediaTypeEnum::IMAGE)
                : MediaRepository::storeByRequest($request->file('profile_picture'), 'user/profile_picture', MediaTypeEnum::IMAGE);
            $user->media_id = $profilePicture?->id;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return to_route('sales.students.index')->with('success', 'Student updated successfully');
    }

    public function destroy(User $user)
    {
        $member = $this->member();
        abort_unless($this->counselorService->studentBelongsToCounselor($user, $member), 403);

        $user->delete();

        return to_route('sales.students.index')->with('success', 'Student removed successfully');
    }
}
