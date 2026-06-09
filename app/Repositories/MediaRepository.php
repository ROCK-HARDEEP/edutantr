<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Media;
use App\Support\MediaStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{

    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Media::class;
    }

    public static function storeByRequest(UploadedFile $file, $path, $type = null): Media
    {
        $diskName = MediaStorage::diskName($type);
        $src = Storage::disk($diskName)->put('/' . trim($path, '/'), $file, 'public');

        return self::create([
            'extension' => $file->extension(),
            'src' => $src,
            'path' => $path,
            'type' => $type,
            'disk' => $diskName,
        ]);
    }

    // this for local path file update

    public static function storeByPath($filePath, $path, $type = null): Media
    {
        $diskName = MediaStorage::diskName($type);
        $fileContents = file_get_contents($filePath);
        $fileName = basename($filePath);

        $src = Storage::disk($diskName)->put('/' . trim($path, '/') . '/' . $fileName, $fileContents, 'public');

        return self::create([
            'extension' => pathinfo($filePath, PATHINFO_EXTENSION),
            'src' => $src,
            'path' => $path,
            'type' => $type,
            'disk' => $diskName,
        ]);
    }

    public static function updateByRequest(UploadedFile $file, Media $media, $path, $type = null): Media
    {
        $diskName = MediaStorage::diskName($type);
        $src = Storage::disk($diskName)->put('/' . trim($path, '/'), $file, 'public');

        MediaStorage::delete($media);

        self::update($media, [
            'extension' => $file->extension(),
            'src' => $src,
            'path' => $path,
            'type' => $type,
            'disk' => $diskName,
        ]);

        return $media;
    }

    public static function updateOrCreateByRequest(UploadedFile $file, $path, $media = null, $type = null): Media
    {
        $diskName = MediaStorage::diskName($type);
        $src = Storage::disk($diskName)->put('/' . trim($path, '/'), $file, 'public');

        if ($media) {
            MediaStorage::delete($media);
        }

        $media = self::query()->updateOrCreate([
            'id' => $media?->id ?? 0
        ], [
            'extension' => $file->extension(),
            'src' => $src,
            'path' => $path,
            'type' => $type,
            'disk' => $diskName,
        ]);

        return $media;
    }
}
