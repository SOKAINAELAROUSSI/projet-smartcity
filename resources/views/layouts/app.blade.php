<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCity - @yield('title', 'Gestion Urbaine')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .mobile-nav {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            height: 100vh;
            background: white;
            z-index: 2000;
            padding: 40px;
            transition: 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        }
        
        .mobile-nav.active {
            right: 0;
        }
        
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(4px);
            z-index: 1999;
            display: none;
        }
        
        .mobile-overlay.active {
            display: block;
        }
        
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            z-index: 2001;
        }
        
        @media (max-width: 1024px) {
            .hamburger-btn {
                display: block;
            }
            .desktop-links {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <nav class="nav-container">
        <a href="/" class="logo" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
            <img src="{{ asset('images/logo.png') }}" alt="SmartCity Logo" style="height: 45px; width: auto; object-fit: contain;">
        </a>

        <!-- Desktop Links -->
        <div class="desktop-links" style="display: flex; gap: 32px; align-items: center;">
            @auth
                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 0.95rem;">Tableau de Bord</a>
                <div style="height: 24px; width: 1px; background: var(--slate-200);"></div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="text-align: right;">
                        <p style="font-weight: 700; color: var(--slate-900); font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                        <p style="font-size: 0.75rem; color: var(--primary-700); font-weight: 700; text-transform: uppercase;">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background: var(--slate-100); border: none; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700;">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
            @endauth
        </div>

        <!-- Hamburger Button -->
        <button class="hamburger-btn" id="menu-toggle">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--slate-900)" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div class="mobile-overlay" id="menu-overlay"></div>
    <div class="mobile-nav" id="mobile-menu">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <span style="font-size: 1.5rem; font-weight: 900;">Menu</span>
            <button id="menu-close" style="background: none; border: none; cursor: pointer;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--slate-900)" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            @auth
                <p style="font-weight: 800; color: var(--primary-700);">{{ Auth::user()->name }}</p>
                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.2rem;">Tableau de Bord</a>
                <a href="{{ route('reports.create') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.2rem;">Signaler un problème</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.2rem;">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary" style="width: 100%; justify-content: center;">S'inscrire</a>
            @endauth
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer style="padding: 60px; background: white; border-top: 1px solid var(--slate-100); text-align: center;">
        <p style="color: var(--slate-500); font-weight: 600;">&copy; 2026 SmartCity. Ensemble pour une ville plus connectée.</p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('menu-toggle');
            const close = document.getElementById('menu-close');
            const menu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('menu-overlay');
            
            const toggleMenu = () => {
                menu.classList.toggle('active');
                overlay.classList.toggle('active');
            };
            
            toggle.addEventListener('click', toggleMenu);
            close.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
        });
    </script>
    
    @yield('scripts')
</body>
</html>
