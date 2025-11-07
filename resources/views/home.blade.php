@extends('layouts.app')

@section('title', 'ITS MentorMatch - Connect with Expert Mentors')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <!-- Hero Section -->
    <section class="py-20 animate-fade-in">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-6xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-6">
                Find Your Perfect Mentor
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Connect with experienced professionals and accelerate your learning journey in technology and beyond.
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-12">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <div class="flex items-center bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-white/20 overflow-hidden">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search mentors by name, expertise, or specialization..." 
                            class="flex-1 px-6 py-4 bg-transparent border-none outline-none text-gray-700 placeholder-gray-500"
                        >
                        <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-4 font-semibold transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>

            @if(request('search'))
            <div class="mb-1">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Search Results for "{{ request('search') }}"</h2>
                <a href="{{ route('home') }}" class="text-teal-600 hover:text-teal-700 font-semibold">
                    <i class="fas fa-times mr-1"></i>Clear Search
                </a>
            </div>
            @endif
            </div>
            </section>
            
            <!-- Top 5 Mentors -->
            @if(!request('search') && isset($topMentors) && count($topMentors) > 0)
            <section class="py-8">
                <div class="container mx-auto px-4">
                    <h2 class="text-5xl font-bold text-center bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent mb-10">
                        Top 5 Mentors This Week
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($topMentors as $index => $mentor)
                        <div class="relative bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 border border-blue-100 hover:shadow-xl transform hover:scale-105 transition h-full flex flex-col justify-between">

                            <!-- Rank Badge -->
                            <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-md">
                                #{{ $index + 1 }}
                            </div>

                            <div class="flex-grow">
                                <div class="flex items-center space-x-4 mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-lg font-bold">
                                        {{ substr($mentor->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $mentor->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $mentor->expertise }}</p>
                                    </div>
                                </div>

                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $mentor->bio }}</p>

                                <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                    <span><i class="fas fa-star text-blue-500"></i> {{ number_format($mentor->rating, 2) }}</span>
                                    <span><i class="fas fa-users"></i> {{ $mentor->total_sessions }} sessions</span>
                                </div>

                                @php
                                    $skills = json_decode($mentor->skills, true);
                                    $maxSkills = 3;
                                @endphp

                                @if(is_array($skills) && count($skills) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($skills, 0, $maxSkills) as $skill)
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium border border-blue-200">
                                                {{ $skill }}
                                            </span>
                                        @endforeach

                                        @if(count($skills) > $maxSkills)
                                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-medium border border-gray-300">
                                                +{{ count($skills) - $maxSkills }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('mentors.show', $mentor->id) }}" class="block mt-5 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                                View Profile
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

    <!-- Featured Mentors -->
    <section class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-5xl font-bold text-center bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-12">
                {{ request('search') ? 'Search Results' : 'Featured Mentors' }}
            </h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredMentors as $mentor)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 border border-white/20 hover:shadow-xl">
                    <div class="h-3 bg-teal-500 "></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ substr($mentor->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">{{ $mentor->name }}</h3>
                                <p class="text-gray-600">{{ $mentor->expertise }}</p>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ $mentor->bio }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $mentor->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                    <span class="ml-2 text-gray-600 text-sm">({{ $mentor->rating }})</span>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                                {{ $mentor->total_sessions }} sessions
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(explode(',', $mentor->specializations) as $specialization)
                            <span class="bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium border border-blue-200">
                                {{ trim($specialization) }}
                            </span>
                            @endforeach
                        </div>
                        
                        <a href="{{ route('mentors.show', $mentor->id) }}" class="block w-full bg-teal-500  text-white text-center py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            View Profile
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">No mentors found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search terms or browse all mentors.</p>
                    <a href="{{ route('mentors.index') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                        Browse All Mentors
                    </a>
                </div>
                @endforelse
            </div>
            
            @if($featuredMentors->count() > 0 && !request('search'))
            <div class="text-center mt-12">
                <a href="{{ route('mentors.index') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-4 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    View All Mentors
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    @if(!request('search'))
    <section class="py-16 bg-white/50 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-12">Why Choose MentorMatch?</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center animate-scale-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Expert Mentors</h3>
                    <p class="text-gray-600">Connect with industry professionals who have real-world experience and expertise in their fields.</p>
                </div>
                
                <div class="text-center animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-video text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Flexible Sessions</h3>
                    <p class="text-gray-600">Choose from video calls, in-person meetings, or phone sessions that fit your schedule and preferences.</p>
                </div>
                
                <div class="text-center animate-scale-in" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-rocket text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Accelerate Growth</h3>
                    <p class="text-gray-600">Fast-track your learning and career development with personalized guidance and mentorship.</p>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection