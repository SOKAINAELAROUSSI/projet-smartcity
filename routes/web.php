<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    $recentReports = \App\Models\Report::with('category')->latest()->take(10)->get();
    
    // Daily stats for the last 7 days
    $dailyStats = [];
    $maxCount = 0;
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $count = \App\Models\Report::whereDate('created_at', $date)->count();
        $dailyStats[] = [
            'day' => now()->subDays($i)->format('D'),
            'count' => $count,
        ];
        if ($count > $maxCount) $maxCount = $count;
    }
    
    // Normalize heights (min 10% if count > 0)
    foreach ($dailyStats as &$day) {
        $day['height'] = $maxCount > 0 ? ($day['count'] / $maxCount) * 90 + 10 : 0;
        if ($day['count'] == 0) $day['height'] = 10; // Base height for empty days
    }

    $stats = [
        'total' => \App\Models\Report::count(),
        'today' => \App\Models\Report::whereDate('created_at', now())->count(),
        'resolved' => \App\Models\Report::where('status', 'terminee')->count(),
        'active_techs' => \App\Models\User::where('role', 'technician')->count(),
        'resolution_rate' => \App\Models\Report::count() > 0 ? round((\App\Models\Report::where('status', 'terminee')->count() / \App\Models\Report::count()) * 100) : 100,
        'daily' => $dailyStats
    ];
    return view('welcome', compact('categories', 'recentReports', 'stats'));
});

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reports', ReportController::class);
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.my');

    // Custom Admin routes
    Route::post('/reports/{report}/assign', [AdminController::class, 'assign'])->name('admin.assign');
    Route::resource('categories', CategoryController::class);
    Route::get('/admin/citizens', [AdminController::class, 'citizens'])->name('admin.citizens.index');
    Route::get('/admin/technicians', [AdminController::class, 'technicians'])->name('admin.technicians.index');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/map', [AdminController::class, 'map'])->name('admin.map');
    Route::get('/admin/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::post('/admin/notifications/{id}/read', [AdminController::class, 'markNotificationRead'])->name('admin.notifications.read');
    Route::delete('/admin/notifications/{id}', [AdminController::class, 'deleteNotification'])->name('admin.notifications.destroy');
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::post('/admin/messages/send', [AdminController::class, 'sendMessage'])->name('admin.messages.send');
    Route::get('/admin/messages/initiate/{user}', [AdminController::class, 'initiateChat'])->name('admin.messages.initiate');
    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::delete('/admin/reviews/{id}', [AdminController::class, 'deleteReview'])->name('admin.reviews.destroy');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/admin/activity', [AdminController::class, 'activity'])->name('admin.activity');
    Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
    Route::delete('/admin/contacts/{id}', [AdminController::class, 'deleteContact'])->name('admin.contacts.destroy');
    // Custom Technician routes
    Route::post('/reports/{report}/update', [TechnicianController::class, 'update'])->name('technician.update');
    Route::post('/reports/{report}/accept', [TechnicianController::class, 'accept'])->name('technician.accept');
    Route::post('/reports/{report}/reject', [TechnicianController::class, 'reject'])->name('technician.reject');
    Route::get('/technician/profile', [TechnicianController::class, 'profile'])->name('technician.profile');
    Route::post('/technician/profile', [TechnicianController::class, 'updateProfile'])->name('technician.profile.update');
    Route::get('/technician/missions', [TechnicianController::class, 'index'])->name('technician.missions.index');
    Route::get('/technician/missions/{intervention}', [TechnicianController::class, 'showMission'])->name('technician.mission.show');
    Route::get('/technician/map', [TechnicianController::class, 'map'])->name('technician.map');
    Route::get('/technician/stats', [TechnicianController::class, 'stats'])->name('technician.stats');
    Route::get('/technician/reviews', [TechnicianController::class, 'reviews'])->name('technician.reviews');
    Route::get('/technician/messages', [TechnicianController::class, 'messages'])->name('technician.messages');
    Route::post('/technician/messages/send', [TechnicianController::class, 'sendMessage'])->name('technician.messages.send');
    Route::get('/technician/notifications', [TechnicianController::class, 'notifications'])->name('technician.notifications');
    Route::get('/technician/settings', [TechnicianController::class, 'settings'])->name('technician.settings');
    Route::post('/technician/settings', [TechnicianController::class, 'updateSettings'])->name('technician.settings.update');
    Route::post('/technician/settings/password', [TechnicianController::class, 'updatePassword'])->name('technician.settings.password');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
