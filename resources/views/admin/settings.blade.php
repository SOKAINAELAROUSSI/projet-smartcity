@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Paramètres</h2>
            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Gérez votre profil administrateur et la configuration
                de la plateforme.</p>
        </div>
    </div>

    @if(session('success'))
        <div
            style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 24px; font-size: 0.85rem; font-weight: 700;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            style="padding: 12px 20px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; border-radius: 10px; margin-bottom: 24px; font-size: 0.85rem; font-weight: 700;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;">

        <!-- Profil Admin -->
        <div
            style="background: var(--card-bg); border-radius: 16px; padding: 24px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); color: var(--text-dark);">
            <h3
                style="font-size: 1.1rem; font-weight: 800; color: var(--text-dark); margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-person-badge" style="color: #3b82f6;"></i> Mon Profil
            </h3>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="profile" value="1">

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Nom
                        complet</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Adresse
                        email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Nouveau
                        mot de passe (optionnel)</label>
                    <input type="password" name="password"
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Confirmer
                        le mot de passe</label>
                    <input type="password" name="password_confirmation"
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='var(--border-color)'">
                </div>


                <button type="submit"
                    style="width: 100%; padding: 14px; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 800; font-size: 0.9rem; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    Mettre à jour le profil
                </button>
            </form>
        </div>

        <!-- Paramètres Plateforme -->
        <div
            style="background: var(--card-bg); border-radius: 16px; padding: 24px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); color: var(--text-dark);">
            <h3
                style="font-size: 1.1rem; font-weight: 800; color: var(--text-dark); margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-globe" style="color: #10b981;"></i> Informations Plateforme
            </h3>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="platform" value="1">

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Nom
                        de la plateforme</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Smart City Connect' }}"
                        required
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Email
                        de contact public</label>
                    <input type="email" name="contact_email"
                        value="{{ $settings['contact_email'] ?? 'contact@smartcityconnect.ma' }}" required
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Téléphone
                        support d'urgence</label>
                    <input type="text" name="support_phone" value="{{ $settings['support_phone'] ?? '+212 6 12 34 56 78' }}"
                        required
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Lien Facebook</label>
                    <input type="url" name="facebook_link" value="{{ $settings['facebook_link'] ?? '' }}"
                        placeholder="https://facebook.com/..."
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Lien Instagram</label>
                    <input type="url" name="instagram_link" value="{{ $settings['instagram_link'] ?? '' }}"
                        placeholder="https://instagram.com/..."
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Lien Twitter / X</label>
                    <input type="url" name="twitter_link" value="{{ $settings['twitter_link'] ?? '' }}"
                        placeholder="https://twitter.com/..."
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); font-size: 0.9rem; outline: none; background: var(--admin-bg); color: var(--text-dark); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='var(--border-color)'">
                </div>

                <div
                    style="margin-bottom: 24px; padding: 16px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--admin-bg); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <strong style="font-size: 0.9rem; color: var(--text-dark); display: block;">Mode
                            maintenance</strong>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Suspend l'accès public au portail
                            citoyen.</span>
                    </div>
                    <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0; position: absolute;">
                        <span
                            style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ ($settings['maintenance_mode'] ?? '0') === '1' ? '#ef4444' : '#cbd5e1' }}; transition: .4s; border-radius: 24px;">
                            <span
                                style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; transform: {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'translateX(20px)' : 'translateX(0)' }};"></span>
                        </span>
                    </label>
                </div>

                <button type="submit"
                    style="width: 100%; padding: 14px; background: #10b981; color: white; border: none; border-radius: 10px; font-weight: 800; font-size: 0.9rem; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                    Enregistrer les paramètres
                </button>
            </form>
        </div>
    </div>

    <script>
        // Custom toggle script for the checkbox UI
        document.querySelector('input[name="maintenance_mode"]').addEventListener('change', function () {
            const bg = this.nextElementSibling;
            const circle = bg.querySelector('span');
            if (this.checked) {
                bg.style.backgroundColor = '#ef4444';
                circle.style.transform = 'translateX(20px)';
            } else {
                bg.style.backgroundColor = '#cbd5e1';
                circle.style.transform = 'translateX(0)';
            }
        });
    </script>
@endsection