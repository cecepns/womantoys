@extends('layouts.app')

@section('title', 'Payment Instructions - WomanToys')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Order Received</h1>
            <p class="text-lg text-gray-600">Thank you. Your order is being processed.</p>
        </div>

        <!-- Order Information -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Information</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold text-gray-800">INV-2025-0001</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Payment:</span>
                    <span class="text-2xl font-bold text-pink-600">Rp 1.520.000</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-semibold text-gray-800">January 15, 2025</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Status:</span>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pending Payment</span>
                </div>
            </div>
        </div>

        <!-- Important Warning Box -->
        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">IMPORTANT</h3>
                    <p class="text-yellow-800 mb-4">
                        Save or copy this page link. You will need this link to upload your payment proof later.
                    </p>
                    <button 
                        onclick="copyPageLink()" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        Copy Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Bank Account Details -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Make Payment To</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Bank Central Asia (BCA)</p>
                        <p class="text-sm text-gray-600">Account Number</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono font-semibold text-gray-800 text-lg">1234567890</p>
                        <p class="text-sm text-gray-600">a.n. WomanToys Store</p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Bank Mandiri</p>
                        <p class="text-sm text-gray-600">Account Number</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono font-semibold text-gray-800 text-lg">0987654321</p>
                        <p class="text-sm text-gray-600">a.n. WomanToys Store</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium">Payment Instructions:</p>
                        <ul class="mt-2 space-y-1">
                            <li>• Transfer the exact amount: <strong>Rp 1.520.000</strong></li>
                            <li>• Include your order number in the transfer description</li>
                            <li>• Upload payment proof within 24 hours</li>
                            <li>• Orders will be cancelled if payment is not confirmed</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Confirmation Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Confirm Your Payment</h2>
            
            <form class="space-y-6">
                <!-- Upload Payment Proof -->
                <div>
                    <label for="paymentProof" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Payment Proof
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition-colors duration-200">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-gray-600 mb-2">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-500">PNG, JPG, PDF up to 10MB</p>
                        <input 
                            type="file" 
                            id="paymentProof" 
                            name="paymentProof" 
                            accept=".png,.jpg,.jpeg,.pdf"
                            class="hidden"
                            required
                        >
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Add any additional information about your payment..."
                    ></textarea>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors duration-200 shadow-lg hover:shadow-xl"
                >
                    Confirm Payment
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-2">Need help? Contact our customer service:</p>
            <p class="text-pink-600 font-medium">WhatsApp: +62 812-3456-7890</p>
            <p class="text-pink-600 font-medium">Email: support@womantoys.com</p>
        </div>
    </div>
</div>

<script>
function copyPageLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Link Copied!';
        button.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
        button.classList.add('bg-green-600', 'hover:bg-green-700');
        
        setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('bg-green-600', 'hover:bg-green-700');
            button.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
        }, 2000);
    });
}

// File upload handling
document.getElementById('paymentProof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const uploadArea = document.querySelector('.border-dashed');
        uploadArea.innerHTML = `
            <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-green-600 font-medium mb-2">File selected successfully!</p>
            <p class="text-sm text-gray-500">${file.name}</p>
        `;
    }
});
</script>
@endsection
