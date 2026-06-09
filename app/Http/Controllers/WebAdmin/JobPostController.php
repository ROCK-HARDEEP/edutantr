<?php

namespace App\Http\Controllers\WebAdmin;

use App\Enum\JobPostStatusEnum;
use App\Enum\JobTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostStoreRequest;
use App\Models\JobPost;
use App\Repositories\JobCategoryRepository;
use App\Repositories\JobPostRepository;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $status = $request->status;
        $categoryId = $request->category_id;

        $query = JobPostRepository::query()
            ->with(['category'])
            ->withCount('applications')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('company_name', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($categoryId, fn ($q) => $q->where('job_category_id', $categoryId));

        $jobPosts = $query->withTrashed()->latest('id')->paginate(15)->withQueryString();
        $categories = JobCategoryRepository::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('career.job-post.index', [
            'jobPosts' => $jobPosts,
            'categories' => $categories,
            'statuses' => JobPostStatusEnum::cases(),
            'jobTypes' => JobTypeEnum::cases(),
        ]);
    }

    public function create()
    {
        $categories = JobCategoryRepository::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('career.job-post.create', [
            'categories' => $categories,
            'jobTypes' => JobTypeEnum::cases(),
            'statuses' => JobPostStatusEnum::cases(),
        ]);
    }

    public function store(JobPostStoreRequest $request)
    {
        JobPostRepository::storeByRequest($request);

        return to_route('job-post.index')->withSuccess('Job post created successfully.');
    }

    public function edit(JobPost $job_post)
    {
        $categories = JobCategoryRepository::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('career.job-post.edit', [
            'jobPost' => $job_post,
            'categories' => $categories,
            'jobTypes' => JobTypeEnum::cases(),
            'statuses' => JobPostStatusEnum::cases(),
        ]);
    }

    public function update(JobPostStoreRequest $request, JobPost $job_post)
    {
        JobPostRepository::updateByRequest($request, $job_post);

        return to_route('job-post.index')->withSuccess('Job post updated successfully.');
    }

    public function destroy(JobPost $job_post)
    {
        $job_post->delete();

        return to_route('job-post.index')->withSuccess('Job post deleted successfully.');
    }

    public function close(JobPost $job_post)
    {
        $job_post->update([
            'status' => JobPostStatusEnum::CLOSED->value,
            'is_active' => false,
        ]);

        return to_route('job-post.index')->withSuccess('Job opening closed successfully.');
    }
}
