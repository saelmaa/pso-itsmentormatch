<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ITS MentorMatch')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-800 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center font-bold text-white shadow-lg">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        ITS MentorMatch
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('home') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('about') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        About Us
                    </a>
                    <a href="{{ route('mentors.index') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('mentors.index') || request()->routeIs('mentors.show') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        Mentors
                    </a>
                    <a href="{{ route('mentors.create') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('mentors.create') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        Become a Mentor
                    </a>
                    @auth
                    <a href="{{ route('sessions.index') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('sessions.*') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        My Sessions
                    </a>
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        Dashboard
                    </a>
                    @endauth
                    <a href="{{ route('guidelines') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('guidelines') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        Guidelines
                    </a>
                    {{-- 🔹 New: FAQ link in navbar --}}
                    <a href="{{ route('faq') }}" class="text-white hover:text-teal-600 font-semibold transition-colors {{ request()->routeIs('faq') ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                        FAQ
                    </a>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-teal-600 font-semibold transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                        Register
                    </a>
                    @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-white text-sm mt-1"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 bg-white rounded-lg shadow-lg py-2 w-48 z-50">
                            <a href="{{ route('settings.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-4 text-center animate-fade-in">
        <div class="container mx-auto">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white p-4 text-center animate-fade-in">
        <div class="container mx-auto">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <span class="text-xl font-bold">ITS MentorMatch</span>
                    </div>
                    <p class="text-gray-400">Connecting ITS students with experienced mentors for academic and career success.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('mentors.index') }}" class="hover:text-white transition-colors">Find Mentors</a></li>
                        <li><a href="{{ route('guidelines') }}" class="hover:text-white transition-colors">Guidelines</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        {{-- 🔹 Make FAQ in footer link to the new FAQ route --}}
                        <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 ITS MentorMatch. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
