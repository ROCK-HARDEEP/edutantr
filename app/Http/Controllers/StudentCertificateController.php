<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCertificateResource;
use App\Models\StudentCertificate;
use Illuminate\Support\Facades\Auth;

class StudentCertificateController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('api')->id();

        $certificates = StudentCertificate::query()
            ->where('user_id', $userId)
            ->with('media')
            ->latest('id')
            ->get();

        return $this->json('Student certificates found', [
            'certificates' => StudentCertificateResource::collection($certificates)->resolve(),
        ]);
    }

    public function show(StudentCertificate $studentCertificate)
    {
        if ($studentCertificate->user_id !== Auth::guard('api')->id()) {
            return $this->json('Unauthorized', null, 403);
        }

        if (! $studentCertificate->media) {
            return $this->json('Certificate file not found', null, 404);
        }

        $url = $studentCertificate->file_url;

        if (! $url) {
            return $this->json('Certificate file not found', null, 404);
        }

        return $this->json('Certificate download url', [
            'url' => $url,
            'title' => $studentCertificate->title,
        ]);
    }
}
