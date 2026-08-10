<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('restaurants')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:100',
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function destroy(Category $category)
    {
        $category->restaurants()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
