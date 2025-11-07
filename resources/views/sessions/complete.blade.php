@extends('layouts.app')

@section('title', 'Complete Session - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">Complete Session</h1>
                <p class="text-xl text-gray-600">Mark your session as completed and share your experience</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-6 bg-teal-500"></div>
                <div class="p-8">
                    <!-- Session Details -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700  rounded-full flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($session->mentor->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $session->topic }}</h2>
                                <p class="text-lg text-gray-600 mb-2">with {{ $session->mentor->name }}</p>
                                <p class="text-sm text-gray-500 mb-2">{{ $session->mentor->expertise }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ \Carbon\Carbon::parse($session->session_time)->format('H:i') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-hourglass-half mr-2"></i>
                                        {{ $session->duration }} minutes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Completion Form -->
                    <form method="POST" action="{{ route('sessions.complete', $session->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-8">
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-4">Session Notes (Optional)</label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="6" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                                placeholder="Add any notes about your session, key takeaways, or things to remember..."
                            >{{ old('notes', $session->notes) }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 rounded-lg p-6 mb-8">
                            <h3 class="font-bold text-blue-900 mb-3">What happens after completion?</h3>
                            <ul class="text-blue-800 space-y-2 text-sm">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-blue-600 mr-3"></i>
                                    Your session will be marked as completed
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-star text-blue-600 mr-3"></i>
                                    You'll be able to rate and review your mentor
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                                    This session will count towards your learning progress
                                </li>
                            </ul>
                        </div>

                        <div class="flex justify-between space-x-4">
                            <a href="{{ route('sessions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Back to Sessions
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 hover:bg-teal-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Mark as Completed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
