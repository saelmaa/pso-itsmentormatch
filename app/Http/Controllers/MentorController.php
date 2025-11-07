<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $department = $request->get('department');

        $mentors = Mentor::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('expertise', 'like', "%{$search}%");
        })
        ->when($department, function ($query) use ($department) {
            return $query->where('department', $department);
        })
        ->orderBy('rating', 'desc')
        ->orderBy('total_sessions', 'desc')
        ->paginate(12);

        return view('mentors.index', compact('mentors'));
    }

    public function show(Mentor $mentor)
    {
        return view('mentors.show', compact('mentor'));
    }

    public function create()
    {
        return view('mentors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|string',
            'expertise' => 'required|string',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'location' => 'nullable|string',
            'availability_status' => 'nullable|in:available,unavailable',
            'experience_years' => 'nullable|integer',
            'price' => 'nullable|string',
        ]);

        // Convert comma-separated skills to JSON array
        if ($request->filled('skills')) {
            $validated['skills'] = json_encode(array_map('trim', explode(',', $request->skills)));
        }

        Mentor::create($validated);

        return redirect()->route('mentors.index')->with('success', 'Mentor application submitted successfully!');
    }
}
