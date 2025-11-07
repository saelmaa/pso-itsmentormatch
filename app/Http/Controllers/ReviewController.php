<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Session;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $sessionId = $request->get('session');
        
        if ($sessionId) {
            // Rating for specific session
            $session = Session::where('id', $sessionId)
                ->where('user_id', Auth::id())
                ->where('status', 'completed')
                ->firstOrFail();

            // Check if already reviewed
            if ($session->reviews()->where('user_id', Auth::id())->exists()) {
                return redirect()->route('sessions.index')
                    ->with('error', 'You have already reviewed this session.');
            }

            return view('reviews.create', compact('session'));
        } else {
            // General rating - show mentors that user has had sessions with
            $mentors = Mentor::whereHas('sessions', function ($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'completed');
            })->get();

            return view('reviews.create', compact('mentors'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'session_id' => 'nullable|exists:sessions,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // If session_id is provided, validate that user owns the session
        if ($request->session_id) {
            $session = Session::where('id', $request->session_id)
                ->where('user_id', Auth::id())
                ->where('status', 'completed')
                ->firstOrFail();

            // Check if already reviewed
            if ($session->reviews()->where('user_id', Auth::id())->exists()) {
                return redirect()->route('sessions.index')
                    ->with('error', 'You have already reviewed this session.');
            }
        }

        Review::create([
            'user_id' => Auth::id(),
            'mentor_id' => $request->mentor_id,
            'session_id' => $request->session_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('sessions.index')
            ->with('success', 'Thank you for your review!');
    }
}