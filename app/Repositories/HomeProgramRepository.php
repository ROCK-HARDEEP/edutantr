<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\HomeProgram;

class HomeProgramRepository extends Repository
{
    public static function model()
    {
        return HomeProgram::class;
    }

    public static function storeByRequest($request)
    {
        self::mergeOrganizationId($request);

        $picture = $request->hasFile('image') ? MediaRepository::storeByRequest(
            $request->file('image'),
            'home-programs',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::create([
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'program_type' => $request->program_type,
            'cta_label' => $request->cta_label,
            'cta_url' => $request->cta_url,
            'sort_order' => $request->sort_order ?? 0,
            'media_id' => $picture->id ?? null,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, HomeProgram $program)
    {
        $picture = $request->hasFile('image') ? MediaRepository::updateByRequest(
            $request->file('image'),
            $program->media,
            'home-programs',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::update($program, [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'program_type' => $request->program_type,
            'cta_label' => $request->cta_label,
            'cta_url' => $request->cta_url,
            'sort_order' => $request->sort_order ?? $program->sort_order,
            'media_id' => $picture->id ?? $program->media_id,
            'is_active' => $request->has('is_active'),
        ]);
    }

    protected static function mergeOrganizationId($request): void
    {
        $user = auth()->user();
        if ($user && ($user->is_org || $user->hasRole('organization'))) {
            $request->merge(['organization_id' => $user->organization_id]);
        } else {
            $request->merge(['organization_id' => null]);
        }
    }
}
