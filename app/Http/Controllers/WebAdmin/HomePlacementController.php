<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomePlacementStoreRequest;
use App\Models\HomePlacement;
use App\Repositories\HomePlacementRepository;
use Illuminate\Http\Request;

class HomePlacementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = HomePlacementRepository::query()->when($search, function ($query) use ($search) {
            $query->where('student_name', 'like', '%' . $search . '%')
                ->orWhere('company_name', 'like', '%' . $search . '%');
        });

        $placements = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('home-page.placements.index', ['placements' => $placements]);
    }

    public function create()
    {
        return view('home-page.placements.create');
    }

    public function store(HomePlacementStoreRequest $request)
    {
        HomePlacementRepository::storeByRequest($request);

        return to_route('home-placement.index')->withSuccess('Placement created successfully.');
    }

    public function edit(HomePlacement $home_placement)
    {
        return view('home-page.placements.edit', ['placement' => $home_placement]);
    }

    public function update(HomePlacementStoreRequest $request, HomePlacement $home_placement)
    {
        HomePlacementRepository::updateByRequest($request, $home_placement);

        return to_route('home-placement.index')->withSuccess('Placement updated successfully.');
    }

    public function destroy(HomePlacement $home_placement)
    {
        $home_placement->delete();

        return to_route('home-placement.index')->withSuccess('Placement deleted successfully.');
    }
}
