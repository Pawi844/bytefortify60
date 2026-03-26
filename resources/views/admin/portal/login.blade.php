<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendee Portal Login — EventPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-700 to-purple-800 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4">
            <i class="fas fa-user-circle text-white text-3xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">Attendee Portal</h1>
        <p class="text-indigo-200 mt-1">Sign in to manage your registration</p>
    </div>
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('portal.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="your@email.com" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Password</label>
                <input type="password" name="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                <i class="fas fa-sign-in-alt mr-2"></i>Access My Portal
            </button>
        </form>
    </div>
    <div class="bg-white/10 backdrop-blur rounded-xl p-4 mt-4">
        <p class="text-white font-semibold text-sm mb-2"><i class="fas fa-info-circle mr-2 text-yellow-300"></i>How to Login</p>
        <p class="text-indigo-200 text-xs">Use your registration email address. Password = first 6 characters of your email (e.g. <span class="font-mono text-yellow-200">alice@</span> → <span class="font-mono text-yellow-200">alice@</span>)</p>
        <p class="text-indigo-200 text-xs mt-1">Demo: <span class="font-mono text-yellow-200">alice@example.com</span> / <span class="font-mono text-yellow-200">alice@</span></p>
    </div>
    <p class="text-center text-indigo-300 text-sm mt-4">
        <a href="{{ route('admin.login') }}" class="hover:text-white"><i class="fas fa-lock mr-1"></i>Admin Panel Login</a>
    </p>
</div>
</body>
</html>
