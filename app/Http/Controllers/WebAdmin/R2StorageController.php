<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Services\R2StorageService;
use Illuminate\Http\Request;
use RuntimeException;

class R2StorageController extends Controller
{
    public function index()
    {
        try {
            $videos = R2StorageService::listVideos();

            return $this->json('Videos fetched successfully', [
                'videos' => $videos,
                'configured' => true,
            ]);
        } catch (RuntimeException $exception) {
            return $this->json($exception->getMessage(), [
                'videos' => [],
                'configured' => false,
            ], 422);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'video' => ['required', 'file', 'mimetypes:video/mp4,video/mpeg,video/webm,video/quicktime,video/x-msvideo,video/x-matroska', 'max:512000'],
        ]);

        try {
            $video = R2StorageService::uploadVideo($request->file('video'));

            return $this->json('Video uploaded successfully', [
                'video' => $video,
            ], 201);
        } catch (RuntimeException $exception) {
            return $this->json($exception->getMessage(), [], 422);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => ['required', 'string', 'max:1024'],
        ]);

        try {
            R2StorageService::deleteVideo($request->input('path'));

            return $this->json('Video deleted successfully');
        } catch (RuntimeException $exception) {
            return $this->json($exception->getMessage(), [], 422);
        }
    }
}
