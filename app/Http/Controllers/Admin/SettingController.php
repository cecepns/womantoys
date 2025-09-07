<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $storeName = Setting::getValue('store_name', 'WomanToys');
        $storeAddress = Setting::getValue('store_address', '');
        $storeCityLabel = Setting::getValue('store_city_label', '');
        $storeOriginId = Setting::getValue('store_origin_id', '');
        $email = Setting::getValue('email', 'primemania88@gmail.com');
        $whatsappNumber = Setting::getValue('whatsapp_number', '8100235004');
        $logo = Setting::getValue('logo', '');
        $whatsappMessage = Setting::getValue('whatsapp_message', 'Halo, saya ingin bertanya produk terbaru womantoys');
        $aboutUsImage = Setting::getValue('about_us_image', 'images/lauren-richmond-5Z3ugfTYYPI-unsplash (1).jpg');
        return view('admin.settings.edit', compact(
            'storeName',
            'storeAddress',
            'storeCityLabel',
            'storeOriginId',
            'whatsappNumber',
            'whatsappMessage',
            'email',
            'logo',
            'aboutUsImage'
        ));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!$admin || !Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Kata sandi saat ini salah.');
        }

        $admin->password = $request->new_password; // casted to hashed in model
        $admin->save();

        notify()->success('Kata sandi berhasil diperbarui');
        return back();
    }

    public function updateStore(Request $request)
    {
        $request->validate([
            'store_name' => 'nullable|string|max:255',
            'store_address' => 'nullable|string',
            'store_city_label' => 'nullable|string|max:255',
            'store_origin_id' => 'required|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_logo' => 'nullable|boolean',
        ], [
            'store_origin_id.required' => 'Kota/Kabupaten (Origin) wajib dipilih.',
            'store_origin_id.integer' => 'Kota/Kabupaten (Origin) tidak valid.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus JPEG, PNG, JPG, GIF, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            // User uploaded a new logo
            $logoFile = $request->file('logo');
            $logoPath = $logoFile->store('logo', 'public');
            $request->merge(['logo' => $logoPath]);

            // If user also wants to delete old logo, clean it up
            if ($request->boolean('delete_logo')) {
                $existingLogo = Setting::getValue('logo', '');
                if ($existingLogo && $existingLogo !== $logoPath) {
                    // Delete old logo file from storage (only if it's different from new one)
                    if (Storage::disk('public')->exists($existingLogo)) {
                        Storage::disk('public')->delete($existingLogo);
                    }
                }
            }
        } elseif ($request->boolean('delete_logo')) {
            // User only wants to delete logo without uploading new one
            $existingLogo = Setting::getValue('logo', '');
            if ($existingLogo) {
                // Delete logo file from storage
                if (Storage::disk('public')->exists($existingLogo)) {
                    Storage::disk('public')->delete($existingLogo);
                }
            }
            $request->merge(['logo' => '']); // Set logo to empty string
        } else {
            // Keep existing logo if no new file is uploaded and not deleting
            $existingLogo = Setting::getValue('logo', '');
            $request->merge(['logo' => $existingLogo]);
        }

        DB::transaction(function () use ($request) {
            Setting::setValue('store_name', $request->input('store_name'));
            Setting::setValue('store_address', $request->input('store_address'));
            Setting::setValue('store_city_label', $request->input('store_city_label'));
            Setting::setValue('store_origin_id', $request->input('store_origin_id'));
            Setting::setValue('logo', $request->input('logo'));
        });

        // Show appropriate success message
        if ($request->boolean('delete_logo') && !$request->hasFile('logo')) {
            notify()->success('Logo berhasil dihapus dan pengaturan toko berhasil disimpan');
        } elseif ($request->hasFile('logo') && $request->boolean('delete_logo')) {
            notify()->success('Logo lama berhasil dihapus, logo baru berhasil diupload, dan pengaturan toko berhasil disimpan');
        } elseif ($request->hasFile('logo')) {
            notify()->success('Logo baru berhasil diupload dan pengaturan toko berhasil disimpan');
        } else {
            notify()->success('Pengaturan toko berhasil disimpan');
        }

        return back();
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string|regex:/^[0-9]+$/|min:9|max:15',
            'whatsapp_message' => 'required|string|max:500',
            'email' => 'required|email',
        ], [
            'whatsapp_number.required' => 'Nomor WhatsApp harus diisi',
            'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh berisi angka',
            'whatsapp_number.min' => 'Nomor WhatsApp minimal 9 digit',
            'whatsapp_number.max' => 'Nomor WhatsApp maksimal 15 digit',
            'whatsapp_message.required' => 'Pesan WhatsApp harus diisi',
            'whatsapp_message.max' => 'Pesan WhatsApp maksimal 500 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
        ]);

        $rawNumber = $request->input('whatsapp_number', '');
        // Normalisasi: hapus non-digit (jaga-jaga), hilangkan leading 0 agar konsisten dengan prefix +62 di UI
        $normalized = preg_replace('/[^0-9]/', '', $rawNumber ?? '');
        if (strlen($normalized) > 0 && $normalized[0] === '0') {
            $normalized = ltrim($normalized, '0');
        }

        Setting::setValue('whatsapp_number', $normalized);
        Setting::setValue('whatsapp_message', $request->input('whatsapp_message'));
        Setting::setValue('email', $request->input('email'));
        notify()->success('Pengaturan kontak berhasil disimpan');
        return back();
    }

    public function updateAboutImage(Request $request)
    {
        $request->validate([
            'about_us_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_about_us_image' => 'nullable|boolean',
        ], [
            'about_us_image.image' => 'File gambar harus berupa gambar.',
            'about_us_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, atau SVG.',
            'about_us_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('about_us_image')) {
            // User uploaded a new image
            $imageFile = $request->file('about_us_image');
            $imagePath = $imageFile->store('about-us', 'public');
            $request->merge(['about_us_image' => $imagePath]);

            // If user also wants to delete old image, clean it up
            if ($request->boolean('delete_about_us_image')) {
                $existingImage = Setting::getValue('about_us_image', '');
                if ($existingImage && $existingImage !== $imagePath && !str_starts_with($existingImage, 'images/')) {
                    // Delete old image file from storage (only if it's different from new one and not a default image)
                    if (Storage::disk('public')->exists($existingImage)) {
                        Storage::disk('public')->delete($existingImage);
                    }
                }
            }
        } elseif ($request->boolean('delete_about_us_image')) {
            $existingImage = Setting::getValue('about_us_image', '');
            if ($existingImage && !str_starts_with($existingImage, 'images/')) {
                // Delete image file from storage (only if it's not a default image)
                if (Storage::disk('public')->exists($existingImage)) {
                    Storage::disk('public')->delete($existingImage);
                }
            }
            $request->merge(['about_us_image' => 'images/lauren-richmond-5Z3ugfTYYPI-unsplash (1).jpg']); // Set to default image
        } else {
            // Keep existing image if no new file is uploaded and not deleting
            $existingImage = Setting::getValue('about_us_image', 'images/lauren-richmond-5Z3ugfTYYPI-unsplash (1).jpg');
            $request->merge(['about_us_image' => $existingImage]);
        }

        DB::transaction(function () use ($request) {
            Setting::setValue('about_us_image', $request->input('about_us_image'));
        });

        // Show appropriate success message
        if ($request->boolean('delete_about_us_image') && !$request->hasFile('about_us_image')) {
            notify()->success('Gambar tentang kami berhasil dihapus dan dikembalikan ke gambar default');
        } elseif ($request->hasFile('about_us_image') && $request->boolean('delete_about_us_image')) {
            notify()->success('Gambar lama berhasil dihapus, gambar baru berhasil diupload');
        } elseif ($request->hasFile('about_us_image')) {
            notify()->success('Gambar tentang kami berhasil diupload');
        } else {
            notify()->success('Pengaturan gambar tentang kami berhasil disimpan');
        }

        return back();
    }
}
