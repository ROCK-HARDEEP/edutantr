<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeStatisticStoreRequest;
use App\Models\HomeStatistic;
use App\Repositories\HomeStatisticRepository;
use Illuminate\Http\Request;

class HomeStatisticController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = HomeStatisticRepository::query()->when($search, function ($query) use ($search) {
            $query->where('label', 'like', '%' . $search . '%');
        });

        $statistics = $query->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('home-page.statistics.index', ['statistics' => $statistics]);
    }

    public function create()
    {
        return view('home-page.statistics.create');
    }

    public function store(HomeStatisticStoreRequest $request)
    {
        HomeStatisticRepository::storeByRequest($request);

        return to_route('home-statistic.index')->withSuccess('Statistic created successfully.');
    }

    public function edit(HomeStatistic $home_statistic)
    {
        return view('home-page.statistics.edit', ['statistic' => $home_statistic]);
    }

    public function update(HomeStatisticStoreRequest $request, HomeStatistic $home_statistic)
    {
        HomeStatisticRepository::updateByRequest($request, $home_statistic);

        return to_route('home-statistic.index')->withSuccess('Statistic updated successfully.');
    }

    public function destroy(HomeStatistic $home_statistic)
    {
        $home_statistic->delete();

        return to_route('home-statistic.index')->withSuccess('Statistic deleted successfully.');
    }
}
