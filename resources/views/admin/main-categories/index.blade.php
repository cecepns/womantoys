@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori Utama - Admin Panel')

@section('page-title', 'Manajemen Kategori Utama')
@section('page-description', 'Kelola kategori utama produk')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8 flex-col sm:flex-row gap-4 sm:gap-0">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Daftar Kategori Utama</h1>
        <p class="text-gray-600 mt-2">Kelola kategori utama produk Anda</p>
    </div>
    <a href="{{ route('admin.main-categories.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center w-full sm:w-auto justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Kategori Utama
    </a>
</div>

<!-- Main Categories Table -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Kategori Utama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        Slug
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                        Jumlah Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                        Tanggal Dibuat
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mainCategories as $index => $mainCategory)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $mainCategory->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            <div class="text-sm text-gray-500">{{ $mainCategory->slug }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $mainCategory->categories_count }} kategori
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                            {{ $mainCategory->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('admin.main-categories.edit', $mainCategory) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 w-full sm:w-auto text-center">
                                Edit
                            </a>
                            <form action="{{ route('admin.main-categories.destroy', $mainCategory) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori utama ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 w-full sm:w-auto">
                                    Hapus
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada kategori utama yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
