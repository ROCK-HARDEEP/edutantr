<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\Course;
use App\Models\CourseProject;
use App\Support\MediaStorage;
use Illuminate\Http\Request;

class CourseProjectRepository extends Repository
{
    public static function model()
    {
        return CourseProject::class;
    }

    public static function syncFromRequest(Course $course, Request $request): void
    {
        $title = $request->input('project_title');
        $description = $request->input('project_description');
        $hasPdfUpload = $request->hasFile('project_pdf');
        $removePdf = $request->boolean('project_remove_pdf');

        $plainDescription = is_string($description)
            ? trim(strip_tags($description))
            : '';

        $hasContent = filled($title) || $plainDescription !== '' || $hasPdfUpload;
        $project = self::query()->where('course_id', $course->id)->first();

        if (! $hasContent) {
            if ($project) {
                self::deleteProject($project);
            }

            return;
        }

        $media = $project?->media;

        if ($hasPdfUpload) {
            $media = $media
                ? MediaRepository::updateByRequest(
                    $request->file('project_pdf'),
                    $media,
                    'course/project',
                    MediaTypeEnum::DOCUMENT,
                )
                : MediaRepository::storeByRequest(
                    $request->file('project_pdf'),
                    'course/project',
                    MediaTypeEnum::DOCUMENT,
                );
        } elseif ($removePdf && $media) {
            MediaStorage::delete($media);
            $media->delete();
            $media = null;
        }

        self::query()->updateOrCreate(
            ['course_id' => $course->id],
            [
                'title' => $title ?: 'Course Project',
                'description' => $description,
                'media_id' => $media?->id,
            ],
        );
    }

    public static function deleteProject(CourseProject $project): void
    {
        if ($project->media) {
            MediaStorage::delete($project->media);
            $project->media->delete();
        }

        $project->delete();
    }
}
