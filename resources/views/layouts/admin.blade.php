<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — EventPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.5rem 0.75rem; border-radius:0.5rem; color:#d1d5db; font-size:0.875rem; transition:all 0.15s; }
        .sidebar-link:hover { background:rgba(255,255,255,0.1); color:#fff; }
        .sidebar-link.active { background:rgba(255,255,255,0.15); color:#fff; font-weight:500; }
        .sidebar-section { font-size:0.7rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; padding:0 0.75rem; margin-top:1rem; margin-bottom:0.25rem; font-weight:600; }
        #sidebar { transition: transform 0.3s ease; }
        @media(max-width:768px){
            #sidebar { position:fixed; top:0; left:0; height:100vh; z-index:50; transform:translateX(-100%); }
            #sidebar.open { transform:translateX(0); }
            #sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:40; }
            #sidebar-overlay.open { display:block; }
        }
    </style>
</head>
<body class="bg-gray-100">
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 flex flex-col flex-shrink-0">
        <div class="p-4 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center"><i class="fas fa-calendar-check text-white text-sm"></i></div>
                <span class="text-white font-bold text-lg">EventPro</span>
            </a>
            <p class="text-gray-400 text-xs mt-1">{{ session('admin_role','Admin') }}</p>
        </div>
        <nav class="flex-1 overflow-y-auto p-3">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.events.index') }}" class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar w-4"></i> All Events
            </a>

            @if(isset($event))
            <div class="mt-4">
                <p class="sidebar-section">{{ \Illuminate\Support\Str::limit($event->name, 22) }}</p>

                <p class="sidebar-section mt-3">Tickets & Orders</p>
                <a href="{{ route('admin.tickets.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-4"></i> Tickets
                </a>
                <a href="{{ route('admin.orders.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt w-4"></i> Orders
                </a>
                <a href="{{ route('admin.attendees.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.attendees.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-4"></i> Attendees
                </a>

                <p class="sidebar-section mt-3">Event Tools</p>
                <a href="{{ route('admin.check-in.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.check-in.*') ? 'active' : '' }}">
                    <i class="fas fa-qrcode w-4"></i> Check-In
                </a>
                <a href="{{ route('admin.papers.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.papers.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt w-4"></i> Papers (CFP)
                </a>
                <a href="{{ route('admin.paper-fields.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.paper-fields.*') ? 'active' : '' }}">
                    <i class="fas fa-list-ul w-4"></i> Paper Fields
                </a>
                <a href="{{ route('admin.surveys.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                    <i class="fas fa-poll w-4"></i> Surveys
                </a>
                <a href="{{ route('admin.access-codes.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.access-codes.*') ? 'active' : '' }}">
                    <i class="fas fa-key w-4"></i> Access Codes
                </a>

                <p class="sidebar-section mt-3">Content</p>
                <a href="{{ route('admin.speakers.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.speakers.*') ? 'active' : '' }}">
                    <i class="fas fa-microphone w-4"></i> Speakers
                </a>
                <a href="{{ route('admin.schedule.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.schedule.*') ? 'active' : '' }}">
                    <i class="fas fa-clock w-4"></i> Schedule
                </a>
                <a href="{{ route('admin.sponsors.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake w-4"></i> Sponsors
                </a>
                <a href="{{ route('admin.exhibitors.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.exhibitors.*') ? 'active' : '' }}">
                    <i class="fas fa-store w-4"></i> Exhibitors
                </a>
                <a href="{{ route('admin.communications.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.communications.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope w-4"></i> Communications
                </a>
                <a href="{{ route('admin.website.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.website.*') ? 'active' : '' }}">
                    <i class="fas fa-globe w-4"></i> Website
                </a>
                <a href="{{ route('admin.badges.index', $event->id) }}" class="sidebar-link {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">
                    <i class="fas fa-id-badge w-4"></i> Badges
                </a>
                <a href="{{ route('event.show', $event->slug) }}" target="_blank" class="sidebar-link">
                    <i class="fas fa-external-link-alt w-4"></i> View Live Site
                </a>
            </div>
            @endif
        </nav>
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr(session('admin_name','A'),0,1)) }}</div>
                <div>
                    <p class="text-white text-xs font-medium">{{ session('admin_name','Admin') }}</p>
                    <p class="text-gray-400 text-xs">{{ session('admin_email','') }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="sidebar-link w-full"><i class="fas fa-sign-out-alt w-4"></i> Logout</button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-4 md:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs md:text-sm text-gray-500 hidden sm:block">@yield('page-subtitle', '')</p>
                </div>
            </div>
            <div class="flex items-center gap-2 md:gap-3">
                @yield('header-actions')
            </div>
        </header>
        @if(session('success'))
        <div class="bg-green-50 border-b border-green-200 px-6 py-3 text-green-700 text-sm flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('info'))
        <div class="bg-blue-50 border-b border-blue-200 px-6 py-3 text-blue-700 text-sm flex items-center gap-2">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
        @endif
        @if($errors->any())
        <div class="bg-red-50 border-b border-red-200 px-6 py-3">
            @foreach($errors->all() as $error)
            <p class="text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <main class="flex-1 overflow-y-auto p-3 md:p-6">
            @yield('content')
        </main>
    </div>
</div>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}
</script>
</body>
</html>
