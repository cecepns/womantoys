@extends('admin.layouts.app')

@section('title', 'Tambah Voucher')

@section('content')
<!-- SECTION: HTML Elements -->

<!-- ANCHOR: Header -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Voucher Baru</h1>
            <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">Isi semua detail voucher yang diperlukan</p>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-3 md:px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start w-full sm:w-auto">
            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm md:text-base">Kembali ke Daftar</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- SECTION: Main Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Form Voucher</h2>

            <!-- ANCHOR: Form Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ANCHOR: Form -->
            <form method="POST" action="{{ route('admin.vouchers.store') }}" class="space-y-6" id="voucher-form">
                @csrf
                
                <!-- ANCHOR: Kode Voucher -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="code" class="block text-sm font-medium text-gray-700">
                        Kode Voucher <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-2">
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-0">
                            <input type="text" 
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-l-lg sm:rounded-r-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('code') border-red-500 @enderror text-sm sm:text-base" 
                                    id="code" name="code" value="{{ old('code') }}" 
                                    placeholder="Masukkan kode voucher" 
                                    style="text-transform: uppercase;">
                            <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 sm:border-l-0 rounded-lg sm:rounded-l-none sm:rounded-r-lg transition-colors duration-200 flex items-center justify-center" id="generate-code">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span class="ml-2 sm:hidden text-sm">Generate</span>
                            </button>
                        </div>
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kode harus unik dan akan digunakan pelanggan</p>
                    </div>
                </div>

                <!-- ANCHOR: Nama Voucher -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Voucher <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-2">
                        <input type="text" 
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('name') border-red-500 @enderror text-sm sm:text-base" 
                                id="name" name="name" value="{{ old('name') }}" 
                                placeholder="Masukkan nama voucher">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                                <!-- ANCHOR: Deskripsi -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Deskripsi
                    </label>
                    <div class="md:col-span-2">
                        <textarea class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror text-sm sm:text-base" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Masukkan deskripsi voucher">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- ANCHOR: Jenis Diskon -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="type" class="block text-sm font-medium text-gray-700">
                        Jenis Diskon <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-2">
                        <select class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('type') border-red-500 @enderror text-sm sm:text-base" id="type" name="type">
                            <option value="">Pilih jenis diskon</option>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>Nominal (Rp)</option>
                            <option value="free_shipping" {{ old('type') == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- ANCHOR: Nilai Diskon -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="value" class="block text-sm font-medium text-gray-700">
                        Nilai Diskon <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-2">
                        <div class="flex">
                            <input type="number" 
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('value') border-red-500 @enderror text-sm sm:text-base" 
                                    id="value" name="value" value="{{ old('value') }}" 
                                    placeholder="0" step="0.01" min="0">
                            <span class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg text-gray-700 text-sm sm:text-base" id="value-suffix">%</span>
                        </div>
                        @error('value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1" id="value-help">Masukkan nilai persentase (contoh: 50 untuk 50%)</p>
                        <p class="text-red-500 text-xs mt-1 hidden" id="value-validation-error"></p>
                    </div>
                </div>

                <!-- ANCHOR: Minimum Pembelian -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="min_purchase" class="block text-sm font-medium text-gray-700">
                        Minimum Pembelian
                    </label>
                    <div class="md:col-span-2">
                        <div class="flex">
                            <span class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-gray-300 rounded-l-lg text-gray-700 text-sm sm:text-base">Rp</span>
                            <input type="number" 
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-l-0 border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('min_purchase') border-red-500 @enderror text-sm sm:text-base" 
                                    id="min_purchase" name="min_purchase" value="{{ old('min_purchase') }}" 
                                    placeholder="0" min="0">
                        </div>
                        @error('min_purchase')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ada minimum pembelian</p>
                    </div>
                </div>

                <!-- ANCHOR: Maksimal Diskon -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center hidden" id="max-discount-group">
                    <label for="max_discount" class="block text-sm font-medium text-gray-700">
                        Maksimal Diskon
                    </label>
                    <div class="md:col-span-2">
                        <div class="flex">
                            <span class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-gray-300 rounded-l-lg text-gray-700 text-sm sm:text-base">Rp</span>
                            <input type="number" 
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-l-0 border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('max_discount') border-red-500 @enderror text-sm sm:text-base" 
                                    id="max_discount" name="max_discount" value="{{ old('max_discount') }}" 
                                    placeholder="0" min="0">
                        </div>
                        @error('max_discount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ada batasan maksimal diskon</p>
                    </div>
                </div>

                <!-- ANCHOR: Batas Penggunaan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700">
                        Batas Penggunaan
                    </label>
                    <div class="md:col-span-2">
                        <input type="number" 
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('usage_limit') border-red-500 @enderror text-sm sm:text-base" 
                                id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" 
                                placeholder="0" min="1">
                        @error('usage_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kosongkan untuk penggunaan tidak terbatas</p>
                    </div>
                </div>

                <!-- ANCHOR: Tanggal Mulai -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="starts_at" class="block text-sm font-medium text-gray-700">
                        Tanggal Mulai
                    </label>
                    <div class="md:col-span-2">
                        <input type="date" 
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('starts_at') border-red-500 @enderror text-sm sm:text-base" 
                                id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                        @error('starts_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kosongkan untuk berlaku segera</p>
                    </div>
                </div>

                <!-- ANCHOR: Tanggal Berakhir -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label for="expires_at" class="block text-sm font-medium text-gray-700">
                        Tanggal Berakhir
                    </label>
                    <div class="md:col-span-2">
                        <input type="date" 
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('expires_at') border-red-500 @enderror text-sm sm:text-base" 
                                id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                        @error('expires_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Kosongkan untuk voucher permanen</p>
                    </div>
                </div>

                <!-- ANCHOR: Checkbox Options -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div></div>
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" 
                                    type="checkbox" id="is_active" name="is_active" value="1" 
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="ml-3 block text-sm font-medium text-gray-700" for="is_active">
                                Voucher Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- !SECTION: Main Form -->

    <!-- SECTION: Preview Card -->
    <div class="lg:col-span-1">
        <!-- ANCHOR: Preview Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Voucher</h3>
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 text-center">
                <div class="mb-3">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h5 class="font-bold text-base sm:text-lg text-gray-800 uppercase" id="preview-code">KODE VOUCHER</h5>
                <p class="text-gray-700 mb-2 text-sm sm:text-base" id="preview-name">Nama Voucher</p>
                <p class="text-gray-500 text-xs sm:text-sm mb-3" id="preview-description">Deskripsi voucher akan tampil di sini</p>
                <div class="mb-3">
                    <span class="bg-green-100 text-green-800 text-xs sm:text-sm font-medium px-3 py-1 rounded-full" id="preview-value">Diskon akan tampil di sini</span>
                </div>
                <div>
                    <p class="text-gray-500 text-xs" id="preview-conditions">Syarat dan ketentuan</p>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Tips Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
            <h3 class="text-lg font-semibold text-blue-600 mb-4">Tips Membuat Voucher</h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <div>
                        <strong class="text-gray-800 text-sm sm:text-base">Kode yang Mudah Diingat:</strong> 
                        <span class="text-gray-600 text-xs sm:text-sm">Gunakan kode yang mudah diingat dan diketik</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <strong class="text-gray-800 text-sm sm:text-base">Nilai yang Menarik:</strong> 
                        <span class="text-gray-600 text-xs sm:text-sm">Berikan diskon yang cukup menarik untuk customer</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <strong class="text-gray-800 text-sm sm:text-base">Periode Terbatas:</strong> 
                        <span class="text-gray-600 text-xs sm:text-sm">Buat urgency dengan membatasi periode berlaku</span>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <div>
                        <strong class="text-gray-800 text-sm sm:text-base">Batasi Penggunaan:</strong> 
                        <span class="text-gray-600 text-xs sm:text-sm">Kontrol budget dengan membatasi jumlah penggunaan</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ANCHOR: Action Buttons -->
<div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 mt-8">
    <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-colors duration-200 text-center text-sm md:text-base order-2 sm:order-1">
        Batal
    </a>
    <button type="submit" form="voucher-form" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-8 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base order-1 sm:order-2">
        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Simpan Voucher</span>
    </button>
</div>
<!-- !SECTION: HTML Elements -->

<!-- SECTION: Styles -->
<style>
/* Custom styling for date input */
input[type="date"] {
    font-family: monospace;
}

/* Custom styling for better date input appearance */
input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
}
</style>
<!-- !SECTION: Styles -->

<!-- SECTION: Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ANCHOR: Generate code functionality
    document.getElementById('generate-code').addEventListener('click', function() {
        fetch('{{ route("admin.vouchers.generate-code") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('code').value = data.code;
                updatePreview();
            })
            .catch(error => console.error('Error:', error));
    });

    // ANCHOR: Update value suffix and help text based on type
    document.getElementById('type').addEventListener('change', function() {
        const valueSuffix = document.getElementById('value-suffix');
        const valueHelp = document.getElementById('value-help');
        const maxDiscountGroup = document.getElementById('max-discount-group');
        const valueInput = document.getElementById('value');
        const validationError = document.getElementById('value-validation-error');

        switch(this.value) {
            case 'percentage':
                valueSuffix.classList.remove('hidden');
                valueSuffix.textContent = '%';
                valueHelp.textContent = 'Masukkan nilai persentase (contoh: 50 untuk 50%)';
                maxDiscountGroup.classList.remove('hidden');
                valueInput.min = '1';
                valueInput.max = '100';
                break;
            case 'fixed_amount':
                valueSuffix.classList.remove('hidden');
                valueSuffix.textContent = 'Rp';
                valueHelp.textContent = 'Masukkan nominal diskon dalam rupiah (min. Rp100)';
                maxDiscountGroup.classList.add('hidden');
                valueInput.min = '100';
                valueInput.max = '';
                break;
            case 'free_shipping':
                valueSuffix.classList.remove('hidden');
                valueSuffix.textContent = 'Rp';
                valueHelp.textContent = 'Masukkan nominal free ongkir dalam rupiah (min. Rp100)';
                maxDiscountGroup.classList.add('hidden');
                valueInput.min = '100';
                valueInput.max = '';
                break;
            default:
                valueSuffix.classList.remove('hidden');
                valueSuffix.textContent = '%';
                valueHelp.textContent = 'Pilih jenis diskon terlebih dahulu';
                maxDiscountGroup.classList.add('hidden');
                valueInput.min = '0';
                valueInput.max = '';
        }
        
        // Clear validation error when type changes
        validationError.classList.add('hidden');
        validationError.textContent = '';
        
        updatePreview();
    });

    // ANCHOR: Update preview when form values change
    function updatePreview() {
        const code = document.getElementById('code').value || 'KODE VOUCHER';
        const name = document.getElementById('name').value || 'Nama Voucher';
        const description = document.getElementById('description').value || 'Deskripsi voucher akan tampil di sini';
        const type = document.getElementById('type').value;
        const value = document.getElementById('value').value;
        const minPurchase = document.getElementById('min_purchase').value;
        const maxDiscount = document.getElementById('max_discount').value;

        document.getElementById('preview-code').textContent = code;
        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-description').textContent = description;

        // Format value display
        let valueText = 'Diskon akan tampil di sini';
        if (type && value) {
            switch(type) {
                case 'percentage':
                    valueText = value + '% OFF';
                    break;
                case 'fixed_amount':
                    valueText = 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    break;
                case 'free_shipping':
                    valueText = 'GRATIS ONGKIR';
                    break;
            }
        }
        document.getElementById('preview-value').textContent = valueText;

        // Format conditions
        let conditions = [];
        if (minPurchase) {
            conditions.push('Min. belanja Rp ' + parseInt(minPurchase).toLocaleString('id-ID'));
        }
        if (type === 'percentage' && maxDiscount) {
            conditions.push('Maks. diskon Rp ' + parseInt(maxDiscount).toLocaleString('id-ID'));
        }
        
        const conditionsText = conditions.length > 0 ? conditions.join(' • ') : 'Syarat dan ketentuan';
        document.getElementById('preview-conditions').textContent = conditionsText;
    }

    // ANCHOR: Add event listeners for preview updates
    ['code', 'name', 'description', 'value', 'min_purchase', 'max_discount'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    // ANCHOR: Real-time validation for value input
    document.getElementById('value').addEventListener('input', function() {
        const type = document.getElementById('type').value;
        const value = parseFloat(this.value) || 0;
        const validationError = document.getElementById('value-validation-error');
        
        // Clear previous error
        validationError.classList.add('hidden');
        validationError.textContent = '';
        
        if (type === 'percentage') {
            if (value < 1 || value > 100) {
                validationError.textContent = 'Nilai diskon persentase harus antara 1% - 100%';
                validationError.classList.remove('hidden');
            }
        } else if (type === 'fixed_amount') {
            if (value < 100) {
                validationError.textContent = 'Nilai diskon nominal minimal Rp100';
                validationError.classList.remove('hidden');
            }
        } else if (type === 'free_shipping') {
            if (value < 100) {
                validationError.textContent = 'Nilai diskon nominal minimal Rp100';
                validationError.classList.remove('hidden');
            }
        }
    });

    // ANCHOR: Format code to uppercase
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // ANCHOR: Initial preview update
    updatePreview();

    // ANCHOR: Set default date values
    function setDefaultDate() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        
        const defaultDate = `${year}-${month}-${day}`;
        
        // Set default value for starts_at if empty
        const startsAtInput = document.getElementById('starts_at');
        if (!startsAtInput.value) {
            startsAtInput.value = defaultDate;
        }
        
        // Set default value for expires_at if empty (1 month from now)
        const expiresAtInput = document.getElementById('expires_at');
        if (!expiresAtInput.value) {
            const oneMonthLater = new Date(now.getTime() + (30 * 24 * 60 * 60 * 1000));
            const expYear = oneMonthLater.getFullYear();
            const expMonth = String(oneMonthLater.getMonth() + 1).padStart(2, '0');
            const expDay = String(oneMonthLater.getDate()).padStart(2, '0');
            
            const expDate = `${expYear}-${expMonth}-${expDay}`;
            expiresAtInput.value = expDate;
        }
    }

    // ANCHOR: Initialize date inputs
    setDefaultDate();

    // ANCHOR: Validate date inputs
    function validateDate() {
        const startsAtInput = document.getElementById('starts_at');
        const expiresAtInput = document.getElementById('expires_at');
        
        if (startsAtInput.value && expiresAtInput.value) {
            const startsAt = new Date(startsAtInput.value);
            const expiresAt = new Date(expiresAtInput.value);
            
            if (expiresAt <= startsAt) {
                // Set expires_at to 1 day after starts_at
                const oneDayLater = new Date(startsAt.getTime() + (24 * 60 * 60 * 1000));
                const year = oneDayLater.getFullYear();
                const month = String(oneDayLater.getMonth() + 1).padStart(2, '0');
                const day = String(oneDayLater.getDate()).padStart(2, '0');
                
                const expDate = `${year}-${month}-${day}`;
                expiresAtInput.value = expDate;
            }
        }
    }

    // Add validation to date inputs
    document.getElementById('starts_at').addEventListener('change', validateDate);
    document.getElementById('expires_at').addEventListener('change', validateDate);
});
</script>
<!-- !SECTION: Scripts -->
@endsection
