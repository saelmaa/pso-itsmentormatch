@extends('layouts.app')

@section('title', 'About Us - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">About ITS MentorMatch</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Connecting ITS students with experienced mentors to accelerate learning, 
                career development, and personal growth through meaningful mentorship relationships.
            </p>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="w-20 h-20 bg-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bullseye text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To bridge the gap between students and industry professionals by providing 
                        a platform where ITS students can access personalized mentorship, guidance, 
                        and career advice from experienced alumni and senior students.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-eye text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Vision</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To become the leading mentorship platform for Indonesian tech students, 
                        fostering a community where knowledge sharing drives innovation and 
                        empowers the next generation of technology leaders.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose ITS MentorMatch?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're more than just a platform - we're your gateway to academic and career success
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Expert Mentors</h3>
                    <p class="text-gray-600">
                        Connect with experienced alumni, industry professionals, and senior students 
                        who understand your academic journey and career aspirations.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Flexible Scheduling</h3>
                    <p class="text-gray-600">
                        Book sessions that fit your schedule with options for video calls, 
                        in-person meetings, or phone consultations based on your preferences.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Track Progress</h3>
                    <p class="text-gray-600">
                        Monitor your learning journey, set goals, and track your progress 
                        with our comprehensive session management system.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Quality Assurance</h3>
                    <p class="text-gray-600">
                        Rate and review your mentors to help maintain high-quality mentorship 
                        and assist other students in finding the right guidance.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Community Driven</h3>
                    <p class="text-gray-600">
                        Join a vibrant community of ITS students and mentors working together 
                        to achieve academic excellence and career success.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Safe & Secure</h3>
                    <p class="text-gray-600">
                        Your privacy and security are our top priorities. All mentors are 
                        verified ITS community members with proven expertise.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Impact</h2>
                <p class="text-xl text-gray-600">Making a difference in the ITS community</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-teal-500 mb-2">100+</div>
                    <div class="text-gray-600 font-semibold">Students Helped</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-500 mb-2">30+</div>
                    <div class="text-gray-600 font-semibold">Expert Mentors</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-500 mb-2">500+</div>
                    <div class="text-gray-600 font-semibold">Sessions Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-500 mb-2">4.8/5</div>
                    <div class="text-gray-600 font-semibold">Average Rating</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-16 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Start Your Journey?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of ITS students who have already benefited from our mentorship platform.
            </p>
            <div class="flex justify-center gap-4 flex-wrap">
                @auth
                    <a href="{{ route('mentors.index') }}" class="bg-white text-teal-500 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-colors">
                        Find a Mentor
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-teal-500 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-colors">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-teal-500 transition-colors">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection