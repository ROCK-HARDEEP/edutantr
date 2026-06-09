<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\HomeStatistic;

class HomeStatisticRepository extends Repository
{
    public static function model()
    {
        return HomeStatistic::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        return self::create([
            'organization_id' => $organizationId,
            'label' => $request->label,
            'value' => $request->value,
            'suffix' => $request->suffix,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, HomeStatistic $statistic)
    {
        return self::update($statistic, [
            'label' => $request->label,
            'value' => $request->value,
            'suffix' => $request->suffix,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? $statistic->sort_order,
            'is_active' => $request->has('is_active'),
        ]);
    }
}
