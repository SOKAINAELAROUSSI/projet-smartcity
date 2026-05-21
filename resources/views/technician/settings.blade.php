@php
    $lang = $profile->language ?? 'fr';
    // Translate dictionary
    $t = [
        'fr' => [
            'settings' => 'Paramètres — Côté Technicien',
            'sub' => 'Gérez vos informations personnelles, vos spécialités et vos préférences de fonctionnement.',
            'profile' => 'Mon Profil',
            'speciality' => 'Ma Spécialité',
            'availability' => 'Disponibilité',
            'notifications' => 'Notifications',
            'security' => 'Sécurité',
            'appearance' => 'Apparence',
            'language' => 'Langue',
            'history' => 'Historique',
            'name' => 'Nom complet',
            'email' => 'Adresse e-mail',
            'phone' => 'Téléphone',
            'city' => 'Ville',
            'photo' => 'Photo de profil',
            'domain' => 'Choisir le domaine',
            'status' => 'Changer le statut',
            'status_dispo' => 'Disponible',
            'status_occup' => 'Occupé',
            'status_hors' => 'Hors ligne',
            'notif_new' => 'Nouvelle mission',
            'notif_admin' => 'Messages admin',
            'notif_urgent' => 'Missions urgentes',
            'pwd_curr' => 'Mot de passe actuel',
            'pwd_new' => 'Nouveau mot de passe',
            'pwd_conf' => 'Confirmer le nouveau mot de passe',
            'pwd_btn' => 'Modifier le mot de passe',
            'logout' => 'Déconnexion',
            'theme' => 'Mode d\'apparence',
            'theme_light' => 'Mode clair',
            'theme_dark' => 'Mode sombre',
            'lang_select' => 'Choisir la langue',
            'hist_finished' => 'Missions terminées',
            'hist_old' => 'Anciennes interventions',
            'save' => 'Enregistrer les paramètres',
            'success' => 'Paramètres mis à jour avec succès !',
            'no_history' => 'Aucune intervention terminée.',
            'electricity' => 'Électricité',
            'water' => 'Eau',
            'roads' => 'Routes',
            'waste' => 'Déchets',
            'lighting' => 'Éclairage',
            'notif_sub' => 'Activez ou désactivez les notifications suivantes :'
        ],
        'ar' => [
            'settings' => 'الإعدادات — جانب التقني',
            'sub' => 'إدارة معلوماتك الشخصية، تخصصاتك وتفضيلات التشغيل الخاصة بك.',
            'profile' => 'الملف الشخصي',
            'speciality' => 'تخصصي',
            'availability' => 'التوفر والجاهزية',
            'notifications' => 'الإشعارات',
            'security' => 'الأمان',
            'appearance' => 'المظهر',
            'language' => 'اللغة',
            'history' => 'السجل والأرشيف',
            'name' => 'الاسم الكامل',
            'email' => 'البريد الإلكتروني',
            'phone' => 'الهاتف',
            'city' => 'المدينة',
            'photo' => 'الصورة الشخصية',
            'domain' => 'اختر المجال',
            'status' => 'تغيير الحالة',
            'status_dispo' => 'متاح',
            'status_occup' => 'مشغول',
            'status_hors' => 'غير متصل',
            'notif_new' => 'مهمة جديدة',
            'notif_admin' => 'رسائل الإدارة',
            'notif_urgent' => 'مهام عاجلة',
            'pwd_curr' => 'كلمة المرور الحالية',
            'pwd_new' => 'كلمة المرور الجديدة',
            'pwd_conf' => 'تأكيد كلمة المرور الجديدة',
            'pwd_btn' => 'تعديل كلمة المرور',
            'logout' => 'تسجيل الخروج',
            'theme' => 'وضع المظهر',
            'theme_light' => 'وضع النهار',
            'theme_dark' => 'الوضع الداكن',
            'lang_select' => 'اختر اللغة',
            'hist_finished' => 'المهام المكتملة',
            'hist_old' => 'التدخلات السابقة',
            'save' => 'حفظ الإعدادات',
            'success' => 'تم تحديث الإعدادات بنجاح!',
            'no_history' => 'لا توجد تدخلات منتهية.',
            'electricity' => 'الكهرباء',
            'water' => 'الماء',
            'roads' => 'الطرق',
            'waste' => 'النفايات',
            'lighting' => 'الإنارة',
            'notif_sub' => 'تفعيل أو تعطيل الإشعارات التالية :'
        ],
        'en' => [
            'settings' => 'Settings — Technician Side',
            'sub' => 'Manage your personal information, specialties and operating preferences.',
            'profile' => 'My Profile',
            'speciality' => 'My Specialty',
            'availability' => 'Availability',
            'notifications' => 'Notifications',
            'security' => 'Security',
            'appearance' => 'Appearance',
            'language' => 'Language',
            'history' => 'History',
            'name' => 'Full Name',
            'email' => 'Email Address',
            'phone' => 'Phone',
            'city' => 'City',
            'photo' => 'Profile Picture',
            'domain' => 'Choose Domain',
            'status' => 'Change Status',
            'status_dispo' => 'Available',
            'status_occup' => 'Busy',
            'status_hors' => 'Offline',
            'notif_new' => 'New Mission',
            'notif_admin' => 'Admin Messages',
            'notif_urgent' => 'Urgent Missions',
            'pwd_curr' => 'Current Password',
            'pwd_new' => 'New Password',
            'pwd_conf' => 'Confirm New Password',
            'pwd_btn' => 'Update Password',
            'logout' => 'Logout',
            'theme' => 'Appearance Mode',
            'theme_light' => 'Light Mode',
            'theme_dark' => 'Dark Mode',
            'lang_select' => 'Choose Language',
            'hist_finished' => 'Completed Missions',
            'hist_old' => 'Past Interventions',
            'save' => 'Save Settings',
            'success' => 'Settings updated successfully!',
            'no_history' => 'No completed interventions.',
            'electricity' => 'Electricity',
            'water' => 'Water',
            'roads' => 'Roads',
            'waste' => 'Waste',
            'lighting' => 'Lighting',
            'notif_sub' => 'Enable or disable the following notifications:'
        ]
    ];

    $texts = $t[$lang] ?? $t['fr'];
    $isRTL = ($lang === 'ar');
