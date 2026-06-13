<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollegeGalleryItemResource;
use App\Http\Resources\HomePlacementResource;
use App\Http\Resources\HomeProgramResource;
use App\Http\Resources\HomeStatisticResource;
use App\Http\Resources\PartnerCollegeResource;
use App\Http\Resources\PartnerLogoResource;
use App\Enum\MediaTypeEnum;
use App\Repositories\CollegeGalleryItemRepository;
use App\Repositories\HomePlacementRepository;
use App\Repositories\HomeProgramRepository;
use App\Repositories\HomeStatisticRepository;
use App\Repositories\PartnerCollegeRepository;
use App\Repositories\PartnerLogoRepository;

class HomePageController extends Controller
{
    public function programs()
    {
        $programs = HomeProgramRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return $this->json('home programs', ['programs' => HomeProgramResource::collection($programs)], 200);
    }

    public function statistics()
    {
        $statistics = HomeStatisticRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return $this->json('home statistics', ['statistics' => HomeStatisticResource::collection($statistics)], 200);
    }

    public function partnerColleges()
    {
        $colleges = PartnerCollegeRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return $this->json('partner colleges', ['colleges' => PartnerCollegeResource::collection($colleges)], 200);
    }

    public function partnerCollegeGallery()
    {
        $items = CollegeGalleryItemRepository::query()
            ->with(['college.media', 'media'])
            ->where('is_active', true)
            ->whereHas('media', fn ($query) => $query->where('type', MediaTypeEnum::IMAGE))
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(30)
            ->get();

        return $this->json('partner college gallery', [
            'slides' => CollegeGalleryItemResource::collection($items),
        ], 200);
    }

    public function placements()
    {
        $placements = HomePlacementRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return $this->json('home placements', ['placements' => HomePlacementResource::collection($placements)], 200);
    }

    public function partnerLogos()
    {
        $logos = PartnerLogoRepository::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(5)
            ->get();

        return $this->json('partner logos', ['logos' => PartnerLogoResource::collection($logos)], 200);
    }
}
