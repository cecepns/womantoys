<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * ANCHOR: Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::orderBy('order', 'asc')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * ANCHOR: Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * ANCHOR: Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg,mp4|max:51200',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ], [
            'file_path.required' => 'File wajib diupload.',
            'file_path.file' => 'File harus berupa gambar atau video.',
            'file_path.mimes' => 'Format file harus JPEG, PNG, JPG (untuk gambar) atau MP4 (untuk video).',
            'file_path.max' => 'Ukuran file maksimal 50MB.',
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('promotions', 'public');
        }

        // Calculate next order number
        $maxOrder = Promotion::max('order');
        $nextOrder = $maxOrder ? $maxOrder + 1 : 1;

        // Create promotion
        Promotion::create([
            'file_path' => $filePath,
            'cta_link' => $request->cta_link,
            'is_active' => $request->boolean('is_active', true),
            'order' => $nextOrder,
        ]);

        notify()->success('Promotion berhasil ditambahkan!', 'Berhasil');
        return redirect()->route('admin.promotions.index');
    }

    /**
     * ANCHOR: Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * ANCHOR: Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * ANCHOR: Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:51200',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ], [
            'file_path.file' => 'File harus berupa gambar atau video.',
            'file_path.mimes' => 'Format file harus JPEG, PNG, JPG (untuk gambar) atau MP4 (untuk video).',
            'file_path.max' => 'Ukuran file maksimal 50MB.',
        ]);

        // Ensure promotion has a file (either existing or new)
        if (!$request->hasFile('file_path') && !$promotion->file_path) {
            return back()->withErrors(['file_path' => 'Promotion harus memiliki file.'])->withInput();
        }

        $data = [
            'cta_link' => $request->cta_link,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('file_path')) {
            // Delete old file if it exists
            if ($promotion->file_path) {
                try {
                    if (Storage::disk('public')->exists($promotion->file_path)) {
                        Storage::disk('public')->delete($promotion->file_path);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with update
                    Log::warning('Failed to delete old promotion file: ' . $promotion->file_path, [
                        'error' => $e->getMessage(),
                        'promotion_id' => $promotion->id
                    ]);
                }
            }
            
            // Store new file
            $data['file_path'] = $request->file('file_path')->store('promotions', 'public');
        }

        $promotion->update($data);

        notify()->success('Promotion berhasil diupdate!', 'Berhasil');
        return redirect()->route('admin.promotions.index');
    }

    /**
     * ANCHOR: Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        // Delete file if it exists
        if ($promotion->file_path) {
            try {
                if (Storage::disk('public')->exists($promotion->file_path)) {
                    Storage::disk('public')->delete($promotion->file_path);
                }
            } catch (\Exception $e) {
                // Log error but continue with deletion
                Log::warning('Failed to delete promotion file during deletion: ' . $promotion->file_path, [
                    'error' => $e->getMessage(),
                    'promotion_id' => $promotion->id
                ]);
            }
        }

        $promotion->delete();

        notify()->success('Promotion berhasil dihapus!', 'Berhasil');
        return redirect()->route('admin.promotions.index');
    }
}

