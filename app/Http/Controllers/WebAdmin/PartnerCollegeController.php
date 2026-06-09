<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCollegeStoreRequest;
use App\Models\PartnerCollege;
use App\Repositories\PartnerCollegeRepository;
use Illuminate\Http\Request;

class PartnerCollegeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = PartnerCollegeRepository::query()->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $colleges = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('home-page.colleges.index', ['colleges' => $colleges]);
    }

    public function create()
    {
        return view('home-page.colleges.create');
    }

    public function store(PartnerCollegeStoreRequest $request)
    {
        PartnerCollegeRepository::storeByRequest($request);

        return to_route('partner-college.index')->withSuccess('Partner college created successfully.');
    }

    public function edit(PartnerCollege $partner_college)
    {
        return view('home-page.colleges.edit', ['college' => $partner_college]);
    }

    public function update(PartnerCollegeStoreRequest $request, PartnerCollege $partner_college)
    {
        PartnerCollegeRepository::updateByRequest($request, $partner_college);

        return to_route('partner-college.index')->withSuccess('Partner college updated successfully.');
    }

    public function destroy(PartnerCollege $partner_college)
    {
        $partner_college->delete();

        return to_route('partner-college.index')->withSuccess('Partner college deleted successfully.');
    }
}
