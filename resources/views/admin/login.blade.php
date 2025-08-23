<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login - WomanToys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-sm w-full mx-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Admin Login</h2>
            <p class="text-gray-600">Enter your credentials to access admin panel</p>
        </div>

        <!-- Login Form -->
        <form class="space-y-6">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Enter your email"
                    required
                >
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Enter your password"
                    required
                >
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                    >
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-sm text-pink-600 hover:text-pink-700">
                    Forgot password?
                </a>
            </div>

            <!-- Login Button -->
            <button 
                type="submit" 
                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200"
            >
                Login
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Back to 
                <a href="/" class="text-pink-600 hover:text-pink-700 font-medium">Website</a>
            </p>
        </div>
    </div>

    <script>
        // Simple form handling (for demonstration purposes)
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // For now, just show an alert (no actual authentication)
            if (email && password) {
                alert('Login attempt recorded. This is a demo - no actual authentication is implemented.');
                // In a real application, you would send this data to your backend
                console.log('Login attempt:', { email, password });
            } else {
                alert('Please fill in all fields.');
            }
        });
    </script>
</body>
</html>
