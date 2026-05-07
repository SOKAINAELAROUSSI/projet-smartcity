<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('reports.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $report = new Report();
        $report->title = $request->title;
        $report->description = $request->description;
        $report->category_id = $request->category_id;
        $report->latitude = $request->latitude;
        $report->longitude = $request->longitude;
        $report->address = $request->address;
        $report->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $report->image = $request->file('image')->store('reports', 'public');
        }

        $report->save();

        return redirect()->route('dashboard')->with('success', 'Signalement envoyé avec succès !');
    }

    public function show(Report $report)
    {
        $report->load(['user', 'interventions.technician', 'comments.user', 'rating', 'category']);
        return view('reports.show', compact('report'));
    }

    public function rate(Request $request, Report $report)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $report->rating()->create([
            'technician_id' => $report->interventions->first()->technician_id,
            'score' => $request->score,
            'comment' => $request->comment,
        ]);

        // Update technician average rating
        $tech = User::find($report->interventions->first()->technician_id);
        if ($tech && $tech->technicianProfile) {
            $avg = Rating::where('technician_id', $tech->id)->avg('score');
            $tech->technicianProfile->update(['rating' => $avg]);
        }

        return back()->with('success', 'Merci pour votre évaluation !');
    }
}
