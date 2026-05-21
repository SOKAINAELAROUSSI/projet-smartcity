<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'citizen') {
            return redirect('/');
        }

        $query = Report::query();

        // Search and Filtering
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($user->role === 'citizen') {
            $reports = (clone $query)->where('user_id', $user->id)->latest()->get();
            $stats = [
                'Total' => $user->reports()->count(),
                'En Attente' => $user->reports()->where('status', 'en attente')->count(),
                'Résolus' => $user->reports()->where('status', 'terminee')->count(),
            ];
        } elseif ($user->role === 'admin') {
            // === ADMIN DASHBOARD DATA ===
            $totalReports = Report::count();
            $resolvedReports = Report::where('status', 'terminee')->count();
            $enCoursReports = Report::where('status', 'en cours')->count();
            $totalTechnicians = User::where('role', 'technician')->count();
            $newToday = Report::whereDate('created_at', now())->count();
            $resolutionRate = $totalReports > 0 ? round(($resolvedReports / $totalReports) * 100, 1) : 0;

            $avgRating = \App\Models\Rating::avg('score');
            $totalRatings = \App\Models\Rating::count();

            $adminStats = [
                'total' => $totalReports,
                'resolved' => $resolvedReports,
                'en_cours' => $enCoursReports,
                'technicians' => $totalTechnicians,
                'new_today' => $newToday,
                'resolution_rate' => $resolutionRate,
                'avg_rating' => number_format($avgRating ?? 0, 1),
                'total_ratings' => $totalRatings,
            ];

            // Chart data: last 30 days grouped by date
            $chartLabels = [];
            $chartData = [];
            $chartResolved = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $chartLabels[] = $date->format('d M');
                $chartData[] = Report::whereDate('created_at', $date)->count();
                $chartResolved[] = Report::whereDate('updated_at', $date)->where('status', 'terminee')->count();
            }

            // Category stats
            $categories = \App\Models\Category::withCount('reports')->get();
            $catColors = ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4','#ec4899'];
            $categoryStats = [];
            foreach ($categories as $idx => $cat) {
                $categoryStats[] = [
                    'name' => $cat->name,
                    'count' => $cat->reports_count,
                    'pct' => $totalReports > 0 ? round(($cat->reports_count / $totalReports) * 100) : 0,
                    'color' => $catColors[$idx % count($catColors)],
                ];
            }

            // Map reports
            $mapReports = Report::select('id','title','latitude','longitude','status')->get()->toArray();

            // Recent reports
            $recentReports = Report::with(['category','user'])->latest()->take(5)->get();

            // Recent activity
            $recentActivities = [];
            $latestReports = Report::latest()->take(5)->get();
            foreach ($latestReports as $r) {
                $icons = ['en attente' => 'bi-flag', 'en cours' => 'bi-arrow-repeat', 'terminee' => 'bi-check-lg'];
                $colors = ['en attente' => '#f59e0b', 'en cours' => '#3b82f6', 'terminee' => '#10b981'];
                $bgs = ['en attente' => '#fef3c7', 'en cours' => '#dbeafe', 'terminee' => '#d1fae5'];
                $recentActivities[] = [
                    'text' => 'Le signalement #SGL-' . $r->id . ' — ' . \Illuminate\Support\Str::limit($r->title, 30),
                    'time' => $r->created_at->diffForHumans(),
                    'icon' => $icons[$r->status] ?? 'bi-info-circle',
                    'color' => $colors[$r->status] ?? '#64748b',
                    'bg' => $bgs[$r->status] ?? '#f1f5f9',
                ];
            }

            // Top technicians
            $topTechnicians = [];
            $topProfiles = \App\Models\TechnicianProfile::with('user')->orderBy('rating', 'desc')->take(3)->get();
            foreach ($topProfiles as $tp) {
                $totalInterv = \App\Models\Intervention::where('technician_id', $tp->user_id)->count();
                $doneInterv = \App\Models\Intervention::where('technician_id', $tp->user_id)->where('status', 'terminee')->count();
                $topTechnicians[] = [
                    'name' => $tp->user->name ?? 'Technicien',
                    'rate' => $totalInterv > 0 ? round(($doneInterv / $totalInterv) * 100) : 0,
                    'rating' => number_format($tp->rating ?? 0, 1),
                ];
            }

            // Overview stats
            $monthTotal = Report::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $overviewStats = [
                'avg_time' => '12h 30m',
                'month_total' => $monthTotal,
                'resolution_rate' => $resolutionRate,
                'satisfaction' => number_format($avgRating ?? 0, 1),
            ];

            return view('admin.dashboard', compact(
                'adminStats', 'chartLabels', 'chartData', 'chartResolved',
                'categoryStats', 'mapReports', 'recentReports', 'recentActivities',
                'topTechnicians', 'overviewStats'
            ));
        } elseif ($user->role === 'technician') {
            $interventions = $user->interventions()->with('report')->latest()->get();

            $technicianProfile = $user->technicianProfile;
            $averageRating = $technicianProfile ? $technicianProfile->rating : 0;

            $enAttenteCount = $interventions->where('status', 'en attente')->count();
            $enCoursCount = $interventions->whereIn('status', ['acceptée', 'en cours'])->count();
            $termineesCount = $interventions->where('status', 'terminee')->count();
            $totalCount = $interventions->count();

            $stats = [
                'En cours' => [
                    'value' => $enCoursCount,
                    'delta' => '↗ 2 nouvelles aujourd\'hui',
                    'color' => '#10b981',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
                    'bg' => '#f0fdf4'
                ],
                'Terminées' => [
                    'value' => $termineesCount,
                    'delta' => '↗ 85% ce mois',
                    'color' => '#3b82f6',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
                    'bg' => '#eff6ff'
                ],
                'Urgentes' => [
                    'value' => $interventions->where('priority', 'haute')->where('status', '!=', 'terminee')->count(),
                    'delta' => 'À traiter rapidement',
                    'color' => '#f59e0b',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
                    'bg' => '#fffbeb'
                ],
                'Note moyenne' => [
                    'value' => number_format($averageRating, 1) . '/5',
                    'delta' => '⭐ Excellente !',
                    'color' => '#8b5cf6',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
                    'bg' => '#f5f3ff'
                ]
            ];

            $donutData = [
                'labels' => ['En attente', 'En cours', 'Résolues'],
                'data' => [$enAttenteCount, $enCoursCount, $termineesCount],
                'colors' => ['#f59e0b', '#3b82f6', '#10b981'],
                'total' => $totalCount
            ];

            $performance = [
                'resolved' => $termineesCount,
                'success_rate' => $totalCount > 0 ? round(($termineesCount / $totalCount) * 100) : 0,
                'avg_time' => '12h 30m',
                'rating' => number_format($averageRating, 1) . '/5'
            ];

            $recentInterventions = $interventions->where('status', 'terminee')->take(4);
            $missionsDuJour = $interventions->where('status', '!=', 'terminee')->take(4);

            $notifications = $user->notifications()->latest()->take(3)->get();

            return view('technician.dashboard', compact('interventions', 'stats', 'notifications', 'donutData', 'performance', 'recentInterventions', 'missionsDuJour'));
        }

        // Simulated Smart City Data
        $smartData = [
            'air_quality' => 84, // %
            'parking_availability' => 156, // spaces
            'energy_savings' => 32, // %
            'active_sensors' => 452,
        ];

        return view('dashboard', compact('reports', 'stats', 'smartData'));
    }


}
