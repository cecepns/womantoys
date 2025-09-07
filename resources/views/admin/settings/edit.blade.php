@extends('admin.layouts.app')

@section('title', 'Pengaturan - Panel Admin')

@section('page-title', 'Pengaturan')
@section('page-description', 'Ganti sandi dan atur alamat toko')

@section('content')
    <!-- SECTION: SETTINGS PAGE -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- SECTION: CHANGE PASSWORD CARD -->
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
                            <!-- ANCHOR: Kata Sandi Saat Ini -->
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
                            <!-- ANCHOR: Kata Sandi Baru -->
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
                            <!-- ANCHOR: Konfirmasi Kata Sandi Baru -->
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
        <!-- !SECTION: CHANGE PASSWORD CARD -->

        <!-- SECTION: STORE ADDRESS CARD -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Informasi Toko</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.store') }}" id="store-setting-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="store_city_label" id="store_city_label"
                        value="{{ old('store_city_label', $storeCityLabel) }}">
                    <input type="hidden" name="store_origin_id" id="store_origin_id" required
                        value="{{ old('store_origin_id', $storeOriginId) }}">
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <!-- ANCHOR: Nama Toko -->
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $storeName) }}"
                                maxlength="255"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                        </div>
                        <div>
                            <!-- ANCHOR: Logo Toko -->
                            <label class="block text-sm font-medium text-gray-700 mb-1">Logo Toko</label>

                            <!-- Single Logo Preview Area -->
                            <div class="space-y-3">
                                <!-- Status Area -->
                                <div id="logo_status" class="hidden p-3 rounded-lg text-sm">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span id="logo_status_text"></span>
                                    </div>
                                </div>

                                <!-- Single Logo Preview Section -->
                                <div id="logo_preview_section" class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <!-- Content will be dynamically updated by JavaScript -->
                                </div>

                                <!-- Upload Section -->
                                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Upload Logo:</p>
                                    <div class="space-y-3">
                                        <!-- File Input -->
                                        <input type="file" name="logo" id="logo_input" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">

                                        <!-- Help Text -->
                                        <p class="text-xs text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF, SVG.
                                            Maksimal 2MB.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input for logo deletion -->
                            <input type="hidden" name="delete_logo" id="delete_logo"
                                value="{{ old('delete_logo', '0') }}">

                            <!-- Error Messages -->
                            @error('logo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <!-- ANCHOR: Kota/Kabupaten (Origin) dengan Autocomplete -->
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
                            <!-- ANCHOR: Alamat Lengkap -->
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="store_address" rows="3"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm"
                                placeholder="Nama jalan, nomor, RT/RW, dsb">{{ old('store_address', $storeAddress) }}</textarea>
                            @error('store_address')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- !SECTION: STORE ADDRESS CARD -->

        <!-- SECTION: STORE CONTACT CARD -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Kontak Toko</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.contact') }}" id="contact-setting-form">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <!-- ANCHOR: Email -->
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $email) }}"
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                        </div>
                        <div>
                            <!-- ANCHOR: Nomor WhatsApp (tanpa +62) -->
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
                            <!-- ANCHOR: Pesan Default WhatsApp -->
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
                                class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- !SECTION: STORE CONTACT CARD -->

        <!-- SECTION: ABOUT US IMAGE CARD -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Gambar Tentang Kami</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('admin.settings.about-image') }}" id="about-image-setting-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <!-- ANCHOR: Gambar Tentang Kami -->
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Tentang Kami</label>

                            <!-- Single Image Preview Area -->
                            <div class="space-y-3">
                                <!-- Status Area -->
                                <div id="about_image_status" class="hidden p-3 rounded-lg text-sm">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span id="about_image_status_text"></span>
                                    </div>
                                </div>

                                <!-- Single Image Preview Section -->
                                <div id="about_image_preview_section"
                                    class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <!-- Content will be dynamically updated by JavaScript -->
                                </div>

                                <!-- Upload Section -->
                                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Upload Gambar:</p>
                                    <div class="space-y-3">
                                        <!-- File Input -->
                                        <input type="file" name="about_us_image" id="about_us_image_input"
                                            accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">

                                        <!-- Help Text -->
                                        <p class="text-xs text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF, SVG.
                                            Maksimal 2MB.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input for image deletion -->
                            <input type="hidden" name="delete_about_us_image" id="delete_about_us_image"
                                value="{{ old('delete_about_us_image', '0') }}">

                            <!-- Error Messages -->
                            @error('about_us_image')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- !SECTION: ABOUT US IMAGE CARD -->
    </div>
    <!-- !SECTION: SETTINGS PAGE -->

    <!-- SECTION: SCRIPTS -->
    <script>
        // ANCHOR: Toggle Password Visibility
        // Menampilkan/menyembunyikan nilai input password dan toggle icon mata
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

        // ANCHOR: Prevent Double Submit
        // Menonaktifkan tombol submit setelah form dikirim untuk mencegah submit ganda
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
        preventDoubleSubmit('contact-setting-form');
        preventDoubleSubmit('about-image-setting-form');

        // ANCHOR: City Autocomplete State
        // Variabel state dan kontrol untuk permintaan pencarian kota ke server
        let cityController;
        let lastCityQuery = '';
        let debouncedCityHandler;

        // ANCHOR: Cancel Ongoing City Request
        // Membatalkan fetch sebelumnya agar tidak terjadi race condition
        function cancelCityRequest() {
            if (cityController) {
                cityController.abort();
            }
            cityController = new AbortController();
        }

        const cityInput = document.getElementById('city-autocomplete');
        const cityDropdown = document.getElementById('city-dropdown');

        // ANCHOR: Show/Hide City Dropdown
        function showCityDropdown() {
            cityDropdown.classList.remove('hidden');
        }

        function hideCityDropdown() {
            cityDropdown.classList.add('hidden');
        }

        // ANCHOR: Render City Options
        // Merender opsi kota dari hasil API ke dalam dropdown
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

        // ANCHOR: Set City Loading
        // Menampilkan indikator loading di dropdown saat menunggu hasil
        function setCityLoading() {
            cityDropdown.innerHTML = '';
            const loading = document.createElement('div');
            loading.className = 'px-4 py-2 text-sm text-gray-500';
            loading.textContent = 'Memuat...';
            cityDropdown.appendChild(loading);
            showCityDropdown();
        }

        // ANCHOR: Debounce Utility
        // Menunda eksekusi fungsi untuk mengurangi jumlah panggilan API
        function debounce(fn, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            }
        }

        // ANCHOR: Handle City Input
        // Mengirim request pencarian kota saat input berubah dengan debounce
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

        // Menyembunyikan dropdown ketika klik di luar elemen
        document.addEventListener('click', function(e) {
            if (!cityDropdown.contains(e.target) && e.target !== cityInput) {
                hideCityDropdown();
            }
        });

        // ANCHOR: Logo Preview and Remove
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                showNewLogoPreview(file);
            } else {
                // If no file selected, show current logo or empty state
                const currentLogo = '{{ $logo }}';
                if (currentLogo) {
                    showCurrentLogo('{{ asset('storage/' . $logo) }}');
                } else {
                    showEmptyState();
                }
            }
        }



        // Add event listener for logo input
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('logo_input');
            if (logoInput) {
                logoInput.addEventListener('change', previewLogo);
            }

            // Initialize logo preview
            initializeLogoPreview();


        });

        // ANCHOR: Logo Preview Management
        function initializeLogoPreview() {
            const currentLogo = '{{ $logo }}';
            if (currentLogo) {
                showCurrentLogo('{{ asset('storage/' . $logo) }}');
            } else {
                showEmptyState();
            }
        }

        function showCurrentLogo(logoPath) {
            const previewSection = document.getElementById('logo_preview_section');
            previewSection.innerHTML = `
                <div class="relative">
                    <img src="${logoPath}" alt="Current Logo"
                        class="h-20 max-w-full object-contain rounded-lg border border-gray-300"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="h-20 max-w-full bg-gray-100 flex items-center justify-center rounded-lg border border-gray-300" style="display: none;">
                        <div class="text-center text-gray-500">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-xs">Logo tidak dapat ditampilkan</p>
                        </div>
                    </div>
                    <!-- Delete Logo Button -->
                    <button type="button"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                        onclick="deleteCurrentLogo()" title="Hapus logo saat ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
        }

        function showNewLogoPreview(file) {
            const previewSection = document.getElementById('logo_preview_section');
            const reader = new FileReader();

            reader.onload = function(e) {
                previewSection.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="New Logo Preview"
                            class="h-20 max-w-full object-contain rounded-lg border border-gray-300">
                        <!-- Remove New Logo Button -->
                        <button type="button"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                            onclick="removeNewLogo()" title="Batal upload logo baru">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                // Reset delete logo flag since we're uploading new logo
                document.getElementById('delete_logo').value = '0';
                showLogoStatus('Logo baru dipilih. Logo lama akan diganti dengan logo baru ini.', 'info');
            };

            reader.readAsDataURL(file);
        }

        function showEmptyState() {
            const previewSection = document.getElementById('logo_preview_section');
            previewSection.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">Tidak ada logo yang dipilih</p>
                    <p class="text-gray-400 text-xs mt-1">Upload logo baru menggunakan form di bawah</p>
                </div>
            `;
        }

        function removeNewLogo() {
            const currentLogo = '{{ $logo }}';
            if (currentLogo) {
                showCurrentLogo('{{ asset('storage/' . $logo) }}');
            } else {
                showEmptyState();
            }
            // Clear file input
            document.getElementById('logo_input').value = '';
            hideLogoStatus();
        }

        // ANCHOR: Delete Current Logo
        function deleteCurrentLogo() {
            if (confirm('Apakah Anda yakin ingin menghapus logo saat ini?')) {
                document.getElementById('delete_logo').value = '1';
                // Show empty state
                showEmptyState();
                // Clear file input
                document.getElementById('logo_input').value = '';
                // Show status
                showLogoStatus(
                    'Logo akan dihapus saat form disubmit. Anda juga bisa upload logo baru untuk menggantikannya.',
                    'warning');
            }
        }



        // ANCHOR: Show Logo Status
        function showLogoStatus(message, type = 'info') {
            const statusArea = document.getElementById('logo_status');
            const statusText = document.getElementById('logo_status_text');

            if (statusArea && statusText) {
                statusText.textContent = message;

                // Set color based on type
                statusArea.className =
                    `p-3 rounded-lg text-sm ${type === 'warning' ? 'bg-yellow-50 text-yellow-800 border border-yellow-200' : 'bg-blue-50 text-blue-800 border border-blue-200'}`;

                statusArea.classList.remove('hidden');
            }
        }

        // ANCHOR: Hide Logo Status
        function hideLogoStatus() {
            const statusArea = document.getElementById('logo_status');
            if (statusArea) {
                statusArea.classList.add('hidden');
            }
        }

        // ANCHOR: About Us Image Preview and Remove
        function previewAboutUsImage(event) {
            const file = event.target.files[0];
            if (file) {
                showNewAboutUsImagePreview(file);
            } else {
                // If no file selected, show current image or empty state
                const currentImage = '{{ $aboutUsImage }}';
                if (currentImage) {
                    showCurrentAboutUsImage('{{ asset($aboutUsImage) }}');
                } else {
                    showAboutUsImageEmptyState();
                }
            }
        }

        // Add event listener for about us image input
        document.addEventListener('DOMContentLoaded', function() {
            const aboutUsImageInput = document.getElementById('about_us_image_input');
            if (aboutUsImageInput) {
                aboutUsImageInput.addEventListener('change', previewAboutUsImage);
            }

            // Initialize about us image preview
            initializeAboutUsImagePreview();
        });

        // ANCHOR: About Us Image Preview Management
        function initializeAboutUsImagePreview() {
            const currentImage = '{{ $aboutUsImage }}';
            if (currentImage) {
                // Check if it's a storage path or public path
                const imageUrl = currentImage.startsWith('images/') ?
                    '{{ url('/') }}/' + currentImage :
                    '{{ url('/storage') }}/' + currentImage;
                showCurrentAboutUsImage(imageUrl);
            } else {
                showAboutUsImageEmptyState();
            }
        }

        function showCurrentAboutUsImage(imagePath) {
            const previewSection = document.getElementById('about_image_preview_section');
            previewSection.innerHTML = `
                <div class="relative">
                    <img src="${imagePath}" alt="Current About Us Image"
                        class="h-32 w-full object-cover rounded-lg border border-gray-300"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="h-32 w-full bg-gray-100 flex items-center justify-center rounded-lg border border-gray-300" style="display: none;">
                        <div class="text-center text-gray-500">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-xs">Gambar tidak dapat ditampilkan</p>
                        </div>
                    </div>
                    <!-- Delete Image Button -->
                    <button type="button"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                        onclick="deleteCurrentAboutUsImage()" title="Hapus gambar saat ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
        }

        function showNewAboutUsImagePreview(file) {
            const previewSection = document.getElementById('about_image_preview_section');
            const reader = new FileReader();

            reader.onload = function(e) {
                previewSection.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="New About Us Image Preview"
                            class="h-32 w-full object-cover rounded-lg border border-gray-300">
                        <!-- Remove New Image Button -->
                        <button type="button"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors"
                            onclick="removeNewAboutUsImage()" title="Batal upload gambar baru">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                // Reset delete image flag since we're uploading new image
                document.getElementById('delete_about_us_image').value = '0';
                showAboutUsImageStatus('Gambar baru dipilih. Gambar lama akan diganti dengan gambar baru ini.', 'info');
            };

            reader.readAsDataURL(file);
        }

        function showAboutUsImageEmptyState() {
            const previewSection = document.getElementById('about_image_preview_section');
            previewSection.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">Tidak ada gambar yang dipilih</p>
                    <p class="text-gray-400 text-xs mt-1">Upload gambar baru menggunakan form di bawah</p>
                </div>
            `;
        }

        function removeNewAboutUsImage() {
            const currentImage = '{{ $aboutUsImage }}';
            if (currentImage) {
                // Check if it's a storage path or public path
                const imageUrl = currentImage.startsWith('images/') ?
                    '{{ url('/') }}/' + currentImage :
                    '{{ url('/storage') }}/' + currentImage;
                showCurrentAboutUsImage(imageUrl);
            } else {
                showAboutUsImageEmptyState();
            }
            // Clear file input
            document.getElementById('about_us_image_input').value = '';
            hideAboutUsImageStatus();
        }

        // ANCHOR: Delete Current About Us Image
        function deleteCurrentAboutUsImage() {
            if (confirm('Apakah Anda yakin ingin menghapus gambar tentang kami saat ini?')) {
                document.getElementById('delete_about_us_image').value = '1';
                // Show empty state
                showAboutUsImageEmptyState();
                // Clear file input
                document.getElementById('about_us_image_input').value = '';
                // Show status
                showAboutUsImageStatus(
                    'Gambar akan dihapus saat form disubmit. Anda juga bisa upload gambar baru untuk menggantikannya.',
                    'warning');
            }
        }

        // ANCHOR: Show About Us Image Status
        function showAboutUsImageStatus(message, type = 'info') {
            const statusArea = document.getElementById('about_image_status');
            const statusText = document.getElementById('about_image_status_text');

            if (statusArea && statusText) {
                statusText.textContent = message;

                // Set color based on type
                statusArea.className =
                    `p-3 rounded-lg text-sm ${type === 'warning' ? 'bg-yellow-50 text-yellow-800 border border-yellow-200' : 'bg-blue-50 text-blue-800 border border-blue-200'}`;

                statusArea.classList.remove('hidden');
            }
        }

        // ANCHOR: Hide About Us Image Status
        function hideAboutUsImageStatus() {
            const statusArea = document.getElementById('about_image_status');
            if (statusArea) {
                statusArea.classList.add('hidden');
            }
        }
    </script>
    <!-- !SECTION: SCRIPTS -->
@endsection
