<?php

namespace App\Http\Controllers\WebAdmin;

use App\Enum\CollegeGallerySectionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollegeGalleryItemStoreRequest;
use App\Models\CollegeGalleryItem;
use App\Repositories\CollegeGalleryItemRepository;
use App\Repositories\PartnerCollegeRepository;
use Illuminate\Http\Request;

class CollegeGalleryItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $section = $request->section_type;
        $collegeId = $request->college_id;

        $query = CollegeGalleryItemRepository::query()
            ->with(['college', 'media'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('college', fn ($cq) => $cq->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when($section, fn ($q) => $q->where('section_type', $section))
            ->when($collegeId, fn ($q) => $q->where('partner_college_id', $collegeId));

        $items = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();
        $colleges = PartnerCollegeRepository::query()->where('is_active', true)->orderBy('name')->get();

        return view('college-gallery.index', [
            'items' => $items,
            'colleges' => $colleges,
            'sections' => CollegeGallerySectionEnum::cases(),
        ]);
    }

    public function create()
    {
        $colleges = PartnerCollegeRepository::query()->orderBy('name')->get();

        return view('college-gallery.create', [
            'colleges' => $colleges,
            'sections' => CollegeGallerySectionEnum::cases(),
        ]);
    }

    public function store(CollegeGalleryItemStoreRequest $request)
    {
        CollegeGalleryItemRepository::storeByRequest($request);

        return to_route('college-gallery.index')->withSuccess('Gallery item created successfully.');
    }

    public function edit(CollegeGalleryItem $college_gallery)
    {
        $colleges = PartnerCollegeRepository::query()->orderBy('name')->get();

        return view('college-gallery.edit', [
            'item' => $college_gallery,
            'colleges' => $colleges,
            'sections' => CollegeGallerySectionEnum::cases(),
        ]);
    }

    public function update(CollegeGalleryItemStoreRequest $request, CollegeGalleryItem $college_gallery)
    {
        CollegeGalleryItemRepository::updateByRequest($request, $college_gallery);

        return to_route('college-gallery.index')->withSuccess('Gallery item updated successfully.');
    }

    public function destroy(CollegeGalleryItem $college_gallery)
    {
        $college_gallery->delete();

        return to_route('college-gallery.index')->withSuccess('Gallery item deleted successfully.');
    }
}
