<?php

namespace App\Services;

use App\Enum\MediaTypeEnum;
use App\Models\Media;
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

    public static function uploadVideo(UploadedFile $file, ?string $displayName = null): array
    {
        self::ensureConfigured();

        if (! self::isVideoMime($file->getMimeType())) {
            throw new RuntimeException('Only video files are allowed.');
        }

        $disk = Storage::disk('r2');
        $prefix = self::videoPrefix();
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'mp4');
        $fileName = self::buildVideoFileName($displayName ?: $file->getClientOriginalName(), $extension);
        $fileName = self::ensureUniqueFileName($disk, $prefix, $fileName);
        $storedPath = trim($prefix, '/') . '/' . $fileName;

        $uploadedPath = $disk->putFileAs(trim($prefix, '/'), $file, $fileName, 'public');

        if (! $uploadedPath) {
            throw new RuntimeException('Failed to upload video.');
        }

        MediaRepository::create([
            'extension' => $extension,
            'src' => $storedPath,
            'path' => $prefix,
            'type' => MediaTypeEnum::VIDEO,
            'disk' => 'r2',
        ]);

        return self::formatVideoItem($disk, $storedPath);
    }

    public static function renameVideo(string $path, string $newName): array
    {
        self::ensureConfigured();

        $path = self::normalizePath($path);

        if (! self::isVideoPath($path)) {
            throw new RuntimeException('Invalid video path.');
        }

        $disk = Storage::disk('r2');

        if (! $disk->exists($path)) {
            throw new RuntimeException('Video not found.');
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $newFileName = self::buildVideoFileName($newName, $extension);
        $directory = dirname($path);
        $newPath = ($directory === '.' ? self::videoPrefix() : $directory) . '/' . $newFileName;
        $newPath = self::normalizePath($newPath);

        if ($newPath !== $path && $disk->exists($newPath)) {
            throw new RuntimeException('A video with this name already exists.');
        }

        if ($newPath !== $path && ! $disk->move($path, $newPath)) {
            throw new RuntimeException('Failed to rename video.');
        }

        Media::query()
            ->where('src', $path)
            ->where('disk', 'r2')
            ->update(['src' => $newPath, 'extension' => $extension]);

        return self::formatVideoItem($disk, $newPath);
    }

    public static function deleteVideo(string $path): void
    {
        self::ensureConfigured();

        $path = self::normalizePath($path);

        if (! self::isVideoPath($path)) {
            throw new RuntimeException('Invalid video path.');
        }

        $disk = Storage::disk('r2');

        if (! $disk->exists($path)) {
            throw new RuntimeException('Video not found.');
        }

        if (! $disk->delete($path)) {
            throw new RuntimeException('Failed to delete video.');
        }

        Media::query()
            ->where('src', $path)
            ->where('disk', 'r2')
            ->delete();
    }

    private static function normalizePath(string $path): string
    {
        $path = str_replace('\\', '/', trim($path));
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            throw new RuntimeException('Invalid video path.');
        }

        return $path;
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

    private static function buildVideoFileName(string $input, string $extension): string
    {
        $input = trim(str_replace('\\', '/', $input));
        $input = basename($input);

        $providedExtension = strtolower(pathinfo($input, PATHINFO_EXTENSION));

        if ($providedExtension && in_array($providedExtension, self::VIDEO_EXTENSIONS, true)) {
            $baseName = pathinfo($input, PATHINFO_FILENAME);
            $extension = $providedExtension;
        } else {
            $baseName = pathinfo($input, PATHINFO_FILENAME) ?: $input;
        }

        $baseName = self::sanitizeBaseName($baseName);

        if ($baseName === '') {
            $baseName = 'video';
        }

        return $baseName . '.' . strtolower($extension);
    }

    private static function sanitizeBaseName(string $name): string
    {
        $name = preg_replace('/[<>:"\/\\\\|?*#]+/', '-', $name) ?? $name;
        $name = preg_replace('/\s+/', ' ', $name) ?? $name;

        return mb_substr(trim($name, " .-\t\n\r"), 0, 200);
    }

    private static function ensureUniqueFileName($disk, string $prefix, string $fileName): string
    {
        $path = trim($prefix, '/') . '/' . $fileName;

        if (! $disk->exists($path)) {
            return $fileName;
        }

        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $counter = 1;

        do {
            $candidate = $baseName . ' (' . $counter . ').' . $extension;
            $path = trim($prefix, '/') . '/' . $candidate;
            $counter++;
        } while ($disk->exists($path) && $counter < 1000);

        return $candidate;
    }
}
