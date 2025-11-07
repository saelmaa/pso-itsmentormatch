<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Session;
use App\Models\Review;
use App\Models\Goal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua session user + mentor + review (biar rating bisa langsung diakses)
        $sessions = $user->sessions()
        ->with(['mentor', 'review'])
        ->orderBy('session_date', 'desc')
        ->get();


        $completedSessions = $sessions->where('status', 'completed');
        $averageRating = $user->reviews()->avg('rating');

        // Ambil semua goals milik user
        $goals = Goal::where('user_id', $user->id)->get();

        // Loop goals untuk hitung sessions_completed berdasarkan match topic
        foreach ($goals as $goal) {
            $matchingSessions = $completedSessions->filter(function ($session) use ($goal) {
                return strtolower(trim($session->topic)) === strtolower(trim($goal->title));
            });

            $goal->sessions_completed = $matchingSessions->count();
        }

        return view('dashboard', [
            'totalSessions' => $sessions->count(),
            'completedSessions' => $completedSessions->count(),
            'averageRating' => $averageRating ?? 0,
            'sessionHistory' => $sessions,
            'goals' => $goals,
        ]);
    }
}
