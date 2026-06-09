<?php

namespace App\Http\Controllers\WebAdmin;

use App\Enum\JobApplicationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use App\Repositories\JobApplicationRepository;
use App\Repositories\JobPostRepository;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->search ? strtolower($request->search) : null;
        $status = $request->status;
        $jobPostId = $request->job_post_id;

        $query = JobApplicationRepository::query()
            ->when($user->is_org || $user->hasRole('organization'), function ($query) use ($user) {
                $query->whereHas('jobPost', fn ($q) => $q->where('organization_id', $user->organization_id));
            })
            ->with(['user.profilePicture', 'jobPost.category', 'resume'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('jobPost', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($jobPostId, fn ($q) => $q->where('job_post_id', $jobPostId));

        $applications = $query->latest('id')->paginate(15)->withQueryString();
        $jobPosts = JobPostRepository::query()->orderBy('title')->get(['id', 'title']);
        $statuses = JobApplicationStatusEnum::cases();

        $stats = [
            'total' => JobApplicationRepository::query()->count(),
            'pending' => JobApplicationRepository::query()->where('status', JobApplicationStatusEnum::PENDING->value)->count(),
            'shortlisted' => JobApplicationRepository::query()->where('status', JobApplicationStatusEnum::SHORTLISTED->value)->count(),
            'hired' => JobApplicationRepository::query()->where('status', JobApplicationStatusEnum::HIRED->value)->count(),
        ];

        return view('career.application.index', [
            'applications' => $applications,
            'jobPosts' => $jobPosts,
            'statuses' => $statuses,
            'stats' => $stats,
        ]);
    }

    public function show(JobApplication $job_application)
    {
        $job_application->load(['user.profilePicture', 'jobPost.category', 'resume']);

        return view('career.application.show', [
            'application' => $job_application,
            'statuses' => JobApplicationStatusEnum::cases(),
        ]);
    }

    public function update(JobApplicationUpdateRequest $request, JobApplication $job_application)
    {
        JobApplicationRepository::updateStatus($request, $job_application);

        return to_route('job-application.show', $job_application)->withSuccess('Application status updated successfully.');
    }
}
