<?php

namespace App\Http\Controllers;

use App\Enum\JobPostStatusEnum;
use App\Http\Requests\JobApplicationStoreRequest;
use App\Http\Resources\JobApplicationResource;
use App\Http\Resources\JobCategoryResource;
use App\Http\Resources\JobPostResource;
use App\Models\JobPost;
use App\Repositories\JobApplicationRepository;
use App\Repositories\JobCategoryRepository;
use App\Repositories\JobPostRepository;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function categories()
    {
        $categories = JobCategoryRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $this->json('Job categories', [
            'categories' => JobCategoryResource::collection($categories),
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category_id;
        $jobType = $request->job_type;

        $query = JobPostRepository::query()
            ->with('category')
            ->where('is_active', true)
            ->where('status', JobPostStatusEnum::OPEN->value)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', now()->toDateString());
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('company_name', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->when($categoryId, fn ($q) => $q->where('job_category_id', $categoryId))
            ->when($jobType, fn ($q) => $q->where('job_type', $jobType));

        $jobs = $query->latest('id')->paginate($request->per_page ?? 12);

        return $this->json('Job openings', [
            'jobs' => JobPostResource::collection($jobs),
            'pagination' => [
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total(),
            ],
        ]);
    }

    public function show(JobPost $job)
    {
        if (!$job->is_active || !$job->isOpen()) {
            return $this->json('Job opening is not available', [], 404);
        }

        $job->load('category');

        $hasApplied = false;
        if (auth('api')->check()) {
            $hasApplied = JobApplicationRepository::query()
                ->where('job_post_id', $job->id)
                ->where('user_id', auth('api')->id())
                ->exists();
        }

        return $this->json('Job details', [
            'job' => new JobPostResource($job),
            'has_applied' => $hasApplied,
        ]);
    }

    public function apply(JobApplicationStoreRequest $request, JobPost $job)
    {
        if (!$job->isOpen()) {
            return $this->json('This job opening is closed', [], 422);
        }

        $userId = auth('api')->id();

        $existing = JobApplicationRepository::query()
            ->where('job_post_id', $job->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            return $this->json('You have already applied for this job', [], 422);
        }

        $application = JobApplicationRepository::apply($request, $job, $userId);
        $application->load(['jobPost.category', 'resume']);

        return $this->json('Application submitted successfully', [
            'application' => new JobApplicationResource($application),
        ], 201);
    }

    public function myApplications()
    {
        $applications = JobApplicationRepository::query()
            ->with(['jobPost.category', 'resume'])
            ->where('user_id', auth('api')->id())
            ->latest('id')
            ->get();

        return $this->json('My job applications', [
            'applications' => JobApplicationResource::collection($applications),
        ]);
    }
}
