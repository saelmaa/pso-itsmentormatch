@extends('layouts.app')

@section('title', 'Mentors - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-6">Discover Your Perfect Mentor</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Connect with experienced ITS senior students and alumni who can guide you in your academic and career journey.
            </p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <form method="GET" action="{{ route('mentors.index') }}" class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-teal-400"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search mentors by name or expertise..."
                        value="{{ request('search') }}"
                        class="w-full pl-14 pr-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 outline-none text-lg"
                    />
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-filter text-purple-500"></i>
                    <select
                        name="department"
                        class="px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-500 outline-none text-lg font-semibold"
                    >
                        <option value="">All Departments</option>
                        <option value="Information System" {{ request('department') == 'Information System' ? 'selected' : '' }}>Information System</option>
                        <option value="Informatics" {{ request('department') == 'Informatics' ? 'selected' : '' }}>Informatics</option>
                        <option value="Visual Communication Design" {{ request('department') == 'Visual Communication Design' ? 'selected' : '' }}>Visual Communication Design</option>
                        <option value="Electrical Engineering" {{ request('department') == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                        <option value="Mechanical Engineering" {{ request('department') == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                        <option value="Civil Engineering" {{ request('department') == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                    </select>
                </div>
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                    Search
                </button>
            </form>
        </div>

        <!-- Mentors Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($mentors as $mentor)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-6 bg-teal-500"></div>
                <div class="p-8">
                    <!-- Mentor Header -->
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ substr($mentor->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $mentor->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3 font-medium">{{ $mentor->expertise }}</p>
                            <span class="inline-block bg-teal-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                {{ $mentor->department }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center space-x-2 bg-amber-50 p-3 rounded-xl">
                            <i class="fas fa-star text-amber-500"></i>
                            <span class="font-bold text-gray-800">{{ $mentor->rating }}</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-teal-50 p-3 rounded-xl">
                            <i class="fas fa-users text-teal-500"></i>
                            <span class="text-gray-700 text-sm font-semibold">{{ $mentor->total_sessions }}</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-emerald-50 p-3 rounded-xl">
                            <i class="fas fa-clock text-{{ $mentor->availability_status == 'available' ? 'emerald' : 'rose' }}-500"></i>
                            <span class="text-sm font-bold text-{{ $mentor->availability_status == 'available' ? 'emerald' : 'rose' }}-600">
                                {{ ucfirst($mentor->availability_status) }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2 bg-purple-50 p-3 rounded-xl">
                            <i class="fas fa-map-marker-alt text-purple-500"></i>
                            <span class="text-gray-700 text-sm font-semibold">{{ $mentor->location }}</span>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-8">
                        <h4 class="font-bold text-sm text-gray-700 mb-3">Skills</h4>
                        <div class="flex items-center gap-2 overflow-hidden whitespace-nowrap text-ellipsis">
                            @php
                                $skills = is_string($mentor->skills)
                                    ? json_decode($mentor->skills, true)
                                    : $mentor->skills;

                                $skills = is_array($skills) ? $skills : [];
                                $displaySkills = array_slice($skills, 0, 3);
                                $remainingSkills = array_slice($skills, 3);
                            @endphp

                            @foreach($displaySkills as $skill)
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $skill }}
                                </span>
                            @endforeach

                            @if(count($remainingSkills) > 0)
                                <span class="text-teal-600 text-xs font-bold bg-teal-50 px-3 py-1 rounded-full"
                                    title="{{ implode(', ', $remainingSkills) }}">
                                    +{{ count($remainingSkills) }} more
                                </span>
                            @endif

                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('mentors.show', $mentor->id) }}" class="block w-full bg-teal-500 hover:bg-teal-600 text-white py-4 rounded-xl font-bold text-center transition-colors">
                        View Profile
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16">
                <i class="fas fa-users text-gray-400 text-6xl mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-4">No mentors found</h3>
                <p class="text-gray-500 text-lg">Try adjusting your search criteria or filters.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $mentors->links() }}
        </div>
    </div>
</div>
@endsection
