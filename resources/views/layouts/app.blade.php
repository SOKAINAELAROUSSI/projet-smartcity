<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
        html {
            scroll-behavior: smooth;
        }

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
        
        /* Floating Navbar */
        .nav-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1400px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2000;
            transition: all 0.3s ease;
        }
        
        .desktop-links a {
            position: relative;
            color: var(--slate-600);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }
        .desktop-links a:hover, .desktop-links a.active {
            color: var(--primary) !important;
        }
        .desktop-links a.active::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 12px;
            right: 12px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }



        .nav-btn-connect {
            background: white;
            color: var(--slate-900) !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }
        .nav-btn-connect:hover {
            background: var(--slate-50);
        }

        .nav-btn-register {
            background: var(--primary);
            color: white !important;
            border-radius: 12px;
            padding: 10px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.2s;
        }
        .nav-btn-register:hover {
            opacity: 0.9;
        }

        /* Mobile View adjustments */
        @media (max-width: 1024px) {
            .nav-container {
                top: 0;
                left: 0;
                transform: none;
                width: 100%;
                border-radius: 0;
                border: none;
                border-bottom: 1px solid var(--slate-100);
                padding: 15px 24px !important;
            }
            .desktop-links {
                display: none !important;
            }
            .desktop-auth-links {
                display: none !important;
            }
            .hamburger-btn {
                display: block !important;
            }
        }
        
        .citizen-container {
            padding: 120px 60px 60px;
            max-width: 1400px;
            margin: 0 auto;
        }
        @media (max-width: 1024px) {
            .citizen-container {
                padding: 95px 24px 40px !important;
            }
        }

        /* Premium Footer Styles */
        .premium-footer {
            background: #030f26; 
            color: #e2e8f0; 
            padding: 80px 80px 40px; 
            font-family: 'Inter', sans-serif;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.25fr 1.5fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        .footer-column h4 {
            color: white; 
            font-family: 'Outfit', sans-serif;
            font-weight: 700; 
            font-size: 1.1rem; 
            margin: 0 0 24px;
            position: relative;
            padding-bottom: 8px;
        }
        .footer-column h4::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }
        .footer-feature-item {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }
        .footer-feature-icon {
            width: 36px;
            height: 36px;
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }
        .footer-feature-text h5 {
            margin: 0 0 4px;
            color: white;
            font-size: 0.9rem;
            font-weight: 700;
        }
        .footer-feature-text p {
            margin: 0;
            font-size: 0.8rem;
            color: #94a3b8;
            line-height: 1.4;
        }
        .footer-links-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .footer-links-list a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: color 0.2s;
        }
        .footer-links-list a:hover {
            color: white;
        }
        .footer-links-list a .arrow {
            color: #475569;
            font-weight: 800;
            font-size: 0.8rem;
            transition: transform 0.2s, color 0.2s;
        }
        .footer-links-list a:hover .arrow {
            transform: translateX(4px);
            color: var(--primary);
        }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #94a3b8;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 18px;
        }
        .footer-contact-item svg {
            color: var(--primary);
            margin-top: 3px;
            flex-shrink: 0;
        }
        .social-icons-container {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        .social-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            transition: transform 0.2s;
        }
        .social-circle:hover {
            transform: translateY(-3px);
        }
        .newsletter-form {
            display: flex;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
            background: rgba(255,255,255,0.03);
            padding: 4px;
        }
        .newsletter-input {
            background: transparent;
            border: none;
            padding: 10px 14px;
            color: white;
            outline: none;
            width: 100%;
            font-size: 0.85rem;
        }
        .newsletter-btn {
            background: var(--primary);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .newsletter-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 1200px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }
        }
        @media (max-width: 768px) {
            .premium-footer {
                padding: 60px 24px 30px;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
    </style>
</head>
<body>
    <nav class="nav-container">
        <a href="/" class="logo" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 38px; width: 38px; object-fit: contain; border-radius: 8px;">
            <div style="display: flex; flex-direction: column; line-height: 1.1;">
                <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.3rem; color: #0f172a; letter-spacing: -0.5px;">Smart City</span>
                <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.3rem; color: #10b981; letter-spacing: -0.5px;">Connect</span>
            </div>
        </a>

        <!-- Desktop Links -->
        <div class="desktop-links" style="display: flex; gap: 10px; align-items: center;">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Accueil
            </a>
            <a href="{{ route('reports.create') }}" class="{{ request()->routeIs('reports.create') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                Signaler un problème
            </a>
            <a href="/#about">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                À propos
            </a>
            <a href="/#map">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                Carte des signalements
            </a>
            <a href="/#contact">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                Contact
            </a>
        </div>

        <div class="desktop-auth-links" style="display: flex; gap: 16px; align-items: center;">
            @auth
                @if(Auth::user()->role === 'technician')
                    <a href="{{ route('dashboard') }}" class="nav-btn-connect">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Espace Tech
                    </a>
                @elseif(Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="nav-btn-connect">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Espace Admin
                    </a>
                @else
                    <a href="{{ route('reports.my') }}" class="nav-btn-connect">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mes Signalements
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--slate-400); font-weight: 600; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='var(--slate-800)'" onmouseout="this.style.color='var(--slate-400)'">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-btn-connect">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="nav-btn-register">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="16" y1="11" x2="22" y2="11"></line></svg>
                    S'inscrire
                </a>
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
        
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Navigation Links -->
            <a href="/" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Accueil
            </a>
            
            <a href="{{ route('reports.create') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                Signaler un problème
            </a>
            
            <a href="/#about" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                À propos
            </a>
            
            <a href="/#map" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                Carte des signalements
            </a>
            
            <a href="/#contact" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                Contact
            </a>

            <hr style="border: 0; border-top: 1px solid var(--slate-200); margin: 10px 0;">

            <!-- Auth/Citizen Links -->
            @auth
                <p style="font-weight: 800; color: var(--primary-700); margin: 0 0 -5px;">{{ Auth::user()->name }}</p>
                @if(Auth::user()->role === 'citizen')
                    <a href="{{ route('reports.my') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mes Signalements
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        Tableau de bord
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 12px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"></path></svg>
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 8px;">S'inscrire</a>
            @endauth
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="premium-footer">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="footer-grid">
                <!-- Column 1: Brand & Features -->
                <div class="footer-column">
                    <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 38px; width: 38px; object-fit: contain; border-radius: 8px;">
                        <div style="display: flex; flex-direction: column; line-height: 1.1;">
                            <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.3rem; color: white; letter-spacing: -0.5px;">Smart City</span>
                            <span style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.3rem; color: #10b981; letter-spacing: -0.5px;">Connect</span>
                        </div>
                    </a>
                    <p style="color: #94a3b8; line-height: 1.6; font-size: 0.9rem; margin-bottom: 30px;">
                        Une plateforme intelligente qui connecte citoyens et techniciens pour une ville plus propre, plus sûre et plus réactive.
                    </p>
                    
                    <!-- Vertical Features -->
                    <div class="footer-feature-item">
                        <div class="footer-feature-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="footer-feature-text">
                            <h5>Signalement rapide</h5>
                            <p>Signalez facilement les problèmes urbains.</p>
                        </div>
                    </div>
                    <div class="footer-feature-item">
                        <div class="footer-feature-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div class="footer-feature-text">
                            <h5>Suivi en temps réel</h5>
                            <p>Suivez l'état de vos signalements.</p>
                        </div>
                    </div>
                    <div class="footer-feature-item">
                        <div class="footer-feature-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div class="footer-feature-text">
                            <h5>Résolution efficace</h5>
                            <p>Des techniciens qualifiés à votre service.</p>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Liens Rapides -->
                <div class="footer-column">
                    <h4>Liens rapides</h4>
                    <ul class="footer-links-list">
                        <li><a href="/">Accueil <span class="arrow">&gt;</span></a></li>
                        <li><a href="{{ route('reports.create') }}">Signaler un problème <span class="arrow">&gt;</span></a></li>
                        <li><a href="/#about">À propos <span class="arrow">&gt;</span></a></li>
                        <li><a href="/#map">Carte des signalements <span class="arrow">&gt;</span></a></li>
                        <li><a href="/#contact">Contact <span class="arrow">&gt;</span></a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact -->
                <div class="footer-column">
                    <h4>Contact</h4>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <div>{{ $platformSettings['contact_email'] ?? 'contact@smartcityconnect.ma' }}</div>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <div>{{ $platformSettings['support_phone'] ?? '+212 6 12 34 56 78' }}</div>
                    </div>

                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <div>Lun - Ven : 08h00 - 18h00<br>Sam : 09h00 - 13h00</div>
                    </div>
                </div>

                <!-- Column 4: Suivez-nous & Newsletter -->
                <div class="footer-column">
                    <h4>Suivez-nous</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 16px;">Restez connectés sur nos réseaux sociaux.</p>
                    <div class="social-icons-container">
                        <a href="#" class="social-circle" style="background: #3b5998;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        <a href="#" class="social-circle" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                        <a href="#" class="social-circle" style="background: #1da1f2;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
                    </div>


                </div>
            </div>

            <!-- Footer Bottom Bar -->
            <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 24px; color: #64748b; font-size: 0.85rem;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        Politique de confidentialité
                    </div>
                    <span>|</span>
                    <a href="#" style="color: #64748b; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#64748b'">Conditions d'utilisation</a>
                    <span>|</span>
                    <a href="#" style="color: #64748b; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#64748b'">Mentions légales</a>
                </div>
                <p style="color: #64748b; font-size: 0.85rem; margin: 0;">&copy; {{ date('Y') }} Smart City Connect. Tous droits réservés.</p>
            </div>
        </div>
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

            // Close mobile menu on click of navigation links
            const mobileLinks = document.querySelectorAll('#mobile-menu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.remove('active');
                    overlay.classList.remove('active');
                });
            });

            // ScrollSpy / Active Link Navigation
            const navLinks = document.querySelectorAll('.desktop-links a');
            const sections = document.querySelectorAll('#home, #about, #map, #contact');
            
            if (window.location.pathname === '/') {
                // Smooth scroll for anchor links
                navLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && href.startsWith('/#')) {
                        const targetId = href.substring(2);
                        const targetElement = document.getElementById(targetId);
                        if (targetElement) {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                targetElement.scrollIntoView({ behavior: 'smooth' });
                                history.pushState(null, null, '#' + targetId);
                            });
                        }
                    } else if (href === '/') {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            history.pushState(null, null, '/');
                        });
                    }
                });

                // Update active link on scroll
                const updateActiveLink = () => {
                    let current = '';
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop;
                        if (window.pageYOffset >= sectionTop - 150) {
                            current = section.getAttribute('id');
                        }
                    });

                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        const href = link.getAttribute('href');
                        if (current === 'home' && href === '/') {
                            link.classList.add('active');
                        } else if (href === '/#' + current) {
                            link.classList.add('active');
                        }
                    });
                };

                window.addEventListener('scroll', updateActiveLink);
                updateActiveLink(); // run on load
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
