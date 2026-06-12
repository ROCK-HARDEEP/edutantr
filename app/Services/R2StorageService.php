<?php

namespace App\Services;

use App\Enum\MediaTypeEnum;
use App\Repositories\MediaRepository;
use App\Support\MediaStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class R2StorageService
{
    private const VIDEO_EXTENSIONS = ['mp4', 'mpeg', 'mpg', 'webm', 'mov', 'avi', 'mkv', 'm4v'];

    public static function ensureConfigured(): void
    {
        if (! MediaStorage::isR2Configured()) {
            throw new RuntimeException('Cloudflare R2 storage is not configured. Please set R2 credentials in your environment.');
        }
    }

    public static function videoPrefix(): string
    {
        return trim(env('R2_VIDEO_PREFIX', 'videos'), '/');
    }

    public static function listVideos(): array
    {
        self::ensureConfigured();

        $disk = Storage::disk('r2');
        $paths = $disk->allFiles();

        $videos = [];

        foreach ($paths as $path) {
            if (! self::isVideoPath($path)) {
                continue;
            }

            $videos[] = self::formatVideoItem($disk, $path);
        }

        usort($videos, fn (array $a, array $b) => $b['last_modified'] <=> $a['last_modified']);

        return $videos;
    }

    public static function uploadVideo(UploadedFile $file): array
    {
        self::ensureConfigured();

        if (! self::isVideoMime($file->getMimeType())) {
            throw new RuntimeException('Only video files are allowed.');
        }

        $path = self::videoPrefix();
        $media = MediaRepository::storeByRequest($file, $path, MediaTypeEnum::VIDEO);

        $disk = Storage::disk('r2');

        return self::formatVideoItem($disk, $media->src);
    }

    private static function formatVideoItem($disk, string $path): array
    {
        $size = $disk->size($path);
        $lastModified = $disk->lastModified($path);

        return [
            'path' => $path,
            'name' => basename($path),
            'url' => $disk->url($path),
            'size' => $size,
            'size_human' => self::formatBytes($size),
            'last_modified' => $lastModified,
            'last_modified_human' => date('M d, Y H:i', $lastModified),
        ];
    }

    private static function isVideoPath(string $path): bool
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, self::VIDEO_EXTENSIONS, true);
    }

    private static function isVideoMime(?string $mime): bool
    {
        if (! $mime) {
            return false;
        }

        return str_starts_with($mime, 'video/');
    }

    private static function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' KB';
        }

        if ($bytes < 1073741824) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        return round($bytes / 1073741824, 2) . ' GB';
    }
}
