<?php

namespace App\Http\Controllers\WebAdmin;

use App\Enum\MediaTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCertificateStoreRequest;
use App\Models\StudentCertificate;
use App\Models\User;
use App\Repositories\MediaRepository;
use App\Support\MediaStorage;

class StudentCertificateController extends Controller
{
    public function index(User $user)
    {
        $certificates = $user->studentCertificates()
            ->with('media')
            ->latest('id')
            ->get();

        return response()->json([
            'certificates' => $certificates->map(fn (StudentCertificate $certificate) => [
                'id' => $certificate->id,
                'title' => $certificate->title,
                'file_url' => $certificate->file_url,
                'extension' => $certificate->media?->extension,
                'uploaded_at' => $certificate->created_at?->format('M d, Y'),
            ]),
        ]);
    }

    public function store(StudentCertificateStoreRequest $request, User $user)
    {
        $media = MediaRepository::storeByRequest(
            $request->file('certificate'),
            'student/certificates',
            MediaTypeEnum::DOCUMENT,
        );

        StudentCertificate::create([
            'user_id' => $user->id,
            'media_id' => $media->id,
            'title' => $request->title,
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', __('Certificate uploaded successfully'));
    }

    public function destroy(StudentCertificate $studentCertificate)
    {
        if ($studentCertificate->media) {
            MediaStorage::delete($studentCertificate->media);
            $studentCertificate->media->delete();
        }

        $studentCertificate->delete();

        return back()->with('success', __('Certificate deleted successfully'));
    }
}
