<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::forUser(Auth::id())
            ->with('mentor')
            ->orderBy('session_date', 'desc')
            ->orderBy('session_time', 'desc')
            ->paginate(10);

        return view('sessions.index', compact('sessions'));
    }

    public function create(Request $request)
    {
        $mentorId = $request->get('mentor');
        $mentor = Mentor::findOrFail($mentorId);

        return view('sessions.create', compact('mentor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'duration' => 'required|integer|min:30|max:180',
            'type' => 'required|in:video_call,in_person,phone',
        ]);

        Session::create([
            'user_id' => Auth::id(),
            'mentor_id' => $request->mentor_id,
            'topic' => $request->topic,
            'description' => $request->description,
            'session_date' => $request->session_date,
            'session_time' => $request->session_time,
            'duration' => $request->duration,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        return redirect()->route('sessions.index')
            ->with('success', 'Session booked successfully!');
    }

    public function edit(Session $session)
    {
        // Check if user owns the session
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if session can be edited
        if (!$session->canBeEdited()) {
            return redirect()->route('sessions.index')
                ->with('error', 'This session cannot be edited.');
        }

        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        // Check if user owns the session
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if session can be edited
        if (!$session->canBeEdited()) {
            return redirect()->route('sessions.index')
                ->with('error', 'This session cannot be edited.');
        }

        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'duration' => 'required|integer|min:30|max:180',
            'type' => 'required|in:video_call,in_person,phone',
        ]);

        $session->update([
            'topic' => $request->topic,
            'description' => $request->description,
            'session_date' => $request->session_date,
            'session_time' => $request->session_time,
            'duration' => $request->duration,
            'type' => $request->type,
        ]);

        return redirect()->route('sessions.index')
            ->with('success', 'Session updated successfully!');
    }

    public function destroy(Session $session)
    {
        // Check if user owns the session
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        $session->delete();

        return redirect()->route('sessions.index')
            ->with('success', 'Session deleted successfully.');
    }

    public function showComplete(Session $session)
    {
        // Check if user owns the session
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if session can be completed
        if ($session->status === 'completed') {
            return redirect()->route('sessions.index')
                ->with('error', 'This session is already completed.');
        }

        return view('sessions.complete', compact('session'));
    }

    public function complete(Request $request, Session $session)
    {
        // Check if user owns the session
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if session can be completed
        if ($session->status === 'completed') {
            return redirect()->route('sessions.index')
                ->with('error', 'This session is already completed.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $session->update([
            'status' => 'completed',
            'notes' => $request->notes,
        ]);

        // Update mentor's total sessions count
        $session->mentor->increment('total_sessions');

        return redirect()->route('reviews.create', ['session' => $session->id])
            ->with('success', 'Session completed! Please rate your mentor.');
    }
}
