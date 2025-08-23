@extends('admin.layouts.app')

@section('title', 'Order Detail - Admin Panel')

@section('page-title', 'Detail Pesanan: INV-2025-0001')
@section('page-description', 'Lihat detail lengkap pesanan pelanggan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan: INV-2025-0001</h1>
            <p class="text-gray-600 mt-2">Lihat detail lengkap pesanan pelanggan</p>
        </div>
        <a href="/admin/orders" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>
</div>

<!-- Order Status Banner -->
<div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <div class="flex items-center">
        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-yellow-800">Status: Menunggu Konfirmasi</h3>
            <p class="text-yellow-700">Pesanan dibuat pada 23 Januari 2025 pukul 14:30 WIB</p>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pelanggan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">Sarah Johnson</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900">+62 812-3456-7890</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900">sarah@email.com</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                    <p class="text-gray-900">
                        Jl. Sudirman No. 123, RT 001/RW 002<br>
                        Kelurahan Senayan, Kecamatan Kebayoran Baru<br>
                        Jakarta Selatan, DKI Jakarta 12190
                    </p>
                </div>
            </div>
        </div>

        <!-- Products Ordered -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Produk yang Dipesan
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga Satuan
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 mr-3">
                                        <img 
                                            src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                            alt="Product 1"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Lelo Sona Cruise 2</div>
                                        <div class="text-sm text-gray-500">Pink, Medium Size</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">1</td>
                            <td class="px-4 py-4 text-sm text-gray-900">Rp 1.500.000</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">Rp 1.500.000</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 mr-3">
                                        <img 
                                            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                            alt="Product 2"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">We-Vibe Tango X</div>
                                        <div class="text-sm text-gray-500">Black, Standard</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">1</td>
                            <td class="px-4 py-4 text-sm text-gray-900">Rp 350.000</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">Rp 350.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Rincian Pembayaran
            </h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Subtotal Produk</span>
                    <span class="text-gray-900">Rp 1.850.000</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Biaya Pengiriman</span>
                    <span class="text-gray-900">Rp 15.000</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Biaya Layanan</span>
                    <span class="text-gray-900">Rp 5.000</span>
                </div>
                
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total Pembayaran</span>
                        <span class="text-lg font-bold text-pink-600">Rp 1.870.000</span>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="text-gray-900 font-medium">Transfer Bank BCA</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mt-1">
                        <span class="text-gray-600">Status Pembayaran</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            Lunas
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Actions & Transfer Proof -->
    <div class="space-y-6">
        <!-- Status Management -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Ubah Status Pesanan
            </h2>
            
            <form class="space-y-4">
                <div>
                    <label for="order_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Pesanan Saat Ini
                    </label>
                    <select
                        id="order_status"
                        name="order_status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    >
                        <option value="pending" selected>Menunggu Konfirmasi</option>
                        <option value="processing">Diproses</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                
                <button
                    type="submit"
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Update Status
                </button>
            </form>
        </div>

        <!-- Transfer Proof -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Bukti Transfer Pelanggan
            </h2>
            
            <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <img 
                        id="transfer_proof"
                        src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                        alt="Bukti Transfer"
                        class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity duration-200"
                        onclick="openImageModal(this.src)"
                    >
                    <p class="text-sm text-gray-500 mt-2">Klik untuk melihat gambar lebih besar</p>
                </div>
                
                <div class="text-sm text-gray-600 space-y-1">
                    <p><strong>Bank Pengirim:</strong> BCA</p>
                    <p><strong>Nama Pengirim:</strong> Sarah Johnson</p>
                    <p><strong>Tanggal Transfer:</strong> 23 Jan 2025, 15:45 WIB</p>
                    <p><strong>Jumlah Transfer:</strong> Rp 1.870.000</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Aksi Cepat
            </h2>
            
            <div class="space-y-3">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Kirim Email Konfirmasi
                </button>
                
                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Cetak Invoice
                </button>
                
                <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Kirim Pesan WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Bukti Transfer" class="max-w-full max-h-full object-contain">
        <button 
            onclick="closeImageModal()" 
            class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
// Image modal functionality
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Status update form handling
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const status = document.getElementById('order_status').value;
    const statusText = document.getElementById('order_status').options[document.getElementById('order_status').selectedIndex].text;
    
    // Show confirmation
    if (confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi "${statusText}"?`)) {
        // In real app, this would send update request
        alert(`Status pesanan berhasil diubah menjadi "${statusText}"`);
        
        // Update the status banner
        const statusBanner = document.querySelector('.bg-yellow-50');
        const statusTextElement = statusBanner.querySelector('h3');
        
        // Update banner color based on status
        statusBanner.className = 'mb-6 border rounded-lg p-4';
        statusTextElement.className = 'text-lg font-semibold';
        
        switch(status) {
            case 'pending':
                statusBanner.classList.add('bg-yellow-50', 'border-yellow-200');
                statusTextElement.classList.add('text-yellow-800');
                statusTextElement.textContent = 'Status: Menunggu Konfirmasi';
                break;
            case 'processing':
                statusBanner.classList.add('bg-blue-50', 'border-blue-200');
                statusTextElement.classList.add('text-blue-800');
                statusTextElement.textContent = 'Status: Diproses';
                break;
            case 'completed':
                statusBanner.classList.add('bg-green-50', 'border-green-200');
                statusTextElement.classList.add('text-green-800');
                statusTextElement.textContent = 'Status: Selesai';
                break;
            case 'cancelled':
                statusBanner.classList.add('bg-red-50', 'border-red-200');
                statusTextElement.classList.add('text-red-800');
                statusTextElement.textContent = 'Status: Dibatalkan';
                break;
        }
    }
});

// Quick action buttons
document.querySelectorAll('.bg-blue-600, .bg-green-600, .bg-purple-600').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const action = this.textContent.trim();
        alert(`${action} akan dikirim ke pelanggan`);
    });
});
</script>
@endsection
