<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit()
    {
        $storeName = Setting::getValue('store_name', 'WomanToys');
        $storeAddress = Setting::getValue('store_address', '');
        $storeProvinceId = Setting::getValue('store_province_id', '');
        $storeCityId = Setting::getValue('store_city_id', '');
        $storeCityLabel = Setting::getValue('store_city_label', '');
        $storeOriginId = Setting::getValue('store_origin_id', '');
        return view('admin.settings.edit', compact(
            'storeName',
            'storeAddress',
            'storeProvinceId',
            'storeCityId',
            'storeCityLabel',
            'storeOriginId'
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
            'store_province_id' => 'nullable|integer',
            'store_city_id' => 'nullable|integer',
            'store_city_label' => 'nullable|string|max:255',
            'store_origin_id' => 'required|integer',
        ]);

        Setting::setValue('store_name', $request->input('store_name'));
        Setting::setValue('store_address', $request->input('store_address'));
        Setting::setValue('store_province_id', $request->input('store_province_id'));
        Setting::setValue('store_city_id', $request->input('store_city_id'));
        Setting::setValue('store_city_label', $request->input('store_city_label'));
        Setting::setValue('store_origin_id', $request->input('store_origin_id'));

        notify()->success('Pengaturan toko berhasil disimpan');
        return back();
    }
}


