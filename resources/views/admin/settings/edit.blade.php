@extends('admin.layouts.app')

@section('title', 'Pengaturan - Panel Admin')

@section('page-title', 'Pengaturan')
@section('page-description', 'Ganti sandi dan atur alamat toko')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Change Password Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Ganti Kata Sandi</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.settings.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input id="current_password" type="password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10" required>
                            <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700" onclick="togglePassword('current_password', this)" aria-label="Tampilkan/Sembunyikan kata sandi">
                                <svg class="icon-eye w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="icon-eye-off w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                        <div class="relative">
                            <input id="new_password" type="password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10" required>
                            <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700" onclick="togglePassword('new_password', this)" aria-label="Tampilkan/Sembunyikan kata sandi">
                                <svg class="icon-eye w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="icon-eye-off w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10" required>
                            <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700" onclick="togglePassword('new_password_confirmation', this)" aria-label="Tampilkan/Sembunyikan kata sandi">
                                <svg class="icon-eye w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="icon-eye-off w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Store Address Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Alamat Toko</h3>
            <p class="text-sm text-gray-600">Alamat ini dipakai sebagai origin di checkout.</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.settings.store') }}" id="store-setting-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="store_province_id" id="store_province_id" value="{{ old('store_province_id', $storeProvinceId) }}">
                <input type="hidden" name="store_city_id" id="store_city_id" value="{{ old('store_city_id', $storeCityId) }}">
                <input type="hidden" name="store_city_label" id="store_city_label" value="{{ old('store_city_label', $storeCityLabel) }}">
                <input type="hidden" name="store_origin_id" id="store_origin_id" value="{{ old('store_origin_id', $storeOriginId) }}">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $storeName) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten (Origin)</label>
                        <div class="relative">
                            <input type="text" id="city-autocomplete" value="{{ old('store_city_label', $storeCityLabel) }}" placeholder="Ketik kota/kabupaten..." autocomplete="off" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                            <div id="city-dropdown" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden mt-1"></div>
                        </div>
                        @error('store_origin_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="store_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="Nama jalan, nomor, RT/RW, dsb">{{ old('store_address', $storeAddress) }}</textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPassword = input.getAttribute('type') === 'password';
    input.setAttribute('type', isPassword ? 'text' : 'password');
    const eye = btn.querySelector('.icon-eye');
    const eyeOff = btn.querySelector('.icon-eye-off');
    if (eye && eyeOff) {
        if (isPassword) {
            eye.classList.add('hidden');
            eyeOff.classList.remove('hidden');
        } else {
            eye.classList.remove('hidden');
            eyeOff.classList.add('hidden');
        }
    }
}
let cityController;
let lastCityQuery = '';

function cancelCityRequest() {
    if (cityController) {
        cityController.abort();
    }
    cityController = new AbortController();
}

const cityInput = document.getElementById('city-autocomplete');
const cityDropdown = document.getElementById('city-dropdown');

function showCityDropdown() { cityDropdown.classList.remove('hidden'); }
function hideCityDropdown() { cityDropdown.classList.add('hidden'); }

cityInput && cityInput.addEventListener('input', async function(e) {
    const query = this.value.trim();
    if (query.length < 2 || query === lastCityQuery) { return; }
    lastCityQuery = query;
    cancelCityRequest();
    try {
        const response = await fetch(`/api/rajaongkir/search-destination?search=${encodeURIComponent(query)}&limit=10`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal: cityController.signal
        });
        const data = await response.json();
        if (!data || !data.data) { cityDropdown.innerHTML = ''; hideCityDropdown(); return; }
        const options = data.data.map(location => {
            const label = (location.label || '');
            return `<div class="px-4 py-2 cursor-pointer hover:bg-pink-50 address-option" data-id="${location.id}" data-label="${label.replace(/"/g, '&quot;')}">${label}</div>`;
        }).join('');
        cityDropdown.innerHTML = options;
        showCityDropdown();
        Array.from(cityDropdown.querySelectorAll('.address-option')).forEach(opt => {
            opt.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const label = this.getAttribute('data-label');
                document.getElementById('store_origin_id').value = id;
                document.getElementById('store_city_label').value = label;
                cityInput.value = label;
                hideCityDropdown();
            });
        });
    } catch (err) {
        // ignore
    }
});

document.addEventListener('click', function(e) {
    if (!cityDropdown.contains(e.target) && e.target !== cityInput) {
        hideCityDropdown();
    }
});
</script>
@endsection


