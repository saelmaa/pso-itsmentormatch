@extends('layouts.app')

@section('title', 'Book Session - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">Book a Session</h1>
                <p class="text-xl text-gray-600">Schedule your mentoring session with {{ $mentor->name }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-6 bg-teal-500"></div>
                <div class="p-8">

                    <!-- Mentor Info -->
                    <div class="flex items-center space-x-6 mb-8 pb-8 border-b border-gray-200">
                        <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($mentor->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $mentor->name }}</h2>
                            <p class="text-lg text-gray-600 mb-2">{{ $mentor->expertise }}</p>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $mentor->department }}
                            </span>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form method="POST" action="{{ route('sessions.store') }}">
                        @csrf
                        <input type="hidden" name="mentor_id" value="{{ $mentor->id }}">

                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label for="topic" class="block text-sm font-bold text-gray-700 mb-2">Session Topic</label>
                                <input type="text" id="topic" name="topic" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="e.g., Career Guidance, Technical Skills">
                                @error('topic')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Session Type</label>
                                <select id="type" name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="video_call">Video Call</option>
                                    <option value="in_person">In Person</option>
                                    <option value="phone">Phone Call</option>
                                </select>
                                @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="session_date" class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                                <input type="date" id="session_date" name="session_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                @error('session_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="session_time" class="block text-sm font-bold text-gray-700 mb-2">Time</label>
                                <input type="time" id="session_time" name="session_time" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                @error('session_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Duration (minutes)</label>
                                <select id="duration" name="duration" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="30">30 minutes</option>
                                    <option value="60" selected>60 minutes</option>
                                    <option value="90">90 minutes</option>
                                    <option value="120">120 minutes</option>
                                </select>
                                @error('duration')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Please describe what you'd like to discuss in this session..."></textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4 mt-8">
                            <a href="{{ route('mentors.show', $mentor->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Book Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection