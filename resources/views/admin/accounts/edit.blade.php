@extends('admin.layouts.app')

@section('title', 'Edit Bank Account - Admin Panel')

@section('page-title', 'Edit Rekening Bank')
@section('page-description', 'Edit data rekening bank yang sudah ada')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Rekening: {{ $account->bank_name }}</h1>
            <p class="text-gray-600 mt-2">Edit data rekening bank yang sudah ada</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

    <!-- Formulir Rekening -->
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.accounts.update', $account) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Nama Bank -->
            <div class="mb-6">
                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Bank
                </label>
                <input 
                    type="text" 
                    id="bank_name" 
                    name="bank_name" 
                    value="{{ old('bank_name', $account->bank_name) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Bank Central Asia (BCA)"
                    required
                >
            </div>

            <!-- Nomor Rekening -->
            <div class="mb-6">
                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Rekening
                </label>
                <input 
                    type="text" 
                    id="account_number" 
                    name="account_number" 
                    value="{{ old('account_number', $account->account_number) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: 1234567890"
                    required
                >
            </div>

            <!-- Atas Nama -->
            <div class="mb-6">
                <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-2">
                    Atas Nama (Pemilik Rekening)
                </label>
                <input 
                    type="text" 
                    id="account_holder" 
                    name="account_holder" 
                    value="{{ old('account_holder', $account->account_holder_name) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: PT. Woman Toys Indonesia"
                    required
                >
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >
                    <option value="">Pilih Status</option>
                    <option value="active" {{ old('status', $account->is_active ? 'active' : 'inactive') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $account->is_active ? 'active' : 'inactive') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition duration-200"
                >
                    Update Rekening
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
