<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['mainCategory', 'products'])->orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = MainCategory::orderBy('name', 'asc')->get();
        return view('admin.categories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'main_category_id' => 'required|exists:main_categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'main_category_id.required' => 'Kategori utama wajib dipilih.',
            'main_category_id.exists' => 'Kategori utama yang dipilih tidak valid.',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('categories', 'public');
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'main_category_id' => $validated['main_category_id'],
            'cover_image' => $coverImagePath,
        ]);

        notify()->success('Kategori berhasil ditambahkan.', 'Berhasil');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $mainCategories = MainCategory::orderBy('name', 'asc')->get();
        return view('admin.categories.edit', compact('category', 'mainCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'main_category_id' => 'required|exists:main_categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'main_category_id.required' => 'Kategori utama wajib dipilih.',
            'main_category_id.exists' => 'Kategori utama yang dipilih tidak valid.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'main_category_id' => $validated['main_category_id'],
        ];

        if ($request->hasFile('cover_image')) {
            // delete old if exists
            if (!empty($category->cover_image)) {
                \Storage::disk('public')->delete($category->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('categories', 'public');
        }

        $category->update($updateData);

        notify()->success('Kategori berhasil diperbarui.', 'Berhasil');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            notify()->error('Kategori tidak dapat dihapus karena masih memiliki produk.', 'Gagal');
            return redirect()->route('admin.categories.index');
        }

        $category->delete();

        notify()->success('Kategori berhasil dihapus.', 'Berhasil');
        return redirect()->route('admin.categories.index');
    }
}
