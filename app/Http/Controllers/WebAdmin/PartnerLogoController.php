<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerLogoStoreRequest;
use App\Models\PartnerLogo;
use App\Repositories\PartnerLogoRepository;
use Illuminate\Http\Request;

class PartnerLogoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = PartnerLogoRepository::query()->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $logos = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('home-page.logos.index', ['logos' => $logos]);
    }

    public function create()
    {
        return view('home-page.logos.create');
    }

    public function store(PartnerLogoStoreRequest $request)
    {
        PartnerLogoRepository::storeByRequest($request);

        return to_route('partner-logo.index')->withSuccess('Partner logo created successfully.');
    }

    public function edit(PartnerLogo $partner_logo)
    {
        return view('home-page.logos.edit', ['logo' => $partner_logo]);
    }

    public function update(PartnerLogoStoreRequest $request, PartnerLogo $partner_logo)
    {
        PartnerLogoRepository::updateByRequest($request, $partner_logo);

        return to_route('partner-logo.index')->withSuccess('Partner logo updated successfully.');
    }

    public function destroy(PartnerLogo $partner_logo)
    {
        $partner_logo->delete();

        return to_route('partner-logo.index')->withSuccess('Partner logo deleted successfully.');
    }
}
