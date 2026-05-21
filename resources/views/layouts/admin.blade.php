<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>SmartCity - @yield('title', 'Administration')</title>

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
            --sidebar-collapsed: 72px;
            --topbar-height: 70px;
            --admin-bg: #f1f5f9;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #10b981;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --sidebar-section: #64748b;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        /* Dark Theme Variables */
        .dark-theme {
            --admin-bg: #0f172a;
            --sidebar-bg: #020617;
            --sidebar-hover: #0f172a;
            --sidebar-active: #10b981;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --sidebar-section: #475569;
            --card-bg: #1e293b;
            --text-dark: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
        }

        /* Dynamic Dark Mode Overrides for views using inline styles */
        .dark-theme div[style*="background: white"],
        .dark-theme div[style*="background:white"],
        .dark-theme div[style*="background: #fff"],
        .dark-theme div[style*="background:#fff"],
        .dark-theme div[style*="background: #ffffff"],
        .dark-theme div[style*="background:#ffffff"] {
            background: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-dark) !important;
        }

        .dark-theme div[style*="background: #f8fafc"],
        .dark-theme div[style*="background:#f8fafc"],
        .dark-theme div[style*="background: #f1f5f9"],
        .dark-theme div[style*="background:#f1f5f9"],
        .dark-theme div[style*="background: #eff6ff"] {
            background: var(--admin-bg) !important;
            border-color: var(--border-color) !important;
        }

        .dark-theme [style*="color: #0f172a"],
        .dark-theme [style*="color:#0f172a"],
        .dark-theme [style*="color: #334155"],
        .dark-theme [style*="color:#334155"],
        .dark-theme [style*="color: #475569"],
        .dark-theme [style*="color:#475569"] {
            color: var(--text-dark) !important;
        }
        
        .dark-theme [style*="color: #64748b"],
        .dark-theme [style*="color:#64748b"] {
            color: var(--text-muted) !important;
        }

        .dark-theme [style*="border: 1px solid #e2e8f0"],
        .dark-theme [style*="border:1px solid #e2e8f0"],
        .dark-theme [style*="border-bottom: 1px solid #e2e8f0"],
        .dark-theme [style*="border-bottom:1px solid #e2e8f0"],
        .dark-theme [style*="border-top: 1px solid #e2e8f0"],
        .dark-theme [style*="border-top:1px solid #e2e8f0"],
        .dark-theme [style*="border: 1px solid #f1f5f9"],
        .dark-theme [style*="border:1px solid #f1f5f9"],
        .dark-theme [style*="border-bottom: 1px solid #f1f5f9"],
        .dark-theme [style*="border-bottom:1px solid #f1f5f9"] {
            border-color: var(--border-color) !important;
        }

        .dark-theme input, .dark-theme select, .dark-theme textarea {
            background-color: var(--admin-bg) !important;
            color: var(--text-dark) !important;
            border-color: var(--border-color) !important;
        }
        
        .dark-theme div[style*="position:fixed"][style*="background: rgba(0,0,0,0.5)"],
        .dark-theme div[style*="position:fixed"][style*="background: rgba(15, 23, 42, 0.6)"],
        .dark-theme div[style*="position: fixed"][style*="background: rgba(15, 23, 42, 0.6)"] {
            background: rgba(2, 6, 17, 0.8) !important;
        }

        .dark-theme div[style*="background: white"][style*="border-radius: 16px"] {
            background: var(--card-bg) !important;
            color: var(--text-dark) !important;
            border-color: var(--border-color) !important;
        }
        
        .dark-theme table, .dark-theme tr, .dark-theme td, .dark-theme th {
            border-color: var(--border-color) !important;
        }
        
        .dark-theme .admin-main {
            background: var(--admin-bg);
            color: var(--text-dark);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--admin-bg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-header .logo-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            background: #10b981;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .sidebar-header .logo-text span:first-child {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 1.05rem;
            color: white;
        }

        .sidebar-header .logo-text span:last-child {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            color: #10b981;
        }

        .sidebar-section {
            padding: 20px 20px 8px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--sidebar-section);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            margin: 2px 10px;
            border-radius: 10px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-link .badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 100px;
            min-width: 22px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid #1e293b;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
        }

        .sidebar-profile .avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.95rem;
        }

        .sidebar-profile .info h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .sidebar-profile .info p {
            font-size: 0.7rem;
            color: #64748b;
            margin: 0;
        }

        .sidebar-back {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin-top: 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #3b82f6;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid #1e293b;
            transition: all 0.2s;
            justify-content: center;
        }

        .sidebar-back:hover {
            background: #1e293b;
            border-color: #3b82f6;
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin-top: 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #ef4444;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid #1e293b;
            transition: all 0.2s;
            justify-content: center;
            background: transparent;
            width: 100%;
            cursor: pointer;
        }

        .sidebar-logout:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
        }

        /* ========== TOPBAR ========== */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 90;
            transition: left 0.3s;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-greeting h2 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0 0 2px;
        }

        .topbar-greeting p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--admin-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 8px 16px;
            min-width: 220px;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .search-box:hover { border-color: #10b981; }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.85rem;
            color: var(--text-dark);
            width: 100%;
        }

        .search-box kbd {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 0.65rem;
            color: var(--text-muted);
        }

        .topbar-icon {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .topbar-icon:hover {
            background: var(--admin-bg);
            color: var(--text-dark);
        }

        .topbar-icon .dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 20px;
            border-left: 1px solid var(--border-color);
            cursor: pointer;
        }

        .topbar-profile .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
        }

        .topbar-profile .info {
            text-align: right;
        }

        .topbar-profile .info h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .topbar-profile .info p {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* ========== MAIN CONTENT ========== */
        .admin-main {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 28px 32px;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.3s;
        }

        /* ========== MOBILE ========== */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            color: var(--text-dark);
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            .admin-sidebar.open {
                left: 0;
            }
            .admin-topbar {
                left: 0;
            }
            .admin-main {
                margin-left: 0;
            }
            .mobile-toggle {
                display: flex;
            }
            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 95;
            }
            .mobile-overlay.active {
                display: block;
            }
            .topbar-greeting p {
                display: none;
            }
            .search-box {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .admin-topbar {
                padding: 0 16px;
            }
            .topbar-greeting {
                display: none;
            }
            .search-box {
                display: flex;
                width: 160px;
                padding: 8px 12px;
            }
            .search-box kbd {
                display: none;
            }
            .topbar-profile .info {
                display: none;
            }
            .topbar-profile {
                padding-left: 0;
                border-left: none;
            }
            .admin-main {
                padding: 20px 16px;
            }
        }
    </style>
