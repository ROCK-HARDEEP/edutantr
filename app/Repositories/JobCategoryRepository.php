<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\JobCategory;
use Illuminate\Support\Str;

class JobCategoryRepository extends Repository
{
    public static function model()
    {
        return JobCategory::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        $slug = self::uniqueSlug($request->name);

        return self::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'slug' => $slug,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, JobCategory $category)
    {
        $slug = $category->slug;

        if ($request->name !== $category->name) {
            $slug = self::uniqueSlug($request->name, $category->id);
        }

        return self::update($category, [
            'name' => $request->name,
            'slug' => $slug,
            'sort_order' => $request->sort_order ?? $category->sort_order,
            'is_active' => $request->has('is_active'),
        ]);
    }

    protected static function uniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (
            self::query()
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
