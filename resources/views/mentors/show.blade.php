@extends('layouts.app')

@section('title', $mentor->name . ' - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Mentor Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="h-6 bg-teal-500"></div>
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-start space-y-6 md:space-y-0 md:space-x-8">
                    <div class="w-32 h-32 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                        {{ substr($mentor->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $mentor->name }}</h1>
                        <p class="text-xl text-gray-600 mb-4">{{ $mentor->expertise }}</p>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <span class="bg-teal-500 text-white px-4 py-2 rounded-full font-semibold">
                                {{ $mentor->department }}
                            </span>
                            <span class="bg-amber-100 text-amber-800 px-4 py-2 rounded-full font-semibold flex items-center">
                                <i class="fas fa-star mr-2"></i>
                                {{ $mentor->rating }} ({{ $mentor->total_reviews }} reviews)
                            </span>
                            <span class="bg-{{ $mentor->availability_status == 'available' ? 'emerald' : 'rose' }}-100 text-{{ $mentor->availability_status == 'available' ? 'emerald' : 'rose' }}-800 px-4 py-2 rounded-full font-semibold">
                                {{ ucfirst($mentor->availability_status) }}
                            </span>
                        </div>
                        @auth
                        <a href="{{ route('sessions.create', ['mentor' => $mentor->id]) }}" class="bg-teal-500 hover bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-5 py-2 rounded-xl font-bold text-lg transition-colors">
                            Book Session
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="bg-teal-500 hover bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-5 py-2 rounded-xl font-bold text-lg transition-colors">
                            Login to Book Session
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">About</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $mentor->bio }}</p>
                </div>

                <!-- Skills -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Skills & Expertise</h2>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $skills = is_string($mentor->skills)
                                ? json_decode($mentor->skills, true)
                                : $mentor->skills;
                            $skills = is_array($skills) ? $skills : [];
                        @endphp
                        @foreach($skills as $skill)
                        <span class="bg-teal-100 text-teal-800 px-4 py-2 rounded-full font-semibold">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h2>
                    @forelse($mentor->reviews()->with('user')->latest()->take(5)->get() as $review)
                    <div class="border-b border-gray-200 pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $review->user->name }}</h4>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $review->rating ? 'amber' : 'gray' }}-400 text-sm"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $review->feedback }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-8">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Sessions</span>
                            <span class="font-bold text-gray-800">{{ $mentor->total_sessions }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Experience</span>
                            <span class="font-bold text-gray-800">{{ $mentor->experience_years }} years</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Rating</span>
                            <span class="font-bold text-gray-800">{{ $mentor->rating }}/5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Location</span>
                            <span class="font-bold text-gray-800">{{ $mentor->location }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Price</span>
                            <span class="font-bold text-gray-800">{{ $mentor->price }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-teal-500"></i>
                            <span class="text-gray-600">{{ $mentor->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
