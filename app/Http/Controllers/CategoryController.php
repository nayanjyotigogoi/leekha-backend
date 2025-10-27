<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; 
class CategoryController extends Controller
{
    // GET /api/categories → list all categories
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json($categories);
    }

    /**
     * GET /api/categories/{slug}
     * → Show a single category by slug with its writings
     */
    public function show($slug)
    {
        $category = Category::with('writings')
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($category);
    }


    // POST /api/categories → create a category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    // PUT /api/categories/{id} → update a category
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:100|unique:categories,name,' . $category->id,
            'slug' => 'sometimes|string|max:100|unique:categories,slug,' . $category->id,
        ]);

        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return response()->json($category);
    }

    // DELETE /api/categories/{id} → delete a category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
