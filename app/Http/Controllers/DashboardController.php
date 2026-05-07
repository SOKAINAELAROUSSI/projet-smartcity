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
            $reports = $query->with('user')->latest()->get();
            $stats = [
                'Total' => Report::count(),
                'Nouveaux' => Report::where('status', 'en attente')->count(),
                'Terminés' => Report::where('status', 'terminee')->count(),
                'Techniciens' => User::where('role', 'technician')->count(),
            ];
        } elseif ($user->role === 'technician') {
            $reports = $query->whereHas('interventions', function ($q) use ($user) {
                $q->where('technician_id', $user->id);
            })->latest()->get();
            
            $stats = [
                'Missions' => $reports->count(),
                'Actifs' => $reports->where('status', 'en cours')->count(),
                'Finis' => $reports->where('status', 'terminee')->count(),
            ];
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
