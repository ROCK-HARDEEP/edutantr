<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enum\MediaTypeEnum;
use App\Models\CollegeGalleryItem;
use Illuminate\Http\UploadedFile;

class CollegeGalleryItemRepository extends Repository
{
    public static function model()
    {
        return CollegeGalleryItem::class;
    }

    public static function storeByRequest($request)
    {
        $user = auth()->user();
        $organizationId = ($user && ($user->is_org || $user->hasRole('organization')))
            ? $user->organization_id
            : null;

        $media = $request->hasFile('media') ? self::storeMedia($request->file('media')) : null;

        return self::create([
            'organization_id' => $organizationId,
            'partner_college_id' => $request->partner_college_id ?: null,
            'title' => $request->title,
            'description' => $request->description,
            'section_type' => $request->section_type,
            'event_date' => $request->event_date ?: null,
            'sort_order' => $request->sort_order ?? 0,
            'media_id' => $media->id ?? null,
            'is_active' => $request->has('is_active'),
        ]);
    }

    public static function updateByRequest($request, CollegeGalleryItem $item)
    {
        $media = $request->hasFile('media') ? self::updateMedia($request->file('media'), $item->media) : null;

        return self::update($item, [
            'partner_college_id' => $request->partner_college_id ?: null,
            'title' => $request->title,
            'description' => $request->description,
            'section_type' => $request->section_type,
            'event_date' => $request->event_date ?: null,
            'sort_order' => $request->sort_order ?? $item->sort_order,
            'media_id' => $media->id ?? $item->media_id,
            'is_active' => $request->has('is_active'),
        ]);
    }

    private static function storeMedia(UploadedFile $file)
    {
        return MediaRepository::storeByRequest(
            $file,
            'college-gallery',
            self::getFileType($file),
        );
    }

    private static function updateMedia(UploadedFile $file, $existingMedia)
    {
        return MediaRepository::updateByRequest(
            $file,
            $existingMedia,
            'college-gallery',
            self::getFileType($file),
        );
    }

    private static function getFileType(UploadedFile $file): MediaTypeEnum
    {
        return match ($file->getClientMimeType()) {
            'video/mp4', 'video/mpeg', 'video/webm', 'video/quicktime' => MediaTypeEnum::VIDEO,
            default => MediaTypeEnum::IMAGE,
        };
    }
}
