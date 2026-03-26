<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventPro — Multi-Event Management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .gradient-hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        @media print { .no-print { display: none !important; } .print-only { display: block !important; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
<nav class="bg-white shadow-sm sticky top-0 z-50 no-print">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-sm"></i>
                </div>
                <span class="font-bold text-xl text-indigo-700">EventPro</span>
            </a>
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">All Events</a>
                <a href="{{ route('portal.login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Attendee Portal</a>
                <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Admin Panel</a>
            </div>
        </div>
    </div>
</nav>
@if(session('success'))
<div class="bg-green-50 border-b border-green-200 px-4 py-3 text-green-700 text-sm text-center">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif
@if(session('info'))
<div class="bg-blue-50 border-b border-blue-200 px-4 py-3 text-blue-700 text-sm text-center">
    <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
</div>
@endif
@yield('content')
<footer class="bg-gray-900 text-white mt-20 no-print">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center"><i class="fas fa-calendar-check text-white text-sm"></i></div>
                <span class="font-bold text-lg">EventPro</span>
            </div>
            <p class="text-gray-400 text-sm">Professional multi-event management platform trusted by thousands of organizers worldwide.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Platform</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="{{ route('admin.events.index') }}" class="hover:text-white">All Events</a></li>
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white">Dashboard</a></li>
                <li><a href="{{ route('portal.login') }}" class="hover:text-white">Attendee Portal</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Features</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li>Ticket Management</li>
                <li>CFP & Peer Review</li>
                <li>Badge Generation</li>
                <li>Email Communications</li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Contact</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><i class="fas fa-envelope mr-2"></i>hello@eventpro.com</li>
                <li><i class="fas fa-phone mr-2"></i>+1 (555) 123-4567</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-800 py-6 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} EventPro. All rights reserved.</p>
        <p class="mt-1">Made with <span class="text-red-400">❤</span> by <a href="https://laracopilot.com/" target="_blank" class="text-indigo-400 hover:underline">LaraCopilot</a></p>
    </div>
</footer>
</body>
</html>
