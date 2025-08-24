<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = CarouselSlide::orderBy('order', 'asc')->get();
        return view('admin.carousel.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
        ], [
            'image_path.required' => 'Gambar slide wajib diupload.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
            'order.required' => 'Urutan tampil wajib diisi.',
            'order.integer' => 'Urutan tampil harus berupa angka.',
            'order.min' => 'Urutan tampil minimal 1.',
        ]);

        // Validate CTA consistency
        if ($request->filled('cta_text') && !$request->filled('cta_link')) {
            return back()->withErrors(['cta_link' => 'Jika mengisi teks tombol CTA, link tujuan juga harus diisi.'])->withInput();
        }

        if (!$request->filled('cta_text') && $request->filled('cta_link')) {
            return back()->withErrors(['cta_text' => 'Jika mengisi link CTA, teks tombol juga harus diisi.'])->withInput();
        }

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('carousel', 'public');
        }

        // Create carousel slide
        CarouselSlide::create([
            'image_path' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide carousel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarouselSlide $carouselSlide)
    {
        return view('admin.carousel.show', compact('carouselSlide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarouselSlide $carousel)
    {
        return view('admin.carousel.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarouselSlide $carousel)
    {
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
        ], [
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
            'order.required' => 'Urutan tampil wajib diisi.',
            'order.integer' => 'Urutan tampil harus berupa angka.',
            'order.min' => 'Urutan tampil minimal 1.',
        ]);

        // Check if order is being changed and if it conflicts with existing slides
        if ($request->order != $carousel->order) {
            $existingSlide = CarouselSlide::where('order', $request->order)
                ->where('id', '!=', $carousel->id)
                ->first();
            
            if ($existingSlide) {
                return back()->withErrors(['order' => 'Urutan ' . $request->order . ' sudah digunakan oleh slide lain.'])->withInput();
            }
        }

        // Validate CTA consistency
        if ($request->filled('cta_text') && !$request->filled('cta_link')) {
            return back()->withErrors(['cta_link' => 'Jika mengisi teks tombol CTA, link tujuan juga harus diisi.'])->withInput();
        }

        if (!$request->filled('cta_text') && $request->filled('cta_link')) {
            return back()->withErrors(['cta_text' => 'Jika mengisi link CTA, teks tombol juga harus diisi.'])->withInput();
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'order' => $request->order,
        ];

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            // Delete old image if it exists
            if ($carousel->image_path) {
                try {
                    if (Storage::disk('public')->exists($carousel->image_path)) {
                        Storage::disk('public')->delete($carousel->image_path);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete carousel image during removal: ' . $carousel->image_path, [
                        'error' => $e->getMessage(),
                        'slide_id' => $carousel->id
                    ]);
                }
            }
            $data['image_path'] = null;
        }

        // Handle image upload if new image is provided
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($carousel->image_path) {
                try {
                    if (Storage::disk('public')->exists($carousel->image_path)) {
                        Storage::disk('public')->delete($carousel->image_path);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with update
                    \Log::warning('Failed to delete old carousel image: ' . $carousel->image_path, [
                        'error' => $e->getMessage(),
                        'slide_id' => $carousel->id
                    ]);
                }
            }
            
            // Store new image
            $data['image_path'] = $request->file('image_path')->store('carousel', 'public');
        }

        $carousel->update($data);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide carousel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarouselSlide $carouselSlide)
    {
        // Delete image file if it exists
        if ($carouselSlide->image_path) {
            try {
                if (Storage::disk('public')->exists($carouselSlide->image_path)) {
                    Storage::disk('public')->delete($carouselSlide->image_path);
                }
            } catch (\Exception $e) {
                // Log error but continue with deletion
                \Log::warning('Failed to delete carousel image during slide deletion: ' . $carouselSlide->image_path, [
                    'error' => $e->getMessage(),
                    'slide_id' => $carouselSlide->id
                ]);
            }
        }

        $carouselSlide->delete();

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide carousel berhasil dihapus!');
    }

    /**
     * Move slide up in order.
     */
    public function moveUp(CarouselSlide $carouselSlide)
    {
        if ($carouselSlide->moveUp()) {
            return redirect()->route('admin.carousel.index')
                ->with('success', 'Urutan slide berhasil diubah!');
        }

        return redirect()->route('admin.carousel.index')
            ->with('error', 'Tidak dapat memindahkan slide ke atas!');
    }

    /**
     * Move slide down in order.
     */
    public function moveDown(CarouselSlide $carouselSlide)
    {
        if ($carouselSlide->moveDown()) {
            return redirect()->route('admin.carousel.index')
                ->with('success', 'Urutan slide berhasil diubah!');
        }

        return redirect()->route('admin.carousel.index')
            ->with('error', 'Tidak dapat memindahkan slide ke bawah!');
    }
}
