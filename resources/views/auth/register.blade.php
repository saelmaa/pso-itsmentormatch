@extends('layouts.app')

@section('title', 'Register - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <!-- Logo & Title -->
                <div class="flex justify-center items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center font-bold text-white shadow-lg">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        ITS MentorMatch
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Join ITS MentorMatch</h1>
                <p class="text-gray-600">Create your account to get started</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-4 bg-teal-500"></div>
                <div class="p-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Your full name"
                            >
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="your.email@its.ac.id"
                            >
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="student_id" class="block text-sm font-bold text-gray-700 mb-2">Student ID</label>
                            <input 
                                type="text" 
                                id="student_id" 
                                name="student_id" 
                                value="{{ old('student_id') }}" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="e.g., 05111940000001"
                            >
                            @error('student_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="department" class="block text-sm font-bold text-gray-700 mb-2">Department</label>
                            <select 
                                id="department" 
                                name="department" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                            >
                                <option value="">Select your department</option>
                                <option value="Information System" {{ old('department') == 'Information System' ? 'selected' : '' }}>Information System</option>
                                <option value="Informatics" {{ old('department') == 'Informatics' ? 'selected' : '' }}>Informatics</option>
                                <option value="Visual Communication Design" {{ old('department') == 'Visual Communication Design' ? 'selected' : '' }}>Visual Communication Design</option>
                                <option value="Electrical Engineering" {{ old('department') == 'Electrical Engineering' ? 'selected' : '' }}>Electrical Engineering</option>
                                <option value="Mechanical Engineering" {{ old('department') == 'Mechanical Engineering' ? 'selected' : '' }}>Mechanical Engineering</option>
                                <option value="Civil Engineering" {{ old('department') == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                                <option value="Other" {{ old('department') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('department')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number (Optional)</label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="e.g., +62 812 3456 7890"
                            >
                            @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Create a secure password"
                            >
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Confirm your password"
                            >
                        </div>

                        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 rounded-lg font-bold text-lg transition-colors">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-500 font-semibold">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection