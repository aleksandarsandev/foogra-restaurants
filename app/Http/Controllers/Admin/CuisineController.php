<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    public function index()
    {
        $cuisines = Cuisine::withCount('restaurants')->orderBy('name')->get();
        return view('admin.cuisines.index', compact('cuisines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:cuisines,name',
        ]);

        Cuisine::create($data);

        return redirect()->route('admin.cuisines.index')->with('success', 'Cuisine created.');
    }

    public function destroy(Cuisine $cuisine)
    {
        $cuisine->restaurants()->detach();
        $cuisine->delete();

        return redirect()->route('admin.cuisines.index')->with('success', 'Cuisine deleted.');
    }
}
