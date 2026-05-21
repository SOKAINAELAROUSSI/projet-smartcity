@extends('layouts.app')

@section('title', 'Bienvenue sur SmartCity Connect')@section('content')<!-- Hero Section -->
    <!-- Hero Section -->
    <div id="home"
        style="padding-top: 100px; min-height: 100vh; background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 100%); position: relative; overflow: hidden;">
        <!-- Background City Image with Overlay -->
        <div class="hero-bg-image"
            style="position: absolute; right: -10%; top: 15%; width: 60%; height: 70%; z-index: 0; opacity: 0.8; pointer-events: none; mask-image: radial-gradient(circle, black 40%, transparent 80%); -webkit-mask-image: radial-gradient(circle, black 40%, transparent 80%); transition: all 0.5s ease;">
            <img src="{{ asset('images/hero-bg.png') }}"
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 40px;" alt="Smart City Background">
        </div>

        <div class="hero-grid"
            style="position: relative; z-index: 10; padding: 60px 80px; display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: center; max-width: 1500px; margin: 0 auto;">

            <!-- Hero Left -->
            <div class="animate-slide-up">
                <div class="badge-futur" style="margin-bottom: 30px;">
                    <span
                        style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%; display: inline-block;"></span>
                    Le futur de la gestion urbaine est ici
                </div>

                <h1
                    style="font-size: clamp(3.5rem, 6vw, 5.5rem); line-height: 1; font-weight: 900; color: var(--slate-900); letter-spacing: -3px; margin-bottom: 30px;">
                    Smart City <br> <span style="color: var(--primary);">Connect.</span>
                </h1>

                <p
                    style="font-size: 1.25rem; color: var(--slate-500); line-height: 1.6; margin-bottom: 40px; max-width: 550px;">
                    Une plateforme intelligente qui connecte citoyens et techniciens pour une ville plus propre, plus sûre
                    et plus réactive.
                </p>

                <!-- Mini Features -->
                <div class="hero-features-grid">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div
                            style="width: 48px; height: 48px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 800; color: var(--slate-900); font-size: 0.95rem;">Signalements</div>
                            <div style="color: var(--slate-400); font-size: 0.85rem;">faciles et rapides</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div
                            style="width: 48px; height: 48px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 800; color: var(--slate-900); font-size: 0.95rem;">Suivi en temps réel
                            </div>
                            <div style="color: var(--slate-400); font-size: 0.85rem;">et notifications</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div
                            style="width: 48px; height: 48px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 800; color: var(--slate-900); font-size: 0.95rem;">Une ville plus
                                propre</div>
                            <div style="color: var(--slate-400); font-size: 0.85rem;">et plus sûre</div>
                        </div>
                    </div>
                </div>

                <div class="hero-buttons-container">
                    @auth
                        <a href="{{ route('reports.create') }}" class="btn-primary"
                            style="padding: 18px 42px; border-radius: 100px; text-decoration: none;">
                            Créer un signalement
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                        <a href="{{ route('reports.my') }}" class="btn-outline"
                            style="padding: 18px 42px; border-radius: 100px; background: white; text-decoration: none;">
                            Mes signalements
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary"
                            style="padding: 18px 42px; border-radius: 100px; text-decoration: none;">
                            Créer un signalement
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-outline"
                            style="padding: 18px 42px; border-radius: 100px; background: white; text-decoration: none;">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Hero Right (Empty to maintain grid and show background) -->
            <div class="animate-slide-up" style="animation-delay: 0.2s; position: relative;">
            </div>
        </div>

    </div>

    <!-- Key Features (Les Points Forts) -->
    <section id="about" style="padding: 120px 60px; background: white;">
        <div style="max-width: 1300px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 100px;">
                <h2 style="font-size: 4rem; color: var(--slate-900); letter-spacing: -2px; margin-bottom: 24px;">Pourquoi
                    SmartCity ?</h2>
                <p style="font-size: 1.25rem; color: var(--slate-500); max-width: 700px; margin: 0 auto;">Une technologie de
                    pointe au service de la communauté urbaine.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
                <div class="glass-card" style="padding: 48px; border: 1px solid var(--slate-100);">
                    <div
                        style="width: 64px; height: 64px; background: #e0f2fe; color: #0369a1; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 32px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 style="margin-bottom: 16px;">Géolocalisation Précise</h3>
                    <p style="color: var(--slate-500); line-height: 1.6;">Signalements géo-référencés pour une intervention
                        rapide et ciblée des techniciens.</p>
                </div>

                <div class="glass-card" style="padding: 48px; border: 1px solid var(--slate-100);">
                    <div
                        style="width: 64px; height: 64px; background: #fef3c7; color: #92400e; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 32px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <h3 style="margin-bottom: 16px;">Logique Intelligente</h3>
                    <p style="color: var(--slate-500); line-height: 1.6;">Algorithme d'assignation basé sur la spécialité,
                        la distance et les notes des techniciens.</p>
                </div>

                <div class="glass-card" style="padding: 48px; border: 1px solid var(--slate-100);">
                    <div
                        style="width: 64px; height: 64px; background: #dcfce7; color: #166534; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 32px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                    <h3 style="margin-bottom: 16px;">Temps Réel</h3>
                    <p style="color: var(--slate-500); line-height: 1.6;">Notifications instantanées pour chaque changement
                        de statut et preuve photo à la clé.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Preview -->
    <section id="map" style="padding: 120px 60px; background: var(--slate-50);">
        <div style="max-width: 1300px; margin: 0 auto;">
            <div class="glass-card map-preview-grid">
                <div>
                    <h2 style="font-size: 3.5rem; letter-spacing: -2px; margin-bottom: 24px;">La Ville en Temps Réel</h2>
                    <p style="color: var(--slate-500); font-size: 1.1rem; line-height: 1.7; margin-bottom: 40px;">
                        Découvrez les derniers signalements résolus et les interventions en cours à travers toute la ville.
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></div>
                            <span style="font-weight: 700; color: var(--slate-700);">Signalements actifs</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #16a34a;"></div>
                            <span style="font-weight: 700; color: var(--slate-700);">Interventions terminées</span>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="btn-primary"
                        style="width: 100%; justify-content: center;">Commencer à contribuer</a>
                </div>
                <div
                    style="border-radius: 32px; overflow: hidden; height: 550px; box-shadow: var(--shadow-premium); border: 8px solid white;">
                    <div id="home-map" style="height: 100%; width: 100%;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Overview -->
    <section style="padding: 140px 60px; background: #ffffff;">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 100px;">
                <div
                    style="text-transform: uppercase; color: #22c55e; font-weight: 900; font-size: 0.9rem; letter-spacing: 4px; margin-bottom: 20px;">
                    Nos Expertises</div>
                <h2
                    style="font-size: clamp(3rem, 5vw, 4.5rem); color: #0f172a; letter-spacing: -3px; font-weight: 900; line-height: 1;">
                    Domaines d'Action <span style="color: #22c55e;">Urbaine.</span></h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
                @foreach($categories as $cat)
                    @php
                        $defaultImages = [
                            'Éclairage' => 'https://images.unsplash.com/photo-1518391846015-55a9cb003b75?auto=format&fit=crop&w=800&q=80',
                            'Routes' => 'https://images.unsplash.com/photo-1476973422084-e0fa66df945c?auto=format&fit=crop&w=800&q=80',
                            'Déchets' => 'https://images.unsplash.com/photo-1605600611284-195205ef9447?auto=format&fit=crop&w=800&q=80',
                            'Eau' => 'https://images.unsplash.com/photo-1542013936693-8846383242e2?auto=format&fit=crop&w=800&q=80',
                            'Trafic' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
                            'default' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=800&q=80'
                        ];
                        $bgImage = $cat->image ? asset('storage/' . $cat->image) : ($defaultImages[$cat->name] ?? $defaultImages['default']);
                        $targetUrl = Auth::check() ? route('reports.create', ['category_id' => $cat->id]) : route('register');
                    @endphp
                    <a href="{{ $targetUrl }}" style="text-decoration: none; color: inherit; display: block;">
                        <div class="category-card"
                            style="position: relative; height: 450px; border-radius: 40px; overflow: hidden; cursor: pointer; transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 20px 40px rgba(0,0,0,0.05); group"
                            onmouseover="this.style.transform='translateY(-15px)'; this.style.boxShadow='0 40px 80px rgba(0,0,0,0.15)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.05)'">

                            <!-- Background Image with Overlay -->
                            <div style="position: absolute; inset: 0; z-index: 0;">
                                <img src="{{ $bgImage }}"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                <div
                                    style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 50%, transparent 100%);">
                                </div>
                            </div>

                            <!-- Content Overlay -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 40px; z-index: 1;">
                                <h3
                                    style="color: #ffffff; font-size: 2.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 12px;">
                                    {{ $cat->name }}</h3>
                                <p
                                    style="color: rgba(255,255,255,0.7); font-size: 1rem; line-height: 1.5; margin-bottom: 24px;">
                                    Optimisation et maintenance intelligente de l'infrastructure urbaine.
                                </p>
                                <div
                                    style="display: inline-flex; align-items: center; gap: 8px; color: #22c55e; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                                    Découvrir
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="3">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            </div>

                            <!-- Top Badge -->
                            <div
                                style="position: absolute; top: 30px; right: 30px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); color: white; padding: 6px 12px; border-radius: 100px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border: 1px solid rgba(255,255,255,0.1);">
                                Priorité Haute
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" style="padding: 120px 60px; background: var(--slate-50);">
        <div style="max-width: 1300px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 80px;">
                <div style="text-transform: uppercase; color: #22c55e; font-weight: 900; font-size: 0.9rem; letter-spacing: 4px; margin-bottom: 20px;">
                    Contactez-nous
                </div>
                <h2 style="font-size: clamp(3rem, 5vw, 4.5rem); color: #0f172a; letter-spacing: -3px; font-weight: 900; line-height: 1; margin-bottom: 24px;">
                    Une question ? <span style="color: #22c55e;">Écrivez-nous.</span>
                </h2>
                <p style="font-size: 1.25rem; color: var(--slate-500); max-width: 700px; margin: 0 auto;">
                    Notre équipe est à votre écoute pour vous accompagner et répondre à toutes vos interrogations.
                </p>
            </div>

            <div class="contact-grid">
                <!-- Contact Info Cards -->
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <div class="glass-card" style="padding: 32px; display: flex; align-items: center; gap: 24px; border: 1px solid var(--slate-100); transform: none; box-shadow: var(--shadow-soft);">
                        <div style="width: 56px; height: 56px; background: #e0f2fe; color: #0369a1; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 4px;">Email</h4>
                            <p style="color: var(--slate-500); font-size: 0.95rem;">{{ $platformSettings['contact_email'] ?? 'contact@smartcityconnect.ma' }}</p>
                        </div>
                    </div>

                    <div class="glass-card" style="padding: 32px; display: flex; align-items: center; gap: 24px; border: 1px solid var(--slate-100); transform: none; box-shadow: var(--shadow-soft);">
                        <div style="width: 56px; height: 56px; background: #dcfce7; color: #166534; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 4px;">Téléphone</h4>
                            <p style="color: var(--slate-500); font-size: 0.95rem;">{{ $platformSettings['support_phone'] ?? '+212 6 12 34 56 78' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="glass-card" style="padding: 48px; border: 1px solid var(--slate-100); background: white; transform: none; box-shadow: var(--shadow-soft);">
                    @if(session('success'))
                        <div style="padding: 16px; background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; border-radius: 12px; margin-bottom: 24px; font-size: 0.95rem; font-weight: 600;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 24px;">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--slate-700); margin-bottom: 8px;">Nom complet</label>
                                <input type="text" name="name" placeholder="Votre nom" required style="width: 100%; padding: 14px 16px; border: 1.5px solid var(--slate-200); border-radius: 12px; outline: none; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--slate-700); margin-bottom: 8px;">Adresse email</label>
                                <input type="email" name="email" placeholder="Votre email" required style="width: 100%; padding: 14px 16px; border: 1.5px solid var(--slate-200); border-radius: 12px; outline: none; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--slate-700); margin-bottom: 8px;">Sujet</label>
                            <input type="text" name="subject" placeholder="Sujet de votre message" required style="width: 100%; padding: 14px 16px; border: 1.5px solid var(--slate-200); border-radius: 12px; outline: none; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 0.85rem; color: var(--slate-700); margin-bottom: 8px;">Message</label>
                            <textarea name="message" rows="5" placeholder="Votre message..." required style="width: 100%; padding: 14px 16px; border: 1.5px solid var(--slate-200); border-radius: 12px; outline: none; font-size: 0.95rem; font-family: 'Inter', sans-serif; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" style="padding: 16px; background: #10b981; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                            Envoyer le message <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes growUp {
            from {
                transform: scaleY(0);
            }

            to {
                transform: scaleY(1);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .filter-item:hover {
            background: #f1f5f9;
            color: #10b981 !important;
        }

        .hero-features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 48px;
            text-align: left;
        }

        .hero-buttons-container {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            position: relative;
            z-index: 20;
        }

        .map-preview-grid {
            padding: 60px;
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 60px;
            align-items: center;
        }

        section {
            padding: 120px 60px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .contact-grid {
                grid-template-columns: 1fr !important;
                gap: 40px !important;
            }
        }

        @media (max-width: 1024px) {
            .hero-bg-image {
                width: 100% !important;
                right: 0 !important;
                top: 20% !important;
                height: 60% !important;
                opacity: 0.15 !important;
                mask-image: radial-gradient(circle, black 30%, transparent 70%) !important;
                -webkit-mask-image: radial-gradient(circle, black 30%, transparent 70%) !important;
            }

            .hero-grid {
                grid-template-columns: 1fr !important;
                padding: 40px 20px !important;
                text-align: center;
            }

            .hero-grid>div:first-child {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-grid>div:last-child {
                display: none !important;
            }

            .hero-buttons-container {
                justify-content: center;
            }

            .map-preview-grid {
                grid-template-columns: 1fr;
                padding: 40px 24px;
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .hero-grid h1 {
                font-size: 3rem !important;
            }

            section {
                padding: 60px 24px !important;
            }
        }

        @media (max-width: 640px) {
            .hero-features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown Logic
            const btn = document.getElementById('analytics-dropdown-btn');
            const menu = document.getElementById('analytics-dropdown-menu');
            const currentFilterText = document.getElementById('current-filter');
            const items = document.querySelectorAll('.filter-item');

            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                });

                items.forEach(item => {
                    item.addEventListener('click', function () {
                        if (currentFilterText) {
                            currentFilterText.innerText = this.innerText;
                        }
                        items.forEach(i => i.style.color = '#64748b');
                        this.style.color = '#1e293b';
                        menu.style.display = 'none';
                    });
                });

                document.addEventListener('click', () => menu.style.display = 'none');
            }

            // Map Logic
            var map = L.map('home-map', { scrollWheelZoom: false }).setView([33.5731, -7.5898], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            var reports = @json($recentReports);

            reports.forEach(function (report) {
                if (report.latitude && report.longitude) {
                    var color = report.status === 'terminee' ? '#16a34a' : '#f59e0b';
                    var icon = L.divIcon({
                        className: 'home-marker',
                        html: `<div style="background: ${color}; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px ${color}"></div>`,
                        iconSize: [16, 16]
                    });
                    L.marker([report.latitude, report.longitude], { icon: icon })
                        .bindPopup(`<b>${report.title}</b><br>${report.status}`)
                        .addTo(map);
                }
            });

            if (reports.length > 0) {
                var group = new L.featureGroup(reports.filter(r => r.latitude).map(r => L.marker([r.latitude, r.longitude])));
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>
@endsection