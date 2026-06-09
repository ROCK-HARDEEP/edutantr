<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\HomePlacement;

class HomePlacementRepository extends Repository
{
    public static function model()
    {
        return HomePlacement::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        $picture = $request->hasFile('image') ? MediaRepository::storeByRequest(
            $request->file('image'),
            'home-placements',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::create([
            'organization_id' => $organizationId,
            'student_name' => $request->student_name,
            'company_name' => $request->company_name,
            'role' => $request->role,
            'sort_order' => $request->sort_order ?? 0,
            'media_id' => $picture->id ?? null,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, HomePlacement $placement)
    {
        $picture = $request->hasFile('image') ? MediaRepository::updateByRequest(
            $request->file('image'),
            $placement->media,
            'home-placements',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::update($placement, [
            'student_name' => $request->student_name,
            'company_name' => $request->company_name,
            'role' => $request->role,
            'sort_order' => $request->sort_order ?? $placement->sort_order,
            'media_id' => $picture->id ?? $placement->media_id,
            'is_active' => $request->has('is_active'),
        ]);
    }
}
