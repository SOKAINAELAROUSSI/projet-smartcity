<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>SmartCity - @yield('title', 'Tableau de Bord Technicien')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 80px;
            --bg-color: #f8fafc;
            --card-bg: white;
            --text-color: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --sidebar-bg: white;
            --topbar-bg: white;
            --link-hover-bg: #f8fafc;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        body.dark-theme {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --text-color: #f3f4f6;
            --text-muted: #9ca3af;
            --border-color: #1f2937;
            --sidebar-bg: #111827;
            --topbar-bg: #111827;
            --link-hover-bg: #1f2937;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            z-index: 1005;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .sidebar-logo {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            border-bottom: 1px solid var(--border-color);
            transition: border-color 0.3s;
        }

        .sidebar-menu {
            padding: 24px 16px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .menu-item:hover {
            background: var(--link-hover-bg);
            color: var(--text-color);
        }

        .menu-item.active {
            background: #10b981;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }

        .menu-item svg {
            width: 20px;
            height: 20px;
        }

        /* Badges in menu */
        .menu-badge {
            margin-left: auto;
            background: #10b981;
            color: white;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 100px;
        }

        .menu-item.active .menu-badge {
            background: white;
            color: #10b981;
        }

        /* Topbar */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            z-index: 1000;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Main Content */
        .main-content {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 30px 40px;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Utilities */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--box-shadow);
            padding: 24px;
            transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        /* RTL overrides */
        body.rtl-layout .sidebar {
            left: auto;
            right: 0;
            border-right: none;
            border-left: 1px solid var(--border-color);
        }
        body.rtl-layout .topbar {
            left: 0;
            right: var(--sidebar-width);
        }
        body.rtl-layout .main-content {
            margin-left: 0;
            margin-right: var(--sidebar-width);
        }
        @media (max-width: 1024px) {
            body.rtl-layout .sidebar {
                transform: translateX(100%);
            }
            body.rtl-layout .sidebar.show {
                transform: translateX(0);
            }
            body.rtl-layout .topbar {
                right: 0;
            }
            body.rtl-layout .main-content {
                margin-right: 0;
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
                padding: 0 20px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .menu-toggle {
                display: block !important;
            }
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }
    </style>
</head>

@php
    $layoutLang = Auth::user()->technicianProfile->language ?? 'fr';
    $sidebarTranslations = [
        'fr' => [
            'dashboard' => 'Tableau de bord',
            'missions' => 'Mes missions',
            'map' => 'Carte des missions',
            'history' => 'Historique',
            'stats' => 'Statistiques',
            'reviews' => 'Évaluations',
            'notifications' => 'Notifications',
            'profile' => 'Profil',
            'settings' => 'Paramètres',
            'help_title' => 'Besoin d\'aide ?',
            'help_sub' => 'Contactez l\'administrateur',
            'contact' => 'Contacter',
            'logout' => 'Déconnexion',
            'back_to_site' => 'Retour au site',
            'hello' => 'Bonjour',
            'overview' => 'Voici un aperçu de vos interventions aujourd\'hui.',
            'technician' => 'Technicien'
        ],
        'ar' => [
            'dashboard' => 'لوحة القيادة',
            'missions' => 'مهامي',
            'map' => 'خارطة المهام',
            'history' => 'الأرشيف والسجل',
            'stats' => 'الإحصائيات',
            'reviews' => 'التقييمات',
            'notifications' => 'الإشعارات',
            'profile' => 'الملف الشخصي',
            'settings' => 'الإعدادات',
            'help_title' => 'هل تحتاج مساعدة؟',
            'help_sub' => 'اتصل بالمسؤول',
            'contact' => 'اتصال',
            'logout' => 'تسجيل الخروج',
            'back_to_site' => 'العودة إلى الموقع',
            'hello' => 'مرحباً',
            'overview' => 'إليك لمحة عامة عن تدخلاتك اليوم.',
            'technician' => 'تقني'
        ],
        'en' => [
            'dashboard' => 'Dashboard',
            'missions' => 'My Missions',
            'map' => 'Missions Map',
            'history' => 'History',
            'stats' => 'Statistics',
            'reviews' => 'Reviews',
            'notifications' => 'Notifications',
            'profile' => 'Profile',
            'settings' => 'Settings',
            'help_title' => 'Need Help?',
            'help_sub' => 'Contact administrator',
            'contact' => 'Contact',
            'logout' => 'Logout',
            'back_to_site' => 'Back to Site',
            'hello' => 'Hello',
            'overview' => 'Here is an overview of your interventions today.',
            'technician' => 'Technician'
        ]
    ];
    $sideTexts = $sidebarTranslations[$layoutLang] ?? $sidebarTranslations['fr'];
    $isRTL = ($layoutLang === 'ar');
@endphp

<body class="{{ Auth::user()->technicianProfile->theme ?? 'light' }}-theme {{ $isRTL ? 'rtl-layout' : '' }}" style="direction: {{ $isRTL ? 'rtl' : 'ltr' }}; text-align: {{ $isRTL ? 'right' : 'left' }};">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 36px; height: 36px; object-fit: contain; border-radius: 8px;">
            <div style="display: flex; flex-direction: column; line-height: 1.1;">
                <span
                    style="font-weight: 900; font-size: 1.1rem; color: #0f172a; font-family: 'Outfit', sans-serif;">Smart
                    City</span>
                <span
                    style="font-weight: 800; font-size: 1rem; color: #10b981; font-family: 'Outfit', sans-serif;">Connect</span>
            </div>
        </a>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                {{ $sideTexts['dashboard'] }}
            </a>
            <a href="{{ route('technician.missions.index') }}" class="menu-item {{ request()->routeIs('technician.missions.*') && request('status') !== 'terminee' ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                {{ $sideTexts['missions'] }}
            </a>
            <a href="{{ route('technician.map') }}" class="menu-item {{ request()->routeIs('technician.map') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                    <line x1="15" y1="3" x2="15" y2="21"></line>
                </svg>
                {{ $sideTexts['map'] }}
            </a>
            <a href="{{ route('technician.missions.index', ['status' => 'terminee']) }}" class="menu-item {{ request('status') === 'terminee' ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                {{ $sideTexts['history'] }}
            </a>
            <a href="{{ route('technician.stats') }}" class="menu-item {{ request()->routeIs('technician.stats') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                {{ $sideTexts['stats'] }}
            </a>
            <a href="{{ route('technician.reviews') }}" class="menu-item {{ request()->routeIs('technician.reviews') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                    </polygon>
                </svg>
                {{ $sideTexts['reviews'] }}
            </a>
            @php
                $realNotifCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
            @endphp
            <a href="{{ route('technician.notifications') }}" class="menu-item {{ request()->routeIs('technician.notifications') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                {{ $sideTexts['notifications'] }}
                @if($realNotifCount > 0)
                    <span class="menu-badge" style="background: #ef4444;">{{ $realNotifCount }}</span>
                @endif
            </a>

            <div style="margin-top: auto;"></div>

            <a href="{{ route('technician.settings') }}" class="menu-item {{ request()->routeIs('technician.settings') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                    </path>
                </svg>
                {{ $sideTexts['settings'] }}
            </a>

            <div style="margin-top: 20px; background: var(--bg-color); padding: 20px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color);">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"
                    style="width: 24px; height: 24px; margin-bottom: 8px; display: inline-block;">
                    <path
                        d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                    </path>
                </svg>
                <h4 style="font-size: 0.9rem; color: var(--text-color); margin: 0 0 4px; font-weight: 800;">{{ $sideTexts['help_title'] }}</h4>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0 0 12px;">{{ $sideTexts['help_sub'] }}</p>
                <a href="{{ route('technician.messages') }}" style="text-decoration: none; display: block; width: 100%;">
                    <button style="width: 100%; padding: 10px; background: #10b981; color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#0d9488'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)'">
                        {{ $sideTexts['contact'] }}
                    </button>
                </a>
            </div>

            <a href="/" class="menu-item" style="margin-top: 12px; color: #3b82f6; font-weight: 700; border: 1px solid var(--border-color); border-radius: 12px; justify-content: center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
                {{ $sideTexts['back_to_site'] }}
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
                @csrf
                <button type="submit"
                    style="width: 100%; background: none; border: none; padding: 12px; display: flex; align-items: center; gap: 8px; justify-content: center; color: #ef4444; font-weight: 600; cursor: pointer; border-radius: 12px; transition: background 0.2s;"
                    onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='none'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    {{ $sideTexts['logout'] }}
                </button>
            </form>
        </div>
    </aside>

    <!-- Topbar -->
    <header class="topbar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <button class="menu-toggle" id="menu-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--text-color)" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div style="display: flex; align-items: center; gap: 12px;">

                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-color); margin: 0 0 2px;">{{ $sideTexts['hello'] }},
                        {{ explode(' ', Auth::user()->name)[0] }} ! </h2>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">{{ $sideTexts['overview'] }}</p>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 24px;">
            <!-- Notification Bell -->
            <a href="{{ route('technician.notifications') }}" style="background: none; border: none; cursor: pointer; position: relative; color: var(--text-muted); text-decoration: none; display: inline-flex;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                @if($realNotifCount > 0)
                    <span style="position: absolute; top: -2px; right: -2px; width: 10px; height: 10px; background: #ef4444; border-radius: 50%; border: 2px solid white;"></span>
                @endif
            </a>

            <!-- User Profile -->
            <div
                style="display: flex; align-items: center; gap: 12px; padding-left: 24px; border-left: 1px solid var(--border-color);">
                <div style="text-align: right;">
                    <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-color);">{{ Auth::user()->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $sideTexts['technician'] }}</div>
                </div>
                <div
                    style="width: 40px; height: 40px; border-radius: 50%; background: var(--border-color); overflow: hidden; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 700;">
                    @if(Auth::user()->technicianProfile && Auth::user()->technicianProfile->photo)
                        <img src="{{ asset('storage/' . Auth::user()->technicianProfile->photo) }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 95; opacity: 0; transition: opacity 0.3s;">
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');

            function toggleMenu() {
                sidebar.classList.toggle('show');
                if (sidebar.classList.contains('show')) {
                    overlay.style.display = 'block';
                    setTimeout(() => overlay.style.opacity = '1', 10);
                } else {
                    overlay.style.opacity = '0';
                    setTimeout(() => overlay.style.display = 'none', 300);
                }
            }

            if (menuBtn) {
                menuBtn.addEventListener('click', toggleMenu);
            }
            if (overlay) {
                overlay.addEventListener('click', toggleMenu);
            }
        });
    </script>

    @yield('scripts')
</body>

</html>