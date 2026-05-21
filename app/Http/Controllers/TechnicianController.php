<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Intervention;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->interventions()->with('report');

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'en_cours') {
                $query->whereIn('status', ['acceptée', 'en cours']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $interventions = $query->latest()->get();

        return view('technician.missions-index', compact('interventions'));
    }

    public function showMission(Intervention $intervention)
    {
        if ($intervention->technician_id !== Auth::id()) {
            abort(403);
        }

        $report = $intervention->report;
        $comments = $report->comments()->latest()->get();

        return view('technician.mission-show', compact('intervention', 'report', 'comments'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:en cours,terminee',
            'after_image' => 'nullable|image|max:2048',
            'photo_before' => 'nullable|image|max:2048',
            'comment' => 'nullable|string',
            'technical_notes' => 'nullable|string',
        ]);

        $report->status = $request->status;
        
        if ($request->hasFile('after_image')) {
            $report->after_image = $request->file('after_image')->store('reports', 'public');
        }
        
        $report->save();

        $intervention = $report->interventions()->where('technician_id', Auth::id())->first();
        if ($intervention) {
            $intervention->status = $request->status;
            if ($request->hasFile('photo_before')) {
                $intervention->photo_before = $request->file('photo_before')->store('interventions', 'public');
            }
            if ($request->hasFile('after_image')) {
                $intervention->photo_after = $report->after_image;
            }
            if ($request->filled('technical_notes')) {
                $intervention->technical_notes = $request->technical_notes;
            }
            $intervention->save();
        }

        Comment::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
            'content' => $request->comment ?? "Le technicien a mis à jour le statut vers : " . $request->status,
        ]);

        $report->user->notify(
            "Mise à jour de votre signalement",
            "Votre signalement '" . $report->title . "' est maintenant : " . $request->status,
            $request->status === 'terminee' ? 'success' : 'info',
            route('reports.show', $report->id)
        );

        return back()->with('success', 'Rapport mis à jour avec succès !');
    }

    public function accept(Report $report)
    {
        $intervention = $report->interventions()->where('technician_id', Auth::id())->first();
        if ($intervention) {
            $intervention->status = 'en cours';
            $intervention->save();
            $report->status = 'en cours';
            $report->save();
            
            Comment::create([
                'report_id' => $report->id,
                'user_id' => Auth::id(),
                'content' => "Le technicien a accepté la mission.",
            ]);

            $report->user->notify(
                "Mission acceptée",
                "Un technicien a commencé à travailler sur votre signalement : " . $report->title,
                'info',
                route('reports.show', $report->id)
            );
        }
        return back()->with('success', 'Mission acceptée !');
    }

    public function reject(Report $report)
    {
        $intervention = $report->interventions()->where('technician_id', Auth::id())->first();
        if ($intervention) {
            $intervention->delete();
            $report->status = 'en attente';
            $report->save();
            
            Comment::create([
                'report_id' => $report->id,
                'user_id' => Auth::id(),
                'content' => "Le technicien a refusé la mission.",
            ]);
        }
        return redirect()->route('dashboard')->with('success', 'Mission refusée.');
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->technicianProfile ?? \App\Models\TechnicianProfile::create(['user_id' => $user->id, 'is_available' => true]);
        return view('technician.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->technicianProfile;
        $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);
        $user->update(['name' => $request->name]);
        $data = $request->only(['speciality', 'city', 'phone']);
        $data['is_available'] = $request->has('is_available');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('technicians', 'public');
        }
        $profile->update($data);
        return back()->with('success', 'Profil mis à jour !');
    }

    public function map()
    {
        $user = Auth::user();
        $interventions = $user->interventions()->with('report')->whereIn('status', ['acceptée', 'en cours'])->get();
        return view('technician.map', compact('interventions'));
    }

    public function stats()
    {
        $user = Auth::user();
        $total = $user->interventions()->count();
        $resolved = $user->interventions()->where('status', 'terminee')->count();
        $in_progress = $user->interventions()->whereIn('status', ['acceptée', 'en cours'])->count();
        $pending = $user->interventions()->where('status', 'en attente')->count();
        
        $success_rate = $total > 0 ? round(($resolved / $total) * 100) : 100;
        
        // Fetch real count of resolved interventions for the last 6 months
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->translatedFormat('M'); // E.g., Jan, Fév, Mar
            
            $count = $user->interventions()
                ->where('status', 'terminee')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();
                
            $data[] = $count;
        }
        
        $monthly_stats = [
            'labels' => $labels,
            'resolved' => $data
        ];

        // Calculate actual average resolution duration
        $resolvedInterventions = $user->interventions()->where('status', 'terminee')->get();
        $totalMinutes = 0;
        $countResolved = $resolvedInterventions->count();
        foreach ($resolvedInterventions as $intervention) {
            $totalMinutes += $intervention->created_at->diffInMinutes($intervention->updated_at);
        }
        $avg_time = 'Aucune';
        if ($countResolved > 0) {
            $avgMinutes = round($totalMinutes / $countResolved);
            $hours = floor($avgMinutes / 60);
            $mins = $avgMinutes % 60;
            $avg_time = $hours > 0 ? "{$hours}h {$mins}m" : "{$mins}m";
        }

        return view('technician.stats', compact('total', 'resolved', 'in_progress', 'pending', 'success_rate', 'monthly_stats', 'avg_time'));
    }

    public function reviews()
    {
        $user = Auth::user();
        $ratings = \App\Models\Rating::where('technician_id', $user->id)
            ->with(['report', 'report.user'])
            ->latest()
            ->get();
            
        $averageRating = $ratings->avg('score') ?? ($user->technicianProfile->rating ?? 5.0);

        return view('technician.reviews', compact('ratings', 'averageRating'));
    }

    public function messages(Request $request)
    {
        $user = Auth::user();
        
        // Find or create the dedicated support/admin channel for this technician
        $supportReport = \App\Models\Report::firstOrCreate(
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
        
        $comments = $supportReport->comments()->with('user')->oldest()->get();
        
        return view('technician.messages', compact('supportReport', 'comments'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'content' => 'required|string',
        ]);
        
        \App\Models\Comment::create([
            'report_id' => $request->report_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        
        return back()->with('success', 'Message envoyé avec succès !');
    }

    public function notifications()
    {
        $notifications = \App\Models\Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('technician.notifications', compact('notifications'));
    }

    public function settings()
    {
        $user = Auth::user();
        $profile = $user->technicianProfile ?? \App\Models\TechnicianProfile::create(['user_id' => $user->id, 'is_available' => true]);
        
        $completedInterventions = $user->interventions()
            ->with('report')
            ->where('status', 'terminee')
            ->latest()
            ->take(5)
            ->get();
            
        return view('technician.settings', compact('user', 'profile', 'completedInterventions'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $profile = $user->technicianProfile ?? \App\Models\TechnicianProfile::create(['user_id' => $user->id, 'is_available' => true]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'speciality' => 'nullable|string|in:Électricité,Eau,Routes,Déchets,Éclairage',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'availability_status' => 'required|in:disponible,occupe,hors_ligne',
            'theme' => 'required|in:light,dark',
            'language' => 'required|in:fr,ar,en',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $profileData = [
            'speciality' => $request->speciality,
            'city' => $request->city,
            'phone' => $request->phone,
            'availability_status' => $request->availability_status,
            'is_available' => $request->availability_status === 'disponible',
            'theme' => $request->theme,
            'language' => $request->language,
            'notif_new_mission' => $request->has('notif_new_mission'),
            'notif_admin_messages' => $request->has('notif_admin_messages'),
            'notif_urgent_missions' => $request->has('notif_urgent_missions'),
        ];

        if ($request->hasFile('photo')) {
            $profileData['photo'] = $request->file('photo')->store('technicians', 'public');
        }

        $profile->update($profileData);

        return back()->with('success', 'Paramètres mis à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès !');
    }
}
