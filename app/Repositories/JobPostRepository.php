<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\JobPostStatusEnum;
use App\Models\JobPost;

class JobPostRepository extends Repository
{
    public static function model()
    {
        return JobPost::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        return self::create([
            'organization_id' => $organizationId,
            'job_category_id' => $request->job_category_id,
            'title' => $request->title,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary_range' => $request->salary_range,
            'application_deadline' => $request->application_deadline,
            'status' => $request->status ?? JobPostStatusEnum::OPEN->value,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, JobPost $jobPost)
    {
        return self::update($jobPost, [
            'job_category_id' => $request->job_category_id,
            'title' => $request->title,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary_range' => $request->salary_range,
            'application_deadline' => $request->application_deadline,
            'status' => $request->status ?? $jobPost->status,
            'is_active' => $request->has('is_active'),
        ]);
    }
}
