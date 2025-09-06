@extends('admin.layouts.app')

@section('title', 'Edit Voucher')

@section('page-title', 'Edit Voucher')
@section('page-description', 'Edit detail voucher yang sudah ada')

@section('content')
    <!-- SECTION: Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Voucher: {{ $voucher->code }}</h1>
                <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">Ubah detail voucher sesuai kebutuhan</p>
            </div>
            <!-- ANCHOR: Back Button -->
            <a href="{{ route('admin.vouchers.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-3 md:px-4 rounded-lg transition-colors duration-200 flex items-center justify-center sm:justify-start w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                <span class="text-sm md:text-base">Kembali ke Daftar</span>
            </a>
        </div>
    </div>
    <!-- !SECTION: Header Section -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- SECTION: Main Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Form Edit Voucher</h2>

                <!-- ANCHOR: Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ANCHOR: Usage Warning -->
                @if ($voucher->hasBeenUsed())
                    <div class="mb-6 p-4 bg-orange-50 border border-orange-200 text-orange-700 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <div>
                                <h6 class="text-sm font-semibold text-orange-800">Voucher Sudah Digunakan</h6>
                                <p class="text-sm text-orange-700 mt-1">
                                    Jenis diskon dan nilai diskon tidak dapat diubah untuk menjaga konsistensi data
                                    transaksi.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ANCHOR: Edit Form -->
                <form method="POST" action="{{ route('admin.vouchers.update', $voucher) }}" class="space-y-6"
                    id="voucher-edit-form">
                    @csrf
                    @method('PUT')

                    <!-- ANCHOR: Kode Voucher -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="code" class="block text-sm font-medium text-gray-700">
                            Kode Voucher <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" readonly
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('code') border-red-500 @enderror text-sm sm:text-base bg-gray-50"
                                id="code" name="code" value="{{ old('code', $voucher->code) }}"
                                placeholder="Masukkan kode voucher" style="text-transform: uppercase;">
                            <p class="text-gray-500 text-xs mt-1">Kode harus unik tidak bisa diubah</p>
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
                                id="name" name="name" value="{{ old('name', $voucher->name) }}"
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
                            <textarea
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror text-sm sm:text-base"
                                id="description" name="description" rows="3" placeholder="Masukkan deskripsi voucher">{{ old('description', $voucher->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- ANCHOR: Jenis Diskon -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label for="type" class="block text-sm font-medium text-gray-700">
                            Jenis Diskon <span class="text-red-500">*</span>
                            @if ($voucher->hasBeenUsed())
                                <span class="text-orange-600 text-xs ml-2">(Tidak dapat diubah karena sudah
                                    digunakan)</span>
                            @endif
                        </label>
                        <div class="md:col-span-2">
                            <select
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('type') border-red-500 @enderror text-sm sm:text-base {{ $voucher->hasBeenUsed() ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                id="type" name="type" {{ $voucher->hasBeenUsed() ? 'disabled' : '' }}>
                                <option value="">Pilih jenis diskon</option>
                                <option value="percentage"
                                    {{ old('type', $voucher->type) == 'percentage' ? 'selected' : '' }}>Persentase (%)
                                </option>
                                <option value="fixed_amount"
                                    {{ old('type', $voucher->type) == 'fixed_amount' ? 'selected' : '' }}>Nominal (Rp)
                                </option>
                                <option value="free_shipping"
                                    {{ old('type', $voucher->type) == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir
                                </option>
                            </select>
                            @if ($voucher->hasBeenUsed())
                                <input type="hidden" name="type" value="{{ $voucher->type }}">
                            @endif
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- ANCHOR: Nilai Diskon -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center" id="value-input-group">
                        <label for="value" class="block text-sm font-medium text-gray-700">
                            Nilai Diskon <span class="text-red-500">*</span>
                            @if ($voucher->hasBeenUsed())
                                <span class="text-orange-600 text-xs ml-2">(Tidak dapat diubah karena sudah
                                    digunakan)</span>
                            @endif
                        </label>
                        <div class="md:col-span-2">
                            <div class="flex">
                                <input type="number"
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('value') border-red-500 @enderror text-sm sm:text-base {{ $voucher->hasBeenUsed() ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    id="value" name="value"
                                    value="{{ old('value', \App\Helpers\FormatHelper::formatInputValue($voucher->value)) }}"
                                    placeholder="0" step="0.01" min="0"
                                    {{ $voucher->hasBeenUsed() ? 'disabled' : '' }}>
                                <span
                                    class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg text-gray-700 text-sm sm:text-base"
                                    id="value-suffix">
                                    @if ($voucher->type === 'percentage')
                                        %
                                    @else
                                        Rp
                                    @endif
                                </span>
                            </div>
                            @if ($voucher->hasBeenUsed())
                                <input type="hidden" name="value" value="{{ $voucher->value }}">
                            @endif
                            @error('value')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1" id="value-help">Masukkan nilai persentase (contoh: 50
                                untuk 50%)</p>
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
                                <span
                                    class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-gray-300 rounded-l-lg text-gray-700 text-sm sm:text-base">Rp</span>
                                <input type="number"
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-l-0 border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('min_purchase') border-red-500 @enderror text-sm sm:text-base"
                                    id="min_purchase" name="min_purchase"
                                    value="{{ old('min_purchase', \App\Helpers\FormatHelper::formatInputValue($voucher->min_purchase)) }}"
                                    placeholder="0" min="0">
                            </div>
                            @error('min_purchase')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ada minimum pembelian</p>
                        </div>
                    </div>

                    <!-- ANCHOR: Maksimal Diskon -->
                    <div id="max-discount-group"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center {{ $voucher->type === 'percentage' ? '' : 'hidden' }}">
                        <label for="max_discount" class="block text-sm font-medium text-gray-700">
                            Maksimal Diskon
                        </label>
                        <div class="md:col-span-2">
                            <div class="flex">
                                <span
                                    class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 border border-gray-300 rounded-l-lg text-gray-700 text-sm sm:text-base">Rp</span>
                                <input type="number"
                                    class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-l-0 border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('max_discount') border-red-500 @enderror text-sm sm:text-base"
                                    id="max_discount" name="max_discount"
                                    value="{{ old('max_discount', \App\Helpers\FormatHelper::formatInputValue($voucher->max_discount)) }}"
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
                                id="usage_limit" name="usage_limit"
                                value="{{ old('usage_limit', $voucher->usage_limit) }}" placeholder="0" min="1">
                            @error('usage_limit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">
                                Kosongkan untuk penggunaan tidak terbatas.
                                @if ($voucher->hasBeenUsed())
                                    <strong>Sudah digunakan: {{ $voucher->getUsageCount() }} kali</strong>
                                @endif
                            </p>
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
                                id="starts_at" name="starts_at"
                                value="{{ old('starts_at', $voucher->starts_at ? $voucher->starts_at->format('Y-m-d') : '') }}">
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
                                id="expires_at" name="expires_at"
                                value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->format('Y-m-d') : '') }}">
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
                                    {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                                <label class="ml-3 block text-sm font-medium text-gray-700" for="is_active">
                                    Voucher Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- !SECTION: Main Form Section -->

        <!-- SECTION: Sidebar Section -->
        <div class="space-y-6">
            <!-- ANCHOR: Voucher Stats Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Voucher</h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="border-r border-gray-200">
                        <h4 class="text-xl sm:text-2xl font-bold text-pink-600">{{ $voucher->getUsageCount() }}</h4>
                        <p class="text-gray-500 text-xs sm:text-sm">Kali Digunakan</p>
                    </div>
                    <div>
                        <h4 class="text-xl sm:text-2xl font-bold text-green-600">
                            @if ($voucher->usage_limit)
                                {{ $voucher->usage_limit - $voucher->getUsageCount() }}
                            @else
                                ∞
                            @endif
                        </h4>
                        <p class="text-gray-500 text-xs sm:text-sm">Sisa Kuota</p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center space-y-2">
                    <p class="text-xs sm:text-sm">
                        <span class="font-medium">Status:</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ str_replace(['bg-', 'text-'], ['bg-', 'text-'], $voucher->status_badge_class) }}">
                            {{ $voucher->status_label }}
                        </span>
                    </p>
                    <p class="text-xs sm:text-sm text-gray-600">
                        <span class="font-medium">Dibuat:</span> {{ $voucher->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            <!-- ANCHOR: Preview Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Voucher</h3>
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 text-center">
                    <div class="mb-3">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-pink-600 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                            </path>
                        </svg>
                    </div>
                    <h5 class="font-bold text-base sm:text-lg text-gray-800 uppercase" id="preview-code">
                        {{ $voucher->code }}</h5>
                    <p class="text-gray-700 mb-2 text-sm sm:text-base" id="preview-name">{{ $voucher->name }}</p>
                    <p class="text-gray-500 text-xs sm:text-sm mb-3" id="preview-description">{{ $voucher->description }}
                    </p>
                    <div class="mb-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800"
                            id="preview-value">
                            {{ $voucher->formatted_value }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs" id="preview-conditions">
                            @php
                                $conditions = [];
                                if ($voucher->min_purchase) {
                                    $conditions[] =
                                        'Min. belanja ' .
                                        \App\Helpers\FormatHelper::formatCurrency($voucher->min_purchase);
                                }
                                if ($voucher->type === 'percentage' && $voucher->max_discount) {
                                    $conditions[] =
                                        'Maks. diskon ' .
                                        \App\Helpers\FormatHelper::formatCurrency($voucher->max_discount);
                                }
                            @endphp
                            {{ implode(' • ', $conditions) ?: 'Tidak ada syarat khusus' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- !SECTION: Sidebar Section -->
    </div>

    <!-- SECTION: Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 mt-8">
        <!-- ANCHOR: Cancel Button -->
        <a href="{{ route('admin.vouchers.index') }}"
            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-colors duration-200 text-center text-sm md:text-base order-2 sm:order-1">
            Batal
        </a>
        <!-- ANCHOR: Update Button -->
        <button type="submit" form="voucher-edit-form"
            class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2.5 md:py-3 px-4 md:px-8 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm md:text-base order-1 sm:order-2">
            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Update Voucher</span>
        </button>
    </div>
    <!-- !SECTION: Action Buttons -->

    <!-- SECTION: Custom Styles -->
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
    <!-- !SECTION: Custom Styles -->

    <!-- SECTION: JavaScript Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectInputTypeElement = document.getElementById('type');

            // ANCHOR: Update help text based on type
            selectInputTypeElement.addEventListener('change', function() {
                const valueHelp = document.getElementById('value-help');
                const maxDiscountGroup = document.getElementById('max-discount-group');
                const valueInputGroup = document.getElementById('value-input-group');
                const valueInput = document.getElementById('value');
                const valueSuffix = document.getElementById('value-suffix');

                console.log(selectInputTypeElement.value);

                switch (selectInputTypeElement.value) {
                    case 'percentage':
                        valueInputGroup.classList.remove('hidden');
                        valueHelp.textContent = 'Masukkan nilai persentase (contoh: 50 untuk 50%)';
                        maxDiscountGroup.classList.remove('hidden');
                        valueInput.min = '1';
                        valueInput.max = '100';
                        valueSuffix.textContent = '%';
                        valueInput.required = true;
                        break;
                    case 'fixed_amount':
                        valueInputGroup.classList.remove('hidden');
                        valueHelp.textContent = 'Masukkan nominal diskon dalam rupiah (min. Rp100)';
                        maxDiscountGroup.classList.add('hidden');
                        valueInput.min = '100';
                        valueInput.max = '';
                        valueSuffix.textContent = 'Rp';
                        valueInput.required = true;
                        break;
                    case 'free_shipping':
                        valueInputGroup.classList.add('hidden');
                        valueInput.value = '0'; // Set default value for free shipping
                        valueInput.required = false;
                        valueInput.min = '0';
                        valueInput.max = '';
                        valueInput.removeAttribute('required');
                        valueInput.removeAttribute('min');
                        valueInput.removeAttribute('max');
                        maxDiscountGroup.classList.add('hidden');
                        break;
                    default:
                        valueInputGroup.classList.remove('hidden');
                        valueHelp.textContent = 'Pilih jenis diskon terlebih dahulu';
                        maxDiscountGroup.classList.add('hidden');
                        valueInput.min = '0';
                        valueInput.max = '';
                        valueSuffix.textContent = '%';
                        valueInput.required = true;
                }

                // Clear validation error when type changes
                const validationError = document.getElementById('value-validation-error');
                if (validationError) {
                    validationError.classList.add('hidden');
                    validationError.textContent = '';
                }

                updatePreview();
            });

            // ANCHOR: Prevent form submission if disabled fields are modified
            document.querySelector('form').addEventListener('submit', function(e) {
                const typeSelect = selectInputTypeElement;
                const valueInput = document.getElementById('value');

                if (typeSelect.disabled && valueInput.disabled) {
                    // Remove disabled attribute temporarily to allow form submission
                    typeSelect.disabled = false;
                    valueInput.disabled = false;
                }
            });

            // ANCHOR: Update preview when form values change
            function updatePreview() {
                const code = document.getElementById('code').value || 'KODE VOUCHER';
                const name = document.getElementById('name').value || 'Nama Voucher';
                const description = document.getElementById('description').value ||
                    'Deskripsi voucher akan tampil di sini';
                const type = selectInputTypeElement.value;
                const value = document.getElementById('value').value;
                const minPurchase = document.getElementById('min_purchase').value;
                const maxDiscount = document.getElementById('max_discount').value;

                document.getElementById('preview-code').textContent = code;
                document.getElementById('preview-name').textContent = name;
                document.getElementById('preview-description').textContent = description;

                // Format value display
                let valueText = 'Diskon akan tampil di sini';
                if (type) {
                    switch (type) {
                        case 'percentage':
                            if (value) {
                                valueText = value + '% OFF';
                            }
                            break;
                        case 'fixed_amount':
                            if (value) {
                                valueText = 'Rp ' + parseInt(value).toLocaleString('id-ID');
                            }
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

                const conditionsText = conditions.length > 0 ? conditions.join(' • ') : 'Tidak ada syarat khusus';
                document.getElementById('preview-conditions').textContent = conditionsText;
            }

            // Add event listeners for preview updates
            ['code', 'name', 'description', 'value', 'min_purchase', 'max_discount'].forEach(id => {
                document.getElementById(id).addEventListener('input', updatePreview);
            });

            // ANCHOR: Real-time validation for value input
            document.getElementById('value').addEventListener('input', function() {
                const type = selectInputTypeElement.value;
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
                }
                // No validation needed for free_shipping as input is hidden
            });

            // ANCHOR: Format code to uppercase
            document.getElementById('code').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Initialize form based on current voucher type
            selectInputTypeElement.dispatchEvent(new Event('change'));

            // ANCHOR: Initialize preview for existing voucher
            updatePreview();

            // ANCHOR: Handle form submission for free_shipping type
            document.querySelector('form').addEventListener('submit', function(e) {
                const type = selectInputTypeElement.value;
                const valueInput = document.getElementById('value');

                if (type === 'free_shipping') {
                    // Remove required and min attributes for free_shipping
                    valueInput.removeAttribute('required');
                    valueInput.removeAttribute('min');
                    valueInput.removeAttribute('max');
                }
            });

            // ANCHOR: Validate date inputs
            function validateDate() {
                const startsAtInput = document.getElementById('starts_at');
                const expiresAtInput = document.getElementById('expires_at');

                if (startsAtInput.value && expiresAtInput.value) {
                    const startsAt = new Date(startsAtInput.value);
                    const expiresAt = new Date(expiresAtInput.value);

                    // Start date tidak boleh lebih dari end date
                    if (startsAt > expiresAt) {
                        startsAtInput.setCustomValidity('Tanggal mulai tidak boleh lebih dari tanggal berakhir');
                    } else {
                        startsAtInput.setCustomValidity('');
                    }

                    // End date tidak boleh kurang dari start date
                    if (expiresAt < startsAt) {
                        expiresAtInput.setCustomValidity('Tanggal berakhir tidak boleh kurang dari tanggal mulai');
                    } else {
                        expiresAtInput.setCustomValidity('');
                    }
                }
            }

            // Add validation to date inputs
            document.getElementById('starts_at').addEventListener('change', validateDate);
            document.getElementById('expires_at').addEventListener('change', validateDate);
        });
    </script>
    <!-- !SECTION: JavaScript Functionality -->

@endsection
