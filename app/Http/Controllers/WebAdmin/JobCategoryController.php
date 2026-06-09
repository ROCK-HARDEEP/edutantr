<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCategoryStoreRequest;
use App\Models\JobCategory;
use App\Repositories\JobCategoryRepository;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = JobCategoryRepository::query()->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $categories = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('career.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('career.category.create');
    }

    public function store(JobCategoryStoreRequest $request)
    {
        JobCategoryRepository::storeByRequest($request);

        return to_route('job-category.index')->withSuccess('Job category created successfully.');
    }

    public function edit(JobCategory $job_category)
    {
        return view('career.category.edit', ['category' => $job_category]);
    }

    public function update(JobCategoryStoreRequest $request, JobCategory $job_category)
    {
        JobCategoryRepository::updateByRequest($request, $job_category);

        return to_route('job-category.index')->withSuccess('Job category updated successfully.');
    }

    public function destroy(JobCategory $job_category)
    {
        $job_category->delete();

        return to_route('job-category.index')->withSuccess('Job category deleted successfully.');
    }
}
