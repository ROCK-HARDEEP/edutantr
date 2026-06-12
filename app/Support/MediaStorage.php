<?php

namespace App\Support;

use App\Enum\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class MediaStorage
{
    public static function isR2Configured(): bool
    {
        return ! empty(config('filesystems.disks.r2.key'))
            && ! empty(config('filesystems.disks.r2.secret'))
            && ! empty(config('filesystems.disks.r2.bucket'))
            && ! empty(config('filesystems.disks.r2.endpoint'));
    }

    public static function usesR2(?MediaTypeEnum $type): bool
    {
        if (! $type || ! self::isR2Configured()) {
            return false;
        }

        return in_array($type, [MediaTypeEnum::VIDEO, MediaTypeEnum::IMAGE], true);
    }

    public static function diskName(?MediaTypeEnum $type = null): string
    {
        if (self::usesR2($type)) {
            return 'r2';
        }

        return config('filesystems.default', 'local');
    }

    public static function resolveDiskName(?Media $media = null, ?MediaTypeEnum $type = null): string
    {
        if ($media?->disk) {
            return $media->disk;
        }

        if ($media?->id) {
            return config('filesystems.default', 'local');
        }

        return self::diskName($type ?? $media?->type);
    }

    public static function disk(?Media $media = null, ?MediaTypeEnum $type = null): Filesystem
    {
        return Storage::disk(self::resolveDiskName($media, $type));
    }

    public static function url(?Media $media): ?string
    {
        if (! $media || empty($media->src)) {
            return null;
        }

        return self::disk($media)->url($media->src);
    }

    public static function urlOrDefault(?Media $media, string $default): string
    {
        if ($media && self::exists($media)) {
            return self::url($media) ?? $default;
        }

        return $default;
    }

    public static function exists(?Media $media): bool
    {
        if (! $media || empty($media->src)) {
            return false;
        }

        return self::disk($media)->exists($media->src);
    }

    public static function delete(?Media $media): bool
    {
        if (! self::exists($media)) {
            return false;
        }

        return self::disk($media)->delete($media->src);
    }
}
