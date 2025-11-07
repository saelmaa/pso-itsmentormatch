<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use Carbon\Carbon;

class GoalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'mentor_name' => 'nullable|string|max:255',
            'target_sessions' => 'required|integer|min:1',
            'deadline' => 'nullable|string',
        ]);

        $deadline = null;

        if (!empty($validated['deadline'])) {
            try {
                $deadline = Carbon::parse($validated['deadline'])->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withErrors(['deadline' => 'Invalid date format']);
            }
        }

        Goal::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'mentor_name' => $validated['mentor_name'],
            'target_sessions' => $validated['target_sessions'],
            'deadline' => $deadline,
            'sessions_completed' => Auth::user()->sessions()->where('status', 'completed')->count(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Goal created successfully!');
    }
}

