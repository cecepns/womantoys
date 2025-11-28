<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        // Validasi upload dua versi gambar: desktop (wajib) dan mobile (opsional)
        // Batasan: hanya JPEG, PNG, WebP; maksimum 5MB per file
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,webp|max:5120',
            'image_mobile_path' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ], [
            'image_path.required' => 'Gambar desktop wajib diupload.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
            'image_mobile_path.image' => 'File harus berupa gambar.',
            'image_mobile_path.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image_mobile_path.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Validate CTA consistency
        if ($request->filled('cta_text') && !$request->filled('cta_link')) {
            return back()->withErrors(['cta_link' => 'Jika mengisi teks tombol CTA, link tujuan juga harus diisi.'])->withInput();
        }

        if (!$request->filled('cta_text') && $request->filled('cta_link')) {
            return back()->withErrors(['cta_text' => 'Jika mengisi link CTA, teks tombol juga harus diisi.'])->withInput();
        }

        // Upload gambar desktop (wajib) dan mobile (opsional)
        // Prioritas penggunaan: desktop sebagai default, mobile untuk perangkat mobile bila tersedia
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('carousel', 'public');
        }
        $imageMobilePath = null;
        if ($request->hasFile('image_mobile_path')) {
            $imageMobilePath = $request->file('image_mobile_path')->store('carousel', 'public');
        }

        // Calculate next order number
        $nextOrder = CarouselSlide::max('order') + 1;

        // Create carousel slide
        CarouselSlide::create([
            'image_path' => $imagePath,
            'image_mobile_path' => $imageMobilePath,
            'title' => $request->title,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'order' => $nextOrder,
        ]);

        notify()->success('Slide carousel berhasil ditambahkan!', 'Berhasil');
        return redirect()->route('admin.carousel.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarouselSlide $carousel)
    {
        return view('admin.carousel.show', compact('carousel'));
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
        // Validasi update: desktop dan mobile, format JPEG/PNG/WebP, maksimum 5MB
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'image_mobile_path' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ], [
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
            'image_mobile_path.image' => 'File harus berupa gambar.',
            'image_mobile_path.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image_mobile_path.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Ensure carousel has an image (either existing or new)
        // Pastikan slide tetap memiliki gambar desktop (default) setelah update
        if (!$request->hasFile('image_path') && !$carousel->image_path) {
            return back()->withErrors(['image_path' => 'Carousel slide harus memiliki gambar desktop.']).withInput();
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



        // Update gambar desktop bila ada file baru
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($carousel->image_path) {
                try {
                    if (Storage::disk('public')->exists($carousel->image_path)) {
                        Storage::disk('public')->delete($carousel->image_path);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with update
                    Log::warning('Failed to delete old carousel image: ' . $carousel->image_path, [
                        'error' => $e->getMessage(),
                        'slide_id' => $carousel->id
                    ]);
                }
            }
            
            // Store new image
            $data['image_path'] = $request->file('image_path')->store('carousel', 'public');
        }

        // Update gambar mobile bila ada file baru (opsional)
        if ($request->hasFile('image_mobile_path')) {
            if ($carousel->image_mobile_path) {
                try {
                    if (Storage::disk('public')->exists($carousel->image_mobile_path)) {
                        Storage::disk('public')->delete($carousel->image_mobile_path);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to delete old mobile carousel image: ' . $carousel->image_mobile_path, [
                        'error' => $e->getMessage(),
                        'slide_id' => $carousel->id
                    ]);
                }
            }
            $data['image_mobile_path'] = $request->file('image_mobile_path')->store('carousel', 'public');
        }

        $carousel->update($data);

        notify()->success('Slide carousel berhasil diupdate!', 'Berhasil');
        return redirect()->route('admin.carousel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarouselSlide $carousel)
    {
        // Hapus file gambar desktop jika ada
        if ($carousel->image_path) {
            try {
                if (Storage::disk('public')->exists($carousel->image_path)) {
                    Storage::disk('public')->delete($carousel->image_path);
                }
            } catch (\Exception $e) {
                // Log error but continue with deletion
                Log::warning('Failed to delete carousel image during slide deletion: ' . $carousel->image_path, [
                    'error' => $e->getMessage(),
                    'slide_id' => $carousel->id
                ]);
            }
        }

        // Hapus file gambar mobile jika ada
        if ($carousel->image_mobile_path) {
            try {
                if (Storage::disk('public')->exists($carousel->image_mobile_path)) {
                    Storage::disk('public')->delete($carousel->image_mobile_path);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to delete mobile carousel image during slide deletion: ' . $carousel->image_mobile_path, [
                    'error' => $e->getMessage(),
                    'slide_id' => $carousel->id
                ]);
            }
        }

        $carousel->delete();

        notify()->success('Slide carousel berhasil dihapus!', 'Berhasil');
        return redirect()->route('admin.carousel.index');
    }

    /**
     * Move slide up in order.
     */
    public function moveUp(CarouselSlide $carouselSlide)
    {
        if ($carouselSlide->moveUp()) {
            notify()->success('Urutan slide berhasil diubah!', 'Berhasil');
            return redirect()->route('admin.carousel.index');
        }

        notify()->error('Tidak dapat memindahkan slide ke atas!', 'Gagal');
        return redirect()->route('admin.carousel.index');
    }

    /**
     * Move slide down in order.
     */
    public function moveDown(CarouselSlide $carouselSlide)
    {
        if ($carouselSlide->moveDown()) {
            notify()->success('Urutan slide berhasil diubah!', 'Berhasil');
            return redirect()->route('admin.carousel.index');
        }

        notify()->error('Tidak dapat memindahkan slide ke bawah!', 'Gagal');
        return redirect()->route('admin.carousel.index');
    }
}
