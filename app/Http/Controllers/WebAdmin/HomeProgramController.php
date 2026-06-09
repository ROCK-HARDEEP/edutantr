<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeProgramStoreRequest;
use App\Models\HomeProgram;
use App\Repositories\HomeProgramRepository;
use Illuminate\Http\Request;

class HomeProgramController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? strtolower($request->search) : null;
        $query = HomeProgramRepository::query()->when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        });

        $programs = $query->withTrashed()->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('home-page.programs.index', ['programs' => $programs]);
    }

    public function create()
    {
        return view('home-page.programs.create');
    }

    public function store(HomeProgramStoreRequest $request)
    {
        HomeProgramRepository::storeByRequest($request);

        return to_route('home-program.index')->withSuccess('Program created successfully.');
    }

    public function edit(HomeProgram $home_program)
    {
        return view('home-page.programs.edit', ['program' => $home_program]);
    }

    public function update(HomeProgramStoreRequest $request, HomeProgram $home_program)
    {
        HomeProgramRepository::updateByRequest($request, $home_program);

        return to_route('home-program.index')->withSuccess('Program updated successfully.');
    }

    public function destroy(HomeProgram $home_program)
    {
        $home_program->delete();

        return to_route('home-program.index')->withSuccess('Program deleted successfully.');
    }
}
