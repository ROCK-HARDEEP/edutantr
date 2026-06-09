<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\PartnerLogo;

class PartnerLogoRepository extends Repository
{
    public static function model()
    {
        return PartnerLogo::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        $picture = $request->hasFile('logo') ? MediaRepository::storeByRequest(
            $request->file('logo'),
            'partner-logos',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'partner_type' => $request->partner_type,
            'website_url' => $request->website_url,
            'sort_order' => $request->sort_order ?? 0,
            'media_id' => $picture->id ?? null,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, PartnerLogo $logo)
    {
        $picture = $request->hasFile('logo') ? MediaRepository::updateByRequest(
            $request->file('logo'),
            $logo->media,
            'partner-logos',
            MediaTypeEnum::IMAGE,
        ) : null;

        return self::update($logo, [
            'name' => $request->name,
            'partner_type' => $request->partner_type,
            'website_url' => $request->website_url,
            'sort_order' => $request->sort_order ?? $logo->sort_order,
            'media_id' => $picture->id ?? $logo->media_id,
            'is_active' => $request->has('is_active'),
        ]);
    }
}
