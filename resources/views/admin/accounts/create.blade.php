@extends('admin.layouts.app')

@section('title', 'Tambah Rekening Bank - Admin Panel')

@section('page-title', 'Tambah Rekening Bank')
@section('page-description', 'Buat rekening bank baru untuk pembayaran')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-6 flex-col sm:flex-row gap-4 sm:gap-0">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Rekening Bank</h1>
        <p class="text-gray-600">Buat rekening bank baru untuk pembayaran</p>
    </div>
    <a href="{{ route('admin.accounts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto text-center">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<!-- Form Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200">
    <div class="p-6">
        <form action="{{ route('admin.accounts.store') }}" method="POST">
            @csrf
            
            <!-- Bank Name -->
            <div class="mb-6">
                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Bank <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="bank_name" 
                    name="bank_name" 
                    value="{{ old('bank_name') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bank_name') border-red-500 @enderror"
                    placeholder="Contoh: Bank Central Asia (BCA)"
                    required
                >
                @error('bank_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan nama bank yang akan digunakan untuk pembayaran.</p>
            </div>

            <!-- Account Number -->
            <div class="mb-6">
                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Rekening <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="account_number" 
                    name="account_number" 
                    value="{{ old('account_number') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('account_number') border-red-500 @enderror"
                    placeholder="Contoh: 1234567890"
                    required
                >
                @error('account_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan nomor rekening bank yang valid.</p>
            </div>

            <!-- Account Holder -->
            <div class="mb-6">
                <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-2">
                    Atas Nama (Pemilik Rekening) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="account_holder" 
                    name="account_holder" 
                    value="{{ old('account_holder') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('account_holder') border-red-500 @enderror"
                    placeholder="Contoh: PT. Woman Toys Indonesia"
                    required
                >
                @error('account_holder')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan nama pemilik rekening sesuai dengan buku tabungan.</p>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih Status</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Pilih status rekening untuk menentukan apakah dapat digunakan untuk pembayaran.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('admin.accounts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Rekening
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
