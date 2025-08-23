<div id="ageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-md mx-4">
        <!-- Modal Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Age Verification Required</h2>
            <p class="text-gray-600">Please confirm your age to continue</p>
        </div>

        <!-- Modal Content -->
        <div class="text-center mb-8">
            <p class="text-gray-700 leading-relaxed">
                This website contains adult content and is intended for individuals aged 21 and above. 
                By entering this site, you confirm that you are at least 21 years old and agree to view adult-oriented materials.
            </p>
            
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-medium">Important Notice</p>
                        <p>You must be 21 years or older to access this website.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button 
                onclick="exitSite()" 
                class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200"
            >
                Exit Site
            </button>
            <button 
                onclick="confirmAge()" 
                class="flex-1 px-6 py-3 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700 transition-colors duration-200"
            >
                Yes, I'm 21+
            </button>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                By clicking "Yes, I'm 21+", you agree to our 
                <a href="#" class="text-pink-600 hover:text-pink-700">Terms of Service</a> and 
                <a href="#" class="text-pink-600 hover:text-pink-700">Privacy Policy</a>
            </p>
        </div>
    </div>
</div>

<script>
// Check if user has already confirmed age
document.addEventListener('DOMContentLoaded', function() {
    const ageConfirmed = localStorage.getItem('ageConfirmed');
    if (ageConfirmed === 'true') {
        document.getElementById('ageModal').style.display = 'none';
    }
});

function confirmAge() {
    // Store confirmation in localStorage
    localStorage.setItem('ageConfirmed', 'true');
    
    // Hide modal with fade out effect
    const modal = document.getElementById('ageModal');
    modal.style.transition = 'opacity 0.3s ease-out';
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

function exitSite() {
    // Redirect to a safe site or show exit message
    if (confirm('Are you sure you want to leave? This site contains adult content.')) {
        window.location.href = 'https://www.google.com';
    }
}

// Prevent closing modal by clicking outside (for age verification)
document.getElementById('ageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        // Optional: Show a message that they must make a choice
        alert('Please make a selection to continue.');
    }
});
</script>
