<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function edit()
    {
        $storeName = Setting::getValue('store_name', 'WomanToys');
        $storeAddress = Setting::getValue('store_address', '');
        $storeCityLabel = Setting::getValue('store_city_label', '');
        $storeOriginId = Setting::getValue('store_origin_id', '');
        $whatsappNumber = Setting::getValue('whatsapp_number', '8100235004');
        $whatsappMessage = Setting::getValue('whatsapp_message', 'Halo, saya ingin bertanya produk terbaru womantoys');
        return view('admin.settings.edit', compact(
            'storeName',
            'storeAddress',
            'storeCityLabel',
            'storeOriginId',
            'whatsappNumber',
            'whatsappMessage'
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
        ]);

        DB::transaction(function () use ($request) {
            Setting::setValue('store_name', $request->input('store_name'));
            Setting::setValue('store_address', $request->input('store_address'));
            Setting::setValue('store_city_label', $request->input('store_city_label'));
            Setting::setValue('store_origin_id', $request->input('store_origin_id'));
        });

        notify()->success('Pengaturan toko berhasil disimpan');
        return back();
    }

    public function updateWhatsApp(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string|regex:/^[0-9]+$/|min:9|max:15',
            'whatsapp_message' => 'required|string|max:500',
        ], [
            'whatsapp_number.required' => 'Nomor WhatsApp harus diisi',
            'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh berisi angka',
            'whatsapp_number.min' => 'Nomor WhatsApp minimal 9 digit',
            'whatsapp_number.max' => 'Nomor WhatsApp maksimal 15 digit',
            'whatsapp_message.required' => 'Pesan WhatsApp harus diisi',
            'whatsapp_message.max' => 'Pesan WhatsApp maksimal 500 karakter',
        ]);

        $rawNumber = $request->input('whatsapp_number', '');
        // Normalisasi: hapus non-digit (jaga-jaga), hilangkan leading 0 agar konsisten dengan prefix +62 di UI
        $normalized = preg_replace('/[^0-9]/', '', $rawNumber ?? '');
        if (strlen($normalized) > 0 && $normalized[0] === '0') {
            $normalized = ltrim($normalized, '0');
        }

        Setting::setValue('whatsapp_number', $normalized);
        Setting::setValue('whatsapp_message', $request->input('whatsapp_message'));

        notify()->success('Pengaturan WhatsApp berhasil disimpan');
        return back();
    }
}


