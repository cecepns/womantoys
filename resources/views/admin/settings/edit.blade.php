@extends('admin.layouts.app')

@section('title', 'Pengaturan - Panel Admin')

@section('page-title', 'Pengaturan')
@section('page-description', 'Ganti sandi dan atur alamat toko')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Change Password Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Ganti Kata Sandi</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.password') }}" id="password-setting-form">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <input id="current_password" type="password" name="current_password"
                                    autocomplete="current-password"
                                    class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10 text-sm"
                                    required>
                                <button type="button"
                                    class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700"
                                    onclick="togglePassword('current_password', this)"
                                    aria-label="Tampilkan/Sembunyikan kata sandi">
                                    <svg class="icon-eye w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="icon-eye-off w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
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
                                <input id="new_password" type="password" name="new_password" autocomplete="new-password"
                                    class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10 text-sm"
                                    required>
                                <button type="button"
                                    class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700"
                                    onclick="togglePassword('new_password', this)"
                                    aria-label="Tampilkan/Sembunyikan kata sandi">
                                    <svg class="icon-eye w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="icon-eye-off w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
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
                                <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                    autocomplete="new-password"
                                    class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 pr-10 text-sm"
                                    required>
                                <button type="button"
                                    class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700"
                                    onclick="togglePassword('new_password_confirmation', this)"
                                    aria-label="Tampilkan/Sembunyikan kata sandi">
                                    <svg class="icon-eye w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="icon-eye-off w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.152-3.36M6.24 6.24A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.043 5.197M15 12a3 3 0 00-3-3" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Store Address Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Informasi Toko</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.store') }}" id="store-setting-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="store_city_label" id="store_city_label"
                        value="{{ old('store_city_label', $storeCityLabel) }}">
                    <input type="hidden" name="store_origin_id" id="store_origin_id" required
                        value="{{ old('store_origin_id', $storeOriginId) }}">
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $storeName) }}"
                                maxlength="255"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten (Origin)</label>
                            <div class="relative">
                                <input type="text" id="city-autocomplete"
                                    value="{{ old('store_city_label', $storeCityLabel) }}"
                                    placeholder="Ketik kota/kabupaten..." autocomplete="off"
                                    class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                                <div id="city-dropdown"
                                    class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden mt-1">
                                </div>
                            </div>
                            @error('store_origin_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="store_address" rows="3"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm"
                                placeholder="Nama jalan, nomor, RT/RW, dsb">{{ old('store_address', $storeAddress) }}</textarea>
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- WhatsApp Settings Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Pengaturan WhatsApp</h3>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">Atur nomor WhatsApp dan pesan default untuk floating
                    button.</p>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.whatsapp') }}" id="whatsapp-setting-form">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-2 sm:py-2 border border-gray-300 bg-gray-50 text-gray-500 text-sm rounded-l-lg">
                                    +62
                                </span>
                                <input type="tel" inputmode="numeric" name="whatsapp_number" maxlength="15"
                                    value="{{ old('whatsapp_number', $whatsappNumber) }}" placeholder="81234567890"
                                    class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 rounded-r-lg border-l-0 focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm"
                                    pattern="[0-9]+" title="Masukkan hanya angka">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Contoh: 81234567890 (tanpa kode negara +62)</p>
                            @error('whatsapp_number')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Default</label>
                            <textarea name="whatsapp_message" rows="3" maxlength="500"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm"
                                placeholder="Pesan yang akan dikirim saat user klik floating button">{{ old('whatsapp_message', $whatsappMessage) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Pesan ini akan otomatis terisi saat user mengklik
                                floating button WhatsApp</p>
                            @error('whatsapp_message')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
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

        function preventDoubleSubmit(formId) {
            const form = document.getElementById(formId);
            if (!form) return;
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        }
        preventDoubleSubmit('password-setting-form');
        preventDoubleSubmit('store-setting-form');
        preventDoubleSubmit('whatsapp-setting-form');
        let cityController;
        let lastCityQuery = '';
        let debouncedCityHandler;

        function cancelCityRequest() {
            if (cityController) {
                cityController.abort();
            }
            cityController = new AbortController();
        }

        const cityInput = document.getElementById('city-autocomplete');
        const cityDropdown = document.getElementById('city-dropdown');

        function showCityDropdown() {
            cityDropdown.classList.remove('hidden');
        }

        function hideCityDropdown() {
            cityDropdown.classList.add('hidden');
        }

        function renderCityOptions(items) {
            cityDropdown.innerHTML = '';
            if (!items || items.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'px-4 py-2 text-sm text-gray-500';
                empty.textContent = 'Tidak ada hasil';
                cityDropdown.appendChild(empty);
                showCityDropdown();
                return;
            }
            items.forEach(function(location) {
                const div = document.createElement('div');
                div.className = 'px-4 py-2 cursor-pointer hover:bg-pink-50 address-option';
                div.setAttribute('data-id', location.id);
                const label = (location.label || '');
                div.textContent = label;
                div.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    document.getElementById('store_origin_id').value = id;
                    document.getElementById('store_city_label').value = label;
                    cityInput.value = label;
                    hideCityDropdown();
                });
                cityDropdown.appendChild(div);
            });
            showCityDropdown();
        }

        function setCityLoading() {
            cityDropdown.innerHTML = '';
            const loading = document.createElement('div');
            loading.className = 'px-4 py-2 text-sm text-gray-500';
            loading.textContent = 'Memuat...';
            cityDropdown.appendChild(loading);
            showCityDropdown();
        }

        function debounce(fn, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            }
        }

        async function handleCityInput() {
            const query = cityInput.value.trim();
            if (query.length < 2 || query === lastCityQuery) {
                return;
            }
            lastCityQuery = query;
            cancelCityRequest();
            setCityLoading();
            try {
                const response = await fetch(
                    `/api/rajaongkir/search-destination?search=${encodeURIComponent(query)}&limit=10`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: cityController.signal
                    });
                const data = await response.json();
                if (!data || !data.data) {
                    renderCityOptions([]);
                    return;
                }
                renderCityOptions(data.data);
            } catch (err) {
                hideCityDropdown();
            }
        }

        if (cityInput) {
            debouncedCityHandler = debounce(handleCityInput, 300);
            cityInput.addEventListener('input', debouncedCityHandler);
        }

        document.addEventListener('click', function(e) {
            if (!cityDropdown.contains(e.target) && e.target !== cityInput) {
                hideCityDropdown();
            }
        });
    </script>
@endsection
