<?php

namespace App\Http\Controllers;

use App\Enum\CollegeGallerySectionEnum;
use App\Http\Resources\CollegeGalleryItemResource;
use App\Http\Resources\PartnerCollegeResource;
use App\Repositories\CollegeGalleryItemRepository;
use App\Repositories\PartnerCollegeRepository;
use Illuminate\Http\Request;

class CollegeGalleryController extends Controller
{
    public function sections()
    {
        $sections = collect(CollegeGallerySectionEnum::cases())->map(fn ($s) => [
            'value' => $s->value,
            'label' => $s->label(),
        ]);

        return $this->json('Gallery sections', ['sections' => $sections]);
    }

    public function colleges()
    {
        $colleges = PartnerCollegeRepository::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return $this->json('Partner colleges', [
            'colleges' => PartnerCollegeResource::collection($colleges),
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $collegeId = $request->college_id;
        $section = $request->section_type;
        $mediaType = $request->media_type;

        $query = CollegeGalleryItemRepository::query()
            ->with(['college.media', 'media'])
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('college', fn ($cq) => $cq->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when($collegeId, fn ($q) => $q->where('partner_college_id', $collegeId))
            ->when($section, fn ($q) => $q->where('section_type', $section))
            ->when($mediaType, function ($q) use ($mediaType) {
                $q->whereHas('media', fn ($mq) => $mq->where('type', $mediaType));
            });

        $items = $query->orderBy('sort_order')->latest('id')->paginate($request->per_page ?? 12);

        return $this->json('College gallery', [
            'items' => CollegeGalleryItemResource::collection($items),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function grouped(Request $request)
    {
        $search = $request->search;
        $collegeId = $request->college_id;
        $mediaType = $request->media_type;

        $query = CollegeGalleryItemRepository::query()
            ->with(['college.media', 'media'])
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('college', fn ($cq) => $cq->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when($collegeId, fn ($q) => $q->where('partner_college_id', $collegeId))
            ->when($mediaType, function ($q) use ($mediaType) {
                $q->whereHas('media', fn ($mq) => $mq->where('type', $mediaType));
            });

        $items = $query->orderBy('sort_order')->latest('id')->get();

        $grouped = collect(CollegeGallerySectionEnum::cases())->map(function ($section) use ($items) {
            $sectionItems = $items->where('section_type', $section);

            return [
                'section_type' => $section->value,
                'section_label' => $section->label(),
                'items' => CollegeGalleryItemResource::collection($sectionItems->values()),
                'count' => $sectionItems->count(),
            ];
        })->filter(fn ($g) => $g['count'] > 0)->values();

        return $this->json('College gallery grouped', [
            'sections' => $grouped,
            'total' => $items->count(),
        ]);
    }
}
