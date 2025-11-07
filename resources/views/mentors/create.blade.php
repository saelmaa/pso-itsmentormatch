@extends('layouts.app')

@section('title', 'Become a Mentor - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <div class="text-center mb-8">
                <div class="flex justify-center items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center font-bold text-white shadow-lg">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        ITS MentorMatch
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Share Your Expertise</h1>
                <p class="text-gray-600">Fill out the form below to join as a mentor on ITS MentorMatch.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-4 bg-teal-500"></div>
                <div class="p-8">
                    <form method="POST" action="{{ route('mentors.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Department -->
                        <div class="mb-4">
                            <label for="department" class="block text-sm font-bold text-gray-700 mb-2">Department</label>
                            <input type="text" name="department" id="department" value="{{ old('department') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Expertise -->
                        <div class="mb-4">
                            <label for="expertise" class="block text-sm font-bold text-gray-700 mb-2">Expertise</label>
                            <textarea name="expertise" id="expertise" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                required>{{ old('expertise') }}</textarea>
                        </div>

                        <!-- Bio -->
                        <div class="mb-4">
                            <label for="bio" class="block text-sm font-bold text-gray-700 mb-2">Short Bio</label>
                            <textarea name="bio" id="bio" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('bio') }}</textarea>
                        </div>

                        <!-- Experience -->
                        <div class="mb-4">
                            <label for="experience_years" class="block text-sm font-bold text-gray-700 mb-2">Years of Experience</label>
                            <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', 0) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price (Free)</label>
                            <input type="text" name="price" id="price" value="{{ old('price', 'Free') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Skills -->
                        <div class="mb-6">
                            <label for="skills" class="block text-sm font-bold text-gray-700 mb-2">Skills (comma-separated)</label>
                            <input type="text" name="skills" id="skills" value="{{ old('skills') }}"
                                placeholder="e.g., Laravel, UI/UX, Public Speaking"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 rounded-lg font-bold text-lg transition-colors">
                            Submit Application
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-500">
                        Once submitted, your mentor profile will be instantly created.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
