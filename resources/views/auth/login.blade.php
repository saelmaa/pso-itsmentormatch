@extends('layouts.app')

@section('title', 'Login - ITS MentorMatch')

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
                <!-- Welcome text -->
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h1>
                <p class="text-gray-600">Sign in to your ITS MentorMatch account</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-4 bg-teal-500"></div>
                <div class="p-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
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
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                placeholder="Enter your password"
                            >
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <a href="#" class="text-sm text-teal-600 hover:text-teal-500">Forgot password?</a>
                        </div>

                        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 rounded-lg font-bold text-lg transition-colors">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-500 font-semibold">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection