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

        return back()->with('success', 'Technicien affecté avec succès.');
    }
}
