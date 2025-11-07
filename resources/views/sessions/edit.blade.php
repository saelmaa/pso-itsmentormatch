@extends('layouts.app')

@section('title', 'Edit Session - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">Edit Session</h1>
                <p class="text-xl text-gray-600">Update your session with {{ $session->mentor->name }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-6 bg-teal-500"></div>
                <div class="p-8">
                    <form method="POST" action="{{ route('sessions.update', $session->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label for="topic" class="block text-sm font-bold text-gray-700 mb-2">Session Topic</label>
                                <input type="text" id="topic" name="topic" value="{{ old('topic', $session->topic) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                @error('topic')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Session Type</label>
                                <select id="type" name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="video_call" {{ old('type', $session->type) == 'video_call' ? 'selected' : '' }}>Video Call</option>
                                    <option value="in_person" {{ old('type', $session->type) == 'in_person' ? 'selected' : '' }}>In Person</option>
                                    <option value="phone" {{ old('type', $session->type) == 'phone' ? 'selected' : '' }}>Phone Call</option>
                                </select>
                                @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="session_date" class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                                <input type="date" id="session_date" name="session_date" value="{{ old('session_date', $session->session_date) }}" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                @error('session_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="session_time" class="block text-sm font-bold text-gray-700 mb-2">Time</label>
                                <input type="time" id="session_time" name="session_time" value="{{ old('session_time', $session->session_time) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                @error('session_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Duration (minutes)</label>
                                <select id="duration" name="duration" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="30" {{ old('duration', $session->duration) == 30 ? 'selected' : '' }}>30 minutes</option>
                                    <option value="60" {{ old('duration', $session->duration) == 60 ? 'selected' : '' }}>60 minutes</option>
                                    <option value="90" {{ old('duration', $session->duration) == 90 ? 'selected' : '' }}>90 minutes</option>
                                    <option value="120" {{ old('duration', $session->duration) == 120 ? 'selected' : '' }}>120 minutes</option>
                                </select>
                                @error('duration')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('description', $session->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4 mt-8">
                            <a href="{{ route('sessions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Update Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection