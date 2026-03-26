<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','My Portal') — EventPro Attendee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="flex h-screen overflow-hidden">
    <aside class="w-64 bg-gradient-to-b from-indigo-700 to-purple-800 flex flex-col flex-shrink-0">
        <div class="p-4 border-b border-white/20">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm">{{ session('attendee_name','Attendee') }}</p>
                    <p class="text-indigo-200 text-xs">{{ session('attendee_email','') }}</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-3 space-y-1">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.dashboard') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-home w-4"></i> My Dashboard
            </a>
            <a href="{{ route('portal.profile') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.profile') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-user-edit w-4"></i> My Profile
            </a>
            <a href="{{ route('portal.tickets') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.tickets') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-ticket-alt w-4"></i> My Tickets
            </a>
            <a href="{{ route('portal.schedule') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.schedule') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-calendar-alt w-4"></i> Schedule
            </a>
            <a href="{{ route('portal.surveys') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.surveys') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-poll w-4"></i> Surveys
            </a>
            <a href="{{ route('portal.papers') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-100 hover:bg-white/15 hover:text-white transition text-sm {{ request()->routeIs('portal.papers') ? 'bg-white/20 text-white font-medium' : '' }}">
                <i class="fas fa-file-alt w-4"></i> My Papers
            </a>
        </nav>
        <div class="p-3 border-t border-white/20">
            <form action="{{ route('portal.logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-3 py-2 rounded-lg text-indigo-200 hover:bg-white/10 hover:text-white w-full text-sm">
                    <i class="fas fa-sign-out-alt w-4"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-6 py-4">
            <h1 class="text-xl font-bold text-gray-800">@yield('page-title','My Portal')</h1>
            <p class="text-sm text-gray-500">@yield('page-subtitle','')</p>
        </header>
        @if(session('success'))
        <div class="bg-green-50 border-b border-green-200 px-6 py-3 text-green-700 text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="bg-red-50 border-b border-red-200 px-6 py-3">
            @foreach($errors->all() as $error)
            <p class="text-red-600 text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
