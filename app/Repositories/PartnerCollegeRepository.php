<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\PartnerCollege;

class PartnerCollegeRepository extends Repository
{
    public static function model()
    {
        return PartnerCollege::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        $picture = $request->hasFile('logo') ? MediaRepository::storeByRequest(
            $request->file('logo'),
            'partner-colleges',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'media_id' => $picture->id ?? null,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, PartnerCollege $college)
    {
        $picture = $request->hasFile('logo') ? MediaRepository::updateByRequest(
            $request->file('logo'),
            $college->media,
            'partner-colleges',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::update($college, [
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? $college->sort_order,
            'media_id' => $picture->id ?? $college->media_id,
            'is_active' => $request->has('is_active'),
        ]);
    }
}