</head>

@php
    $adminNotifCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
@endphp

<body class="{{ Auth::check() && Auth::user()->theme === 'dark' ? 'dark-theme' : '' }}">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-header" style="text-decoration: none;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 36px; height: 36px; object-fit: contain; border-radius: 8px;">
            <div class="logo-text">
                <span>Smart City</span>
                <span>Connect</span>
            </div>
        </a>

        <nav style="flex: 1; padding-bottom: 10px;">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
            </a>

            <div class="sidebar-section">Gestion</div>
            <a href="{{ route('admin.citizens.index') }}" class="sidebar-link {{ request()->routeIs('admin.citizens.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Citoyens
            </a>
            <a href="{{ route('admin.technicians.index') }}" class="sidebar-link {{ request()->routeIs('admin.technicians.index') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i> Techniciens
            </a>
            <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                <i class="bi bi-flag-fill"></i> Signalements
            </a>

            <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Catégories
            </a>


            <div class="sidebar-section">Communication</div>

            <a href="{{ route('admin.messages') }}" class="sidebar-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Messages Support
            </a>
            <a href="{{ route('admin.contacts') }}" class="sidebar-link {{ request()->routeIs('admin.contacts') ? 'active' : '' }}">
                <i class="bi bi-envelope-fill"></i> Messages Citoyens
            </a>
            <a href="{{ route('admin.reviews') }}" class="sidebar-link {{ request()->routeIs('admin.reviews') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i> Avis & Évaluations
            </a>

            <div class="sidebar-section">Paramètres</div>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i> Paramètres
            </a>
            <a href="{{ route('admin.activity') }}" class="sidebar-link {{ request()->routeIs('admin.activity') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Journal d'activités
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-profile">
                <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            <a href="/" class="sidebar-back">
                <i class="bi bi-arrow-left"></i> Retour au site
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobile-overlay"></div>

    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="mobile-toggle" id="mobile-toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <div class="topbar-greeting">
                <h2>Bonjour, {{ explode(' ', Auth::user()->name)[0] }} ! 👋</h2>
                <p>Voici un aperçu complet de la plateforme aujourd'hui.</p>
            </div>
        </div>
        <div class="topbar-right">
            <div class="search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Rechercher...">
                <kbd>Ctrl + K</kbd>
            </div>

            <a href="{{ route('admin.notifications') }}" class="topbar-icon">
                <i class="bi bi-bell" style="font-size: 1.1rem;"></i>
                @if($adminNotifCount > 0)
                    <span class="dot"></span>
                @endif
            </a>

            <div class="topbar-profile">
                <div class="info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Administrateur</p>
                </div>
                <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        @yield('content')
    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('mobile-overlay');
        const toggle = document.getElementById('mobile-toggle');

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
