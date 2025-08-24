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
        ], [
            'image_path.required' => 'Gambar slide wajib diupload.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
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

        // Calculate next order number
        $nextOrder = CarouselSlide::max('order') + 1;

        // Create carousel slide
        CarouselSlide::create([
            'image_path' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'order' => $nextOrder,
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
        ], [
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Ensure carousel has an image (either existing or new)
        if (!$request->hasFile('image_path') && !$carousel->image_path) {
            return back()->withErrors(['image_path' => 'Carousel slide harus memiliki gambar.'])->withInput();
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
        ];



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
