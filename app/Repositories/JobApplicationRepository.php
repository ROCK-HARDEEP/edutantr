<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\JobApplicationStatusEnum;
use App\Enum\MediaTypeEnum;
use App\Models\JobApplication;
use App\Models\JobPost;

class JobApplicationRepository extends Repository
{
    public static function model()
    {
        return JobApplication::class;
    }

    public static function apply($request, JobPost $jobPost, int $userId)
    {
        $resume = $request->hasFile('resume')
            ? MediaRepository::storeByRequest(
                $request->file('resume'),
                'job-resumes',
                MediaTypeEnum::DOCUMENT,
            )
            : null;

        return self::create([
            'job_post_id' => $jobPost->id,
            'user_id' => $userId,
            'resume_media_id' => $resume?->id,
            'cover_letter' => $request->cover_letter,
            'status' => JobApplicationStatusEnum::PENDING->value,
        ]);
    }

    public static function updateStatus($request, JobApplication $application)
    {
        return self::update($application, [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);
    }
}