@endphp

@extends('layouts.technician')

@section('title', $texts['settings'])

@section('content')
<div style="direction: {{ $isRTL ? 'rtl' : 'ltr' }}; text-align: {{ $isRTL ? 'right' : 'left' }}; font-family: 'Inter', sans-serif;">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 1.75rem; font-weight: 900; margin: 0 0 4px; font-family: 'Outfit', sans-serif; color: var(--text-color);">
            {{ $texts['settings'] }}
        </h1>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">{{ $texts['sub'] }}</p>
    </div>

    @if(session('success'))
        <div style="padding: 16px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 700;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 16px 20px; background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 700;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-container">
        <!-- Settings Nav Sidebar -->
        <div class="settings-nav">
            <button class="nav-btn active" onclick="switchTab(event, 'tab-profile')">
                <span class="icon"><i class="bi bi-person-fill"></i></span> {{ $texts['profile'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-speciality')">
                <span class="icon"><i class="bi bi-tools"></i></span> {{ $texts['speciality'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-availability')">
                <span class="icon"><i class="bi bi-traffic-light"></i></span> {{ $texts['availability'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-notifications')">
                <span class="icon"><i class="bi bi-bell-fill"></i></span> {{ $texts['notifications'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-appearance')">
                <span class="icon"><i class="bi bi-palette-fill"></i></span> {{ $texts['appearance'] }} / {{ $texts['language'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-security')">
                <span class="icon"><i class="bi bi-lock-fill"></i></span> {{ $texts['security'] }}
            </button>
            <button class="nav-btn" onclick="switchTab(event, 'tab-history')">
                <span class="icon"><i class="bi bi-clock-history"></i></span> {{ $texts['history'] }}
            </button>
        </div>

        <!-- Settings Content Card -->
        <div class="card settings-content">
            <form action="{{ route('technician.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- 1. MON PROFIL -->
                <div id="tab-profile" class="tab-pane active">
                    <h3 class="pane-title">{{ $texts['profile'] }}</h3>
                    
                    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px; flex-wrap: wrap;">
                        <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: #e2e8f0; border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--text-muted); font-weight: 700;">
                            @if($profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ substr($user->name, 0, 1) }}
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label class="form-label">{{ $texts['photo'] }}</label>
                            <input type="file" name="photo" class="form-input" style="padding: 8px;">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">{{ $texts['name'] }}</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ $texts['email'] }}</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ $texts['phone'] }}</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="form-input" placeholder="Ex: 0612345678">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ $texts['city'] }}</label>
                            <input type="text" name="city" value="{{ old('city', $profile->city) }}" class="form-input" placeholder="Ex: Casablanca">
                        </div>
                    </div>
                </div>

                <!-- 2. MA SPECIALITE -->
                <div id="tab-speciality" class="tab-pane">
                    <h3 class="pane-title">{{ $texts['speciality'] }}</h3>
                    <div class="form-group" style="max-width: 500px;">
                        <label class="form-label">{{ $texts['domain'] }}</label>
                        <select name="speciality" class="form-select">
                            <option value="">-- {{ $texts['domain'] }} --</option>
                            <option value="Électricité" {{ $profile->speciality == 'Électricité' ? 'selected' : '' }}>{{ $texts['electricity'] }}</option>
                            <option value="Eau" {{ $profile->speciality == 'Eau' ? 'selected' : '' }}>{{ $texts['water'] }}</option>
                            <option value="Routes" {{ $profile->speciality == 'Routes' ? 'selected' : '' }}>{{ $texts['roads'] }}</option>
                            <option value="Déchets" {{ $profile->speciality == 'Déchets' ? 'selected' : '' }}>{{ $texts['waste'] }}</option>
                            <option value="Éclairage" {{ $profile->speciality == 'Éclairage' ? 'selected' : '' }}>{{ $texts['lighting'] }}</option>
                        </select>
                    </div>
                </div>

                <!-- 3. DISPONIBILITE -->
                <div id="tab-availability" class="tab-pane">
                    <h3 class="pane-title">{{ $texts['availability'] }}</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">{{ $texts['status'] }}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 14px; max-width: 400px;">
                        @php
                            $currStatus = $profile->availability_status ?? 'disponible';
                        @endphp
                        <label class="radio-card {{ $currStatus === 'disponible' ? 'active' : '' }}">
                            <input type="radio" name="availability_status" value="disponible" {{ $currStatus === 'disponible' ? 'checked' : '' }} onchange="updateRadioSelection(this)">
                            <span class="status-dot online"></span>
                            <span style="font-weight: 700; color: var(--text-color);">{{ $texts['status_dispo'] }}</span>
                        </label>
                        <label class="radio-card {{ $currStatus === 'occupe' ? 'active' : '' }}">
                            <input type="radio" name="availability_status" value="occupe" {{ $currStatus === 'occupe' ? 'checked' : '' }} onchange="updateRadioSelection(this)">
                            <span class="status-dot busy"></span>
                            <span style="font-weight: 700; color: var(--text-color);">{{ $texts['status_occup'] }}</span>
                        </label>
                        <label class="radio-card {{ $currStatus === 'hors_ligne' ? 'active' : '' }}">
                            <input type="radio" name="availability_status" value="hors_ligne" {{ $currStatus === 'hors_ligne' ? 'checked' : '' }} onchange="updateRadioSelection(this)">
                            <span class="status-dot offline"></span>
                            <span style="font-weight: 700; color: var(--text-color);">{{ $texts['status_hors'] }}</span>
                        </label>
                    </div>
                </div>

                <!-- 4. NOTIFICATIONS -->
                <div id="tab-notifications" class="tab-pane">
                    <h3 class="pane-title">{{ $texts['notifications'] }}</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">{{ $texts['notif_sub'] }}</p>

                    <div style="display: flex; flex-direction: column; gap: 16px; max-width: 500px;">
                        <label class="switch-row">
                            <span style="font-weight: 600; color: var(--text-color);">{{ $texts['notif_new'] }}</span>
                            <span class="switch">
                                <input type="checkbox" name="notif_new_mission" {{ $profile->notif_new_mission ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </span>
                        </label>
                        <label class="switch-row">
                            <span style="font-weight: 600; color: var(--text-color);">{{ $texts['notif_admin'] }}</span>
                            <span class="switch">
                                <input type="checkbox" name="notif_admin_messages" {{ $profile->notif_admin_messages ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </span>
                        </label>
                        <label class="switch-row">
                            <span style="font-weight: 600; color: var(--text-color);">{{ $texts['notif_urgent'] }}</span>
                            <span class="switch">
                                <input type="checkbox" name="notif_urgent_missions" {{ $profile->notif_urgent_missions ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- 5. APPARENCE & LANGUE -->
                <div id="tab-appearance" class="tab-pane">
                    <h3 class="pane-title">{{ $texts['appearance'] }} & {{ $texts['language'] }}</h3>

                    <!-- Apparence -->
                    <div style="margin-bottom: 30px;">
                        <label class="form-label" style="margin-bottom: 12px;">{{ $texts['theme'] }}</label>
                        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                            @php
                                $currTheme = $profile->theme ?? 'light';
                            @endphp
                            <label class="theme-card {{ $currTheme === 'light' ? 'active' : '' }}" onclick="previewTheme('light')">
                                <input type="radio" name="theme" value="light" {{ $currTheme === 'light' ? 'checked' : '' }} style="display:none;">
                                <div class="theme-preview light">
                                    <div class="preview-sidebar"></div>
                                    <div class="preview-body"></div>
                                </div>
                                <span style="font-size: 0.85rem; font-weight: 700; margin-top: 6px;">☀️ {{ $texts['theme_light'] }}</span>
                            </label>
                            <label class="theme-card {{ $currTheme === 'dark' ? 'active' : '' }}" onclick="previewTheme('dark')">
                                <input type="radio" name="theme" value="dark" {{ $currTheme === 'dark' ? 'checked' : '' }} style="display:none;">
                                <div class="theme-preview dark">
                                    <div class="preview-sidebar"></div>
                                    <div class="preview-body"></div>
                                </div>
                                <span style="font-size: 0.85rem; font-weight: 700; margin-top: 6px;">🌙 {{ $texts['theme_dark'] }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Langue -->
                    <div>
                        <label class="form-label" style="margin-bottom: 8px;">{{ $texts['lang_select'] }}</label>
                        <select name="language" class="form-select" style="max-width: 300px;">
                            <option value="fr" {{ $lang === 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                            <option value="ar" {{ $lang === 'ar' ? 'selected' : '' }}>🇲🇦 العربية (Arabic)</option>
                            <option value="en" {{ $lang === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions" id="main-actions">
                    <button type="submit" class="btn-primary">
                        {{ $texts['save'] }}
                    </button>
                </div>
            </form>

            <!-- 6. SECURITE (PASSWORD & LOGOUT) -->
            <div id="tab-security" class="tab-pane">
                <h3 class="pane-title">{{ $texts['security'] }}</h3>
                
                <form action="{{ route('technician.settings.password') }}" method="POST" style="max-width: 500px; margin-bottom: 40px;">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">{{ $texts['pwd_curr'] }}</label>
                        <input type="password" name="current_password" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ $texts['pwd_new'] }}</label>
                        <input type="password" name="new_password" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ $texts['pwd_conf'] }}</label>
                        <input type="password" name="new_password_confirmation" required class="form-input">
                    </div>
                    <button type="submit" class="btn-secondary" style="margin-top: 10px;">
                        {{ $texts['pwd_btn'] }}
                    </button>
                </form>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 30px 0;">

                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-danger" style="display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            {{ $texts['logout'] }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- 7. HISTORIQUE -->
            <div id="tab-history" class="tab-pane">
                <h3 class="pane-title">{{ $texts['history'] }}</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
                    <a href="{{ route('technician.missions.index', ['status' => 'terminee']) }}" class="history-link-card">
                        <div class="card-icon" style="color: #10b981; font-size: 2rem; display: flex; align-items: center;"><i class="bi bi-check-circle-fill"></i></div>
                        <div style="flex:1;">
                            <h4 style="margin: 0 0 4px; font-weight: 800; color: var(--text-color);">{{ $texts['hist_finished'] }}</h4>
                            <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">Afficher la liste de vos interventions complétées.</p>
                        </div>
                    </a>
                    <a href="{{ route('technician.missions.index') }}" class="history-link-card">
                        <div class="card-icon" style="color: #3b82f6; font-size: 2rem; display: flex; align-items: center;"><i class="bi bi-clock-history"></i></div>
                        <div style="flex:1;">
                            <h4 style="margin: 0 0 4px; font-weight: 800; color: var(--text-color);">{{ $texts['hist_old'] }}</h4>
                            <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">Consulter l'ensemble de votre parcours d'interventions.</p>
                        </div>
                    </a>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 24px;">
                    <h4 style="font-weight: 800; color: var(--text-color); margin-bottom: 16px;">Missions terminées récentes</h4>
                    
                    @if($completedInterventions->isEmpty())
                        <div style="padding: 24px; text-align: center; color: var(--text-muted); background: var(--bg-color); border-radius: 12px;">
                            {{ $texts['no_history'] }}
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($completedInterventions as $intervention)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 12px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-color);">{{ $intervention->report->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">{{ $intervention->report->address }}</div>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="font-size: 0.75rem; font-weight: 800; background: #e6fcf5; color: #0ca678; padding: 4px 10px; border-radius: 100px;">
                                            Complété
                                        </span>
                                        <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ $intervention->updated_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Settings Grid Layout */
    .settings-container {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* Sidebar Navigation */
    .settings-nav {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .nav-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: transparent;
        border: none;
        border-radius: 12px;
        color: var(--text-muted);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        text-align: inherit;
        transition: all 0.2s ease;
    }

    .nav-btn:hover {
        background: var(--link-hover-bg);
        color: var(--text-color);
    }

    .nav-btn.active {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
    }

    .nav-btn .icon {
        font-size: 1.15rem;
    }

    /* Content Area */
    .settings-content {
        padding: 32px;
        min-height: 480px;
        position: relative;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pane-title {
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0 0 24px;
        color: var(--text-color);
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    /* Form Fields */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--bg-color);
        color: var(--text-color);
        outline: none;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Availability Radio Cards */
    .radio-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .radio-card:hover {
        background: var(--link-hover-bg);
    }

    .radio-card.active {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }

    .radio-card input[type="radio"] {
        display: none;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .status-dot.online { background: #10b981; }
    .status-dot.busy { background: #f59e0b; }
    .status-dot.offline { background: #64748b; }

    /* Switch Component */
    .switch-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        cursor: pointer;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: var(--border-color);
        transition: .3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #10b981;
    }

    input:checked + .slider:before {
        transform: translateX(20px);
    }

    /* Buttons */
    .form-actions {
        margin-top: 30px;
        border-top: 1px solid var(--border-color);
        padding-top: 24px;
        display: flex;
        justify-content: flex-end;
    }

    .btn-primary {
        padding: 12px 24px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: #0d9488;
    }

    .btn-secondary {
        padding: 12px 24px;
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: var(--link-hover-bg);
    }

    .btn-danger {
        padding: 12px 24px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Appearance Cards */
    .theme-card {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 10px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.2s;
    }

    .theme-card:hover {
        border-color: #10b981;
    }

    .theme-card.active {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.03);
    }

    .theme-preview {
        width: 140px;
        height: 80px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        display: flex;
    }

    .theme-preview.light {
        background: #f8fafc;
    }
    .theme-preview.light .preview-sidebar {
        width: 35px;
        background: white;
        border-right: 1px solid #e2e8f0;
    }
    .theme-preview.light .preview-body {
        flex: 1;
        background: #f8fafc;
    }

    .theme-preview.dark {
        background: #0b0f19;
    }
    .theme-preview.dark .preview-sidebar {
        width: 35px;
        background: #111827;
        border-right: 1px solid #1f2937;
    }
    .theme-preview.dark .preview-body {
        flex: 1;
        background: #0b0f19;
    }

    /* History Cards */
    .history-link-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: var(--bg-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .history-link-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.05);
        border-color: #10b981;
    }

    .card-icon {
        font-size: 2rem;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .settings-container {
            grid-template-columns: 1fr;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function switchTab(evt, tabName) {
        // Get all elements with class="tab-pane" and hide them
        const tabPanes = document.getElementsByClassName("tab-pane");
        for (let i = 0; i < tabPanes.length; i++) {
            tabPanes[i].classList.remove("active");
        }

        // Get all elements with class="nav-btn" and remove the class "active"
        const navBtns = document.getElementsByClassName("nav-btn");
        for (let i = 0; i < navBtns.length; i++) {
            navBtns[i].classList.remove("active");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");

        // Hide or show the main form save actions based on active tab
        const actionsDiv = document.getElementById("main-actions");
        if (tabName === 'tab-security' || tabName === 'tab-history') {
            actionsDiv.style.display = 'none';
        } else {
            actionsDiv.style.display = 'flex';
        }
    }

    function updateRadioSelection(radioInput) {
        const cards = document.getElementsByClassName("radio-card");
        for(let i=0; i<cards.length; i++) {
            cards[i].classList.remove("active");
        }
        if(radioInput.checked) {
            radioInput.parentElement.classList.add("active");
        }
    }

    function previewTheme(themeName) {
        const cards = document.getElementsByClassName("theme-card");
        for(let i=0; i<cards.length; i++) {
            cards[i].classList.remove("active");
        }
        
        const selectedRadio = document.querySelector(`input[name="theme"][value="${themeName}"]`);
        selectedRadio.checked = true;
        selectedRadio.parentElement.classList.add("active");

        // Dynamically toggle body class for instant feedback
        const bodyClassList = document.body.classList;
        if (themeName === 'dark') {
            bodyClassList.add('dark-theme');
        } else {
            bodyClassList.remove('dark-theme');
        }
    }
</script>
@endsection
