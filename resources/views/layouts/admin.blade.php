<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | LaptopExpert AI</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #060612; font-family: 'Plus Jakarta Sans', sans-serif;" class="min-h-screen">

<!-- ===================================================
     MOBILE SIDEBAR OVERLAY
     =================================================== -->
<div id="sidebar-overlay"
     class="fixed inset-0 z-40 lg:hidden"
     style="background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); opacity:0; pointer-events:none; transition: opacity 0.3s ease;"
     onclick="closeSidebar()">
</div>

<div class="flex min-h-screen">

    <!-- ===================================================
         SIDEBAR
         =================================================== -->
    <aside id="admin-sidebar"
           class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col"
           style="background: rgba(8,8,18,0.98);
                  border-right: 1px solid rgba(255,255,255,0.06);
                  backdrop-filter: blur(24px);
                  transform: translateX(-100%);
                  transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);">

        <!-- Logo + Close btn -->
        <div class="flex items-center justify-between px-5 py-4 border-b" style="border-color: rgba(255,255,255,0.07);">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 transition-all group-hover:scale-105"
                     style="background: linear-gradient(135deg, #4f46e5, #7c3aed); box-shadow: 0 4px 16px rgba(99,102,241,0.4);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-display font-bold text-white text-sm leading-none tracking-tight">LaptopExpert</div>
                    <div class="text-[10px] mt-0.5 font-semibold tracking-widest uppercase" style="color: #6366f1;">Admin Panel</div>
                </div>
            </a>
            <!-- Close button (mobile only) -->
            <button onclick="closeSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-600 hover:text-white hover:bg-white/10 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto" style="scrollbar-width: thin;">

            <!-- Overview -->
            <div class="px-3 pt-2 pb-2">
                <p class="text-[9px] font-bold text-slate-700 uppercase tracking-[0.12em]">Overview</p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                Dashboard
            </a>

            <!-- Basis Pengetahuan -->
            <div class="px-3 pt-5 pb-2">
                <p class="text-[9px] font-bold text-slate-700 uppercase tracking-[0.12em]">Basis Pengetahuan</p>
            </div>

            <a href="{{ route('admin.kerusakan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.kerusakan*') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/>
                </svg>
                Kerusakan
                <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-md"
                      style="background: rgba(99,102,241,0.18); color: #a5b4fc;">K</span>
            </a>

            <a href="{{ route('admin.gejala.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.gejala*') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/>
                    <path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/>
                    <path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/>
                </svg>
                Gejala
                <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-md"
                      style="background: rgba(139,92,246,0.18); color: #c4b5fd;">G</span>
            </a>

            <a href="{{ route('admin.rules.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.rules*') ? 'active' : '' }}" onclick="closeSidebarOnMobile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
                Rules & CF
                <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-md"
                      style="background: rgba(236,72,153,0.18); color: #f9a8d4;">CF</span>
            </a>

            <!-- Data Pengguna -->
            <div class="px-3 pt-5 pb-2">
                <p class="text-[9px] font-bold text-slate-700 uppercase tracking-[0.12em]">Data</p>
            </div>

            <a href="{{ route('diagnosa.riwayat') }}" target="_blank"
               class="sidebar-link" onclick="closeSidebarOnMobile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                    <path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                </svg>
                Riwayat Diagnosa
                <svg class="ml-auto opacity-30" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    <polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/>
                </svg>
            </a>
        </nav>

        <!-- Bottom: User Info + Back to site -->
        <div class="px-3 py-4 border-t space-y-1" style="border-color: rgba(255,255,255,0.07);">
            <!-- User badge -->
            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl mb-1"
                 style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.18);">
                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                     style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ session('admin_name', 'Administrator') }}</p>
                    <p class="text-[10px] text-indigo-400">Super Admin</p>
                </div>
                <div class="relative">
                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-60"></div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="sidebar-link text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Kembali ke Situs
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left text-red-500/60 hover:text-red-400 hover:bg-red-400/10"
                        style="border: none; cursor: pointer; background: none; font-family: inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ===================================================
         MAIN CONTENT AREA
         =================================================== -->
    <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

        <!-- TOP BAR -->
        <header class="sticky top-0 z-30 flex items-center justify-between px-4 py-3"
                style="background: rgba(6,6,18,0.92);
                       border-bottom: 1px solid rgba(255,255,255,0.06);
                       backdrop-filter: blur(24px);">

            <div class="flex items-center gap-3">
                <!-- Hamburger (mobile) -->
                <button id="sidebar-toggle"
                        onclick="openSidebar()"
                        class="lg:hidden flex flex-col gap-1.5 p-2 rounded-xl hover:bg-white/10 transition-all group">
                    <span class="block w-5 h-0.5 rounded-full bg-slate-400 group-hover:bg-white transition-all"></span>
                    <span class="block w-4 h-0.5 rounded-full bg-slate-400 group-hover:bg-white transition-all" style="margin-left: auto;"></span>
                    <span class="block w-5 h-0.5 rounded-full bg-slate-400 group-hover:bg-white transition-all"></span>
                </button>

                <!-- Logo (mobile only, when sidebar is closed) -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 lg:hidden">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                         style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-white text-sm">Admin</span>
                </a>

                <!-- Breadcrumb (desktop) -->
                <div class="hidden lg:flex items-center gap-2 text-sm text-slate-500">
                    <a href="{{ route('admin.dashboard') }}"
                       class="hover:text-white transition-colors font-medium flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                        Admin
                    </a>
                    @hasSection('breadcrumb')
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    @yield('breadcrumb')
                    @endif
                </div>
            </div>

            <!-- Right actions -->
            <div class="flex items-center gap-2">
                <a href="{{ route('diagnosa.form') }}" target="_blank"
                   class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 hover:text-white hover:bg-white/8 transition-all border border-white/8 hover:border-white/15">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/>
                    </svg>
                    Lihat Situs
                </a>

                <!-- Admin badge -->
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium"
                     style="background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.22);">
                    <div class="relative">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                        <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-70"></div>
                    </div>
                    <span class="text-indigo-300 font-semibold">{{ session('admin_name', 'Admin') }}</span>
                </div>

                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-red-400 hover:bg-red-400/10 transition-all border border-transparent hover:border-red-400/20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" x2="9" y1="12" y2="12"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-4 md:p-6 overflow-x-hidden">

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mb-5 p-4 rounded-xl flex items-center gap-3 text-sm animate-fadeInUp"
                 style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background: rgba(16,185,129,0.2);">
                    <svg class="text-emerald-400" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <span class="text-emerald-300 font-medium flex-1">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-400 transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-5 p-4 rounded-xl flex items-center gap-3 text-sm animate-fadeInUp"
                 style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background: rgba(239,68,68,0.15);">
                    <svg class="text-red-400" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>
                    </svg>
                </div>
                <span class="text-red-300 font-medium flex-1">{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
// =======================================
// SIDEBAR TOGGLE — MOBILE
// =======================================
const sidebar  = document.getElementById('admin-sidebar');
const overlay  = document.getElementById('sidebar-overlay');
const isLg     = () => window.innerWidth >= 1024;

function openSidebar() {
    if (isLg()) return;
    sidebar.style.transform = 'translateX(0)';
    overlay.style.opacity = '1';
    overlay.style.pointerEvents = 'all';
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    if (isLg()) return;
    sidebar.style.transform = 'translateX(-100%)';
    overlay.style.opacity = '0';
    overlay.style.pointerEvents = 'none';
    document.body.style.overflow = '';
}

function closeSidebarOnMobile() {
    if (!isLg()) closeSidebar();
}

// Always show sidebar on desktop
function handleResize() {
    if (isLg()) {
        sidebar.style.transform = 'translateX(0)';
        overlay.style.opacity  = '0';
        overlay.style.pointerEvents = 'none';
        document.body.style.overflow = '';
    } else {
        // Only close if it's "open" on mobile
        if (overlay.style.opacity !== '1') {
            sidebar.style.transform = 'translateX(-100%)';
        }
    }
}

window.addEventListener('resize', handleResize);
handleResize(); // init

// =======================================
// SWIPE TO OPEN / CLOSE (Touch)
// =======================================
let touchStartX = 0;
let touchStartY = 0;

document.addEventListener('touchstart', e => {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
}, { passive: true });

document.addEventListener('touchend', e => {
    if (isLg()) return;
    const dx = e.changedTouches[0].clientX - touchStartX;
    const dy = Math.abs(e.changedTouches[0].clientY - touchStartY);

    // Swipe right from left edge → open
    if (touchStartX < 24 && dx > 60 && dy < 80) openSidebar();

    // Swipe left → close
    if (dx < -60 && dy < 80 && overlay.style.opacity === '1') closeSidebar();
}, { passive: true });

// =======================================
// AUTO-HIDE FLASH MESSAGES
// =======================================
setTimeout(() => {
    document.querySelectorAll('.animate-fadeInUp').forEach(el => {
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(() => el.remove(), 500);
    });
}, 4500);
</script>

@stack('scripts')
</body>
</html>
