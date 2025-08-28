@extends('admin.layouts.app')

@section('title', 'Dashboard - Panel Admin')

@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan performa toko Anda')

@section('content')
<!-- Welcome Section -->
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-base md:text-lg text-gray-600">Selamat Datang Kembali, Admin!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <!-- Total Orders Card -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-3 md:mt-4">
            <span class="text-xs md:text-sm {{ $orderGrowth >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">{{ $orderGrowth >= 0 ? '+' : '' }}{{ $orderGrowth }}%</span>
            <span class="text-xs md:text-sm text-gray-600">dari bulan lalu</span>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Produk</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="mt-3 md:mt-4">
            <span class="text-xs md:text-sm text-green-600 font-medium">+{{ $newProductsThisMonth }}</span>
            <span class="text-xs md:text-sm text-gray-600">produk baru bulan ini</span>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pendapatan</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $formattedTotalRevenue }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>
        <div class="mt-3 md:mt-4">
            <span class="text-xs md:text-sm {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</span>
            <span class="text-xs md:text-sm text-gray-600">dari bulan lalu</span>
        </div>
    </div>

    <!-- Pending Orders Card -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200 ">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pesanan Pending</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ number_format($pendingOrders) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-3 md:mt-4">
            <span class="text-xs md:text-sm {{ $pendingChange >= 0 ? 'text-red-600' : 'text-green-600' }} font-medium">{{ $pendingChange >= 0 ? '+' : '' }}{{ $pendingChange }}</span>
            <span class="text-xs md:text-sm text-gray-600">dari kemarin</span>
        </div>
    </div>
</div>

<!-- Revenue Breakdown Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    <!-- Today's Revenue -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ 'Rp ' . number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- This Week's Revenue -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pendapatan Minggu Ini</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ 'Rp ' . number_format($thisWeekRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Revenue -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pendapatan Pending</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ 'Rp ' . number_format($pendingRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-xs text-yellow-600">Menunggu konfirmasi pembayaran</span>
        </div>
    </div>
</div>

<!-- Order Status Breakdown Section -->
<div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6 md:mb-8">
    <div class="p-4 md:p-6 border-b border-gray-200">
        <h3 class="text-base md:text-lg font-semibold text-gray-800">Breakdown Status Pesanan</h3>
        <p class="text-xs md:text-sm text-gray-600">Distribusi pesanan berdasarkan status</p>
    </div>
    <div class="p-4 md:p-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            <!-- Pending Payment -->
            <div class="text-center p-3 md:p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="text-xl md:text-2xl font-bold text-yellow-700">{{ $orderStatusBreakdown['pending_payment'] }}</div>
                <div class="text-xs md:text-sm text-yellow-600 font-medium">Menunggu Pembayaran</div>
            </div>
            
            <!-- Paid -->
            <div class="text-center p-3 md:p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="text-xl md:text-2xl font-bold text-green-700">{{ $orderStatusBreakdown['paid'] }}</div>
                <div class="text-xs md:text-sm text-green-600 font-medium">Sudah Dibayar</div>
            </div>
            
            <!-- Processing -->
            <div class="text-center p-3 md:p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="text-xl md:text-2xl font-bold text-blue-700">{{ $orderStatusBreakdown['processing'] }}</div>
                <div class="text-xs md:text-sm text-blue-600 font-medium">Sedang Diproses</div>
            </div>
            
            <!-- Shipped -->
            <div class="text-center p-3 md:p-4 bg-purple-50 rounded-lg border border-purple-200">
                <div class="text-xl md:text-2xl font-bold text-purple-700">{{ $orderStatusBreakdown['shipped'] }}</div>
                <div class="text-xs md:text-sm text-purple-600 font-medium">Dikirim</div>
            </div>
            
            <!-- Delivered -->
            <div class="text-center p-3 md:p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="text-xl md:text-2xl font-bold text-gray-700">{{ $orderStatusBreakdown['delivered'] }}</div>
                <div class="text-xs md:text-sm text-gray-600 font-medium">Diterima</div>
            </div>
            
            <!-- Cancelled -->
            <div class="text-center p-3 md:p-4 bg-red-50 rounded-lg border border-red-200">
                <div class="text-xl md:text-2xl font-bold text-red-700">{{ $orderStatusBreakdown['cancelled'] }}</div>
                <div class="text-xs md:text-sm text-red-600 font-medium">Dibatalkan</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-4 md:p-6 border-b border-gray-200">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
        </div>
        <div class="p-4 md:p-6">
            <div class="space-y-3 md:space-y-4">
                @forelse($recentOrders as $order)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-sm md:text-base text-gray-800 truncate">{{ $order->order_number }}</p>
                            <p class="text-xs md:text-sm text-gray-600 truncate">
                                @if($order->orderItems->count() > 0)
                                    {{ $order->orderItems->first()->product->name }}
                                    @if($order->orderItems->count() > 1)
                                        +{{ $order->orderItems->count() - 1 }} item lainnya
                                    @endif
                                @else
                                    Tidak ada item
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center justify-between sm:flex-col sm:items-end sm:justify-start gap-2 sm:gap-1">
                            <p class="font-medium text-sm md:text-base text-gray-800">{{ $order->formatted_total_amount }}</p>
                            @php
                                $statusConfig = match($order->status) {
                                    'menunggu_pembayaran' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Menunggu'],
                                    'sudah_dibayar' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Dibayar'],
                                    'sedang_diproses' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Diproses'],
                                    'dikirim' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Dikirim'],
                                    'diterima' => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Diterima'],
                                    'dibatalkan' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Dibatalkan'],
                                    default => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Unknown']
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs {{ $statusConfig['class'] }} rounded-full whitespace-nowrap">{{ $statusConfig['text'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 md:py-8">
                        <p class="text-sm md:text-base text-gray-500">Belum ada pesanan</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-4 md:mt-6">
                <a href="/admin/orders" class="text-pink-600 hover:text-pink-700 font-medium text-sm md:text-base">Lihat Semua Pesanan →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="p-4 md:p-6 border-b border-gray-200">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Aksi Cepat</h3>
        </div>
        <div class="p-4 md:p-6">
            <div class="space-y-3 md:space-y-4">
                <a href="/admin/products" class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-sm md:text-base text-gray-800">Tambah Produk Baru</p>
                        <p class="text-xs md:text-sm text-gray-600">Tambah produk baru ke katalog</p>
                    </div>
                </a>
                <a href="/admin/carousel" class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-sm md:text-base text-gray-800">Kelola Carousel</p>
                        <p class="text-xs md:text-sm text-gray-600">Update gambar carousel homepage</p>
                    </div>
                </a>
                <a href="/admin/orders" class="flex items-center p-3 md:p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-sm md:text-base text-gray-800">Kelola Pesanan</p>
                        <p class="text-xs md:text-sm text-gray-600">Lihat dan update status pesanan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
