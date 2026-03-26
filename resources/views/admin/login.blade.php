<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — EventPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl mb-4">
            <i class="fas fa-calendar-check text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">EventPro Admin</h1>
        <p class="text-gray-400 mt-1">Sign in to manage your events</p>
    </div>
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Email Address</label>
                <input type="email" name="email" value="{{ old('email','admin@eventpro.com') }}" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Password</label>
                <input type="password" name="password" value="admin123" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In to Admin Panel
            </button>
        </form>
    </div>
    <div class="bg-white/10 backdrop-blur rounded-xl p-4 mt-4">
        <p class="text-white font-semibold text-sm mb-3"><i class="fas fa-key mr-2 text-yellow-300"></i>Demo Credentials</p>
        <div class="space-y-2">
            <div class="flex justify-between text-sm"><span class="text-gray-300">Super Admin:</span><span class="text-yellow-200 font-mono">admin@eventpro.com / admin123</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-300">Event Manager:</span><span class="text-yellow-200 font-mono">manager@eventpro.com / manager123</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-300">Staff:</span><span class="text-yellow-200 font-mono">staff@eventpro.com / staff123</span></div>
        </div>
    </div>
    <p class="text-center text-gray-400 text-sm mt-4">
        <a href="{{ route('portal.login') }}" class="text-indigo-300 hover:underline"><i class="fas fa-user mr-1"></i>Attendee Portal Login</a>
    </p>
</div>
</body>
</html>
