<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function assign(Request $request, Report $report)
    {
        $request->validate([
            'technician_id' => 'required|exists:users,id',
            'priority' => 'required|in:faible,moyenne,haute',
        ]);

        $intervention = Intervention::updateOrCreate(
            ['report_id' => $report->id],
            [
                'technician_id' => $request->technician_id,
                'priority' => $request->priority,
                'status' => 'en attente',
                'intervention_date' => now(),
            ]
        );

        $report->update(['status' => 'en cours']);

        // Notify technician
        $tech = User::find($request->technician_id);
        $tech->notify(
            "Nouvelle mission assignée",
            "Vous avez été assigné au signalement : " . $report->title,
            'info',
            route('reports.show', $report->id)
        );

        // Log action
        \App\Models\ActivityLog::log("Affectation de mission", "Affectation du technicien {$tech->name} au signalement #SGL-{$report->id} ({$report->title}).");

        return back()->with('success', 'Technicien affecté avec succès.');
    }

    public function citizens()
    {
        $users = User::where('role', 'citizen')->latest()->get();
        return view('admin.users.index', compact('users'))->with([
            'pageTitle' => 'Citoyens',
            'pageDesc' => 'Gérez les citoyens de la plateforme.'
        ]);
    }

    public function technicians()
    {
        $users = User::where('role', 'technician')->latest()->get();
        return view('admin.users.index', compact('users'))->with([
            'pageTitle' => 'Techniciens',
            'pageDesc' => 'Gérez les techniciens de la plateforme.'
        ]);
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }
        
        $userName = $user->name;
        $userEmail = $user->email;
        $userRole = $user->role === 'technician' ? 'technicien' : 'citoyen';
        
        $user->delete();
        
        // Log action
        \App\Models\ActivityLog::log("Suppression de compte", "Suppression du compte {$userRole} : {$userName} ({$userEmail}).");
        
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function map()
    {
        $reports = Report::with('category')->get();
        return view('admin.map', compact('reports'));
    }

    public function notifications()
    {
        $notifications = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->latest()
            ->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function markNotificationRead($id)
    {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();
            
        $notification->update(['is_read' => true]);
        
        return back();
    }

    public function deleteNotification($id)
    {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();
            
        $notification->delete();
        
        return back()->with('success', 'Notification supprimée avec succès.');
    }

    public function messages(\Illuminate\Http\Request $request)
    {
        // Get all technicians who have a "Support Administration" report
        $supportReports = Report::where('title', 'Support Administration')
            ->with(['user', 'comments' => function($q) {
                $q->latest()->limit(1);
            }])
            ->get();
            
        $activeReportId = $request->query('chat_id', $supportReports->first()->id ?? null);
        
        $activeReport = null;
        $comments = [];
        
        if ($activeReportId) {
            $activeReport = Report::find($activeReportId);
            if ($activeReport) {
                $comments = $activeReport->comments()->with('user')->oldest()->get();
            }
        }

        return view('admin.messages', compact('supportReports', 'activeReport', 'comments'));
    }

    public function sendMessage(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'content' => 'required|string',
        ]);
        
        \App\Models\Comment::create([
            'report_id' => $request->report_id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'content' => $request->content,
        ]);
        
        return back()->with('success', 'Message envoyé avec succès !');
    }

    public function initiateChat(User $user)
    {
        if ($user->role !== 'technician') {
            return back()->with('error', 'Vous ne pouvez discuter qu\'avec des techniciens.');
        }

        $supportReport = Report::firstOrCreate(
            [
                'user_id' => $user->id,
                'title' => "Support Administration",
            ],
            [
                'description' => "Canal de communication direct entre le technicien {$user->name} et l'administration SmartCity.",
                'address' => 'Hôtel de Ville',
                'latitude' => 33.5731,
                'longitude' => -7.5898,
                'category_id' => \App\Models\Category::first()->id ?? 1,
                'status' => 'en attente'
            ]
        );

        return redirect()->route('admin.messages', ['chat_id' => $supportReport->id]);
    }

    public function reviews()
    {
        $reviews = \App\Models\Rating::with(['report', 'technician'])->latest()->get();
        
        $avgScore = \App\Models\Rating::avg('score') ?? 0;
        $totalReviews = \App\Models\Rating::count();
        $excellent = \App\Models\Rating::where('score', '>=', 4)->count();
        $poor = \App\Models\Rating::where('score', '<=', 2)->count();
        
        return view('admin.reviews', compact('reviews', 'avgScore', 'totalReviews', 'excellent', 'poor'));
    }

    public function deleteReview($id)
    {
        $review = \App\Models\Rating::findOrFail($id);
        $techName = $review->technician ? $review->technician->name : 'technicien inconnu';
        $review->delete();
        
        // Log action
        \App\Models\ActivityLog::log("Suppression d'avis", "L'administrateur a supprimé un avis concernant le technicien {$techName}.");
        
        return back()->with('success', 'Avis supprimé avec succès.');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(\Illuminate\Http\Request $request)
    {
        if ($request->has('profile')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . \Illuminate\Support\Facades\Auth::id(),
                'password' => 'nullable|string|min:8|confirmed',
                'language' => 'nullable|string',
                'theme' => 'nullable|string',
            ]);

            $user = \Illuminate\Support\Facades\Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->password) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            
            if ($request->has('language')) {
                $user->language = $request->language;
            }
            if ($request->has('theme')) {
                $user->theme = $request->theme;
            }
            
            $user->save();
            
            // Log action
            \App\Models\ActivityLog::log("Modification de profil", "Mise à jour des informations du profil administrateur.");
            
            return back()->with('success', 'Profil mis à jour avec succès.');
        }

        if ($request->has('platform')) {
            $keys = ['site_name', 'contact_email', 'support_phone', 'maintenance_mode', 'facebook_link', 'instagram_link', 'twitter_link'];
            foreach ($keys as $key) {
                if ($request->has($key)) {
                    \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
                } else if ($key === 'maintenance_mode') {
                    // special case for checkbox
                    \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => '0']);
                }
            }
            
            // Log action
            \App\Models\ActivityLog::log("Modification des paramètres de la plateforme", "Mise à jour de la configuration de la plateforme.");
            
            return back()->with('success', 'Paramètres de la plateforme mis à jour.');
        }
        
        return back();
    }

    public function contacts()
    {
        // Auto-create table if it doesn't exist
        if (!\Illuminate\Support\Facades\Schema::hasTable('contact_messages')) {
            \Illuminate\Support\Facades\Schema::create('contact_messages', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('subject');
                $table->text('message');
                $table->timestamps();
            });
        }

        $messages = \App\Models\ContactMessage::latest()->get();
        return view('admin.contacts.index', compact('messages'));
    }

    public function deleteContact($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->delete();

        // Log action
        \App\Models\ActivityLog::log("Suppression de message citoyen", "L'administrateur a supprimé un message de contact de {$message->name}.");

        return back()->with('success', 'Message supprimé avec succès.');
    }

    public function activity()
    {
        $logs = \App\Models\ActivityLog::with('user')->latest()->get();
        return view('admin.activity', compact('logs'));
    }
}
