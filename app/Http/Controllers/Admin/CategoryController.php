<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        $data = $request->all();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория добавлена');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $data = $request->all();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория удалена');
    }
}