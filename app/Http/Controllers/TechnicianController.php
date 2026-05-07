<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Intervention;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:en cours,terminee',
            'after_image' => 'nullable|image|max:2048',
            'comment' => 'nullable|string',
        ]);

        $report->status = $request->status;
        
        if ($request->hasFile('after_image')) {
            $report->after_image = $request->file('after_image')->store('reports', 'public');
        }
        
        $report->save();

        // Update intervention status if needed
        $intervention = $report->interventions()->where('technician_id', Auth::id())->first();
        if ($intervention) {
            $intervention->status = $request->status;
            $intervention->save();
        }

        // Add automatic comment
        Comment::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
            'content' => $request->comment ?? "Le technicien a mis à jour le statut vers : " . $request->status,
        ]);

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
                'content' => "Le technicien a accepté la mission et se rend sur place.",
            ]);
        }

        return back()->with('success', 'Mission acceptée !');
    }
}
