<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = MainCategory::withCount('categories')->orderBy('name', 'asc')->get();
        return view('admin.main-categories.index', compact('mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.main-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:main_categories,name',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('main-categories', 'public');
        }

        MainCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'cover_image' => $coverImagePath,
        ]);

        notify()->success('Kategori Utama berhasil ditambahkan.', 'Berhasil');
        return redirect()->route('admin.main-categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MainCategory $mainCategory)
    {
        return view('admin.main-categories.edit', compact('mainCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainCategory $mainCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:main_categories,name,' . $mainCategory->id,
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ];

        if ($request->hasFile('cover_image')) {
            // delete old if exists
            if (!empty($mainCategory->cover_image)) {
                \Storage::disk('public')->delete($mainCategory->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('main-categories', 'public');
        }

        $mainCategory->update($updateData);

        notify()->success('Kategori Utama berhasil diperbarui.', 'Berhasil');
        return redirect()->route('admin.main-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainCategory $mainCategory)
    {
        // Check if main category has categories
        if ($mainCategory->categories()->count() > 0) {
            notify()->error('Kategori Utama tidak dapat dihapus karena masih memiliki kategori.', 'Gagal');
            return redirect()->route('admin.main-categories.index');
        }

        // Delete cover image if exists
        if (!empty($mainCategory->cover_image)) {
            \Storage::disk('public')->delete($mainCategory->cover_image);
        }

        $mainCategory->delete();

        notify()->success('Kategori Utama berhasil dihapus.', 'Berhasil');
        return redirect()->route('admin.main-categories.index');
    }
}
