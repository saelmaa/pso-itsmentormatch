<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mentor;
use App\Models\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get search term from request
        $search = $request->get('search');

        // Top 5 mentors based on actual avg rating & total sessions
        $topMentors = DB::table('mentors')
        ->select('id', 'name', 'expertise', 'bio', 'skills', 'rating', 'total_sessions')
        ->orderByDesc('rating')
        ->orderByDesc('total_sessions')
        ->limit(5)
        ->get();

        // Featured Mentors - default or search result
        $featuredMentors = Mentor::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%")
                             ->orWhere('expertise', 'like', "%$search%")
                             ->orWhere('department', 'like', "%$search%");
            })
            // ->orderBy('rating', 'desc')
            // ->orderBy('total_sessions', 'desc')
            ->limit(6)
            ->get();

        // Statistics
        $totalMentors = Mentor::count();
        $totalSessions = Session::count();

        // Return to view
        return view('home', compact(
            'featuredMentors',
            'topMentors',
            'totalMentors',
            'totalSessions'
        ));
    }
}
