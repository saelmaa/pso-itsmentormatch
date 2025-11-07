@extends('layouts.app')

@section('title', 'My Sessions - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent bg-clip-text text-transparent mb-4">My Sessions</h1>
            <p class="text-xl text-gray-600">Manage your mentoring sessions</p>
        </div>

        <div class="grid gap-8">
            @forelse($sessions as $session)
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-white/20">
                <div class="h-4 bg-teal-500
                    {{ $session->status == 'completed' ? 'from-emerald-400 to-teal-500' : 
                       ($session->status == 'pending' ? 'from-amber-400 to-orange-500' : 
                        'from-rose-400 to-pink-500') }}">
                </div>
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row items-start justify-between space-y-6 lg:space-y-0">
                        <div class="flex items-start space-x-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ substr($session->mentor->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">{{ $session->topic }}</h3>
                                <p class="text-lg text-gray-600 mb-2">with <strong>{{ $session->mentor->name }}</strong></p>
                                <p class="text-gray-600 mb-4">{{ $session->description }}</p>
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <span class="flex items-center text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }}
                                    </span>
                                    <span class="flex items-center text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ \Carbon\Carbon::parse($session->session_time)->format('H:i') }}
                                    </span>
                                    <span class="flex items-center text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                        <i class="fas fa-hourglass-half mr-2"></i>
                                        {{ $session->duration }} minutes
                                    </span>
                                    <span class="flex items-center text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                        <i class="fas fa-video mr-2"></i>
                                        {{ ucfirst(str_replace('_', ' ', $session->type)) }}
                                    </span>
                                </div>
                                @if($session->notes)
                                <div class="mt-3 p-3 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-100">
                                    <p class="text-sm text-gray-600"><strong>Notes:</strong> {{ $session->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3 min-w-[120px]">
                            <span class="px-4 py-2 rounded-full text-sm font-bold text-center text-white
                                {{ $session->status == 'completed' ? 'bg-teal-500' : 
                                   ($session->status == 'pending' ? 'bg-yellow-400' : 
                                    'bg-gradient-to-r from-rose-400 to-pink-500') }}">
                                {{ ucfirst($session->status) }}
                            </span>
                            
                            <div class="flex flex-col space-y-2">
                                @if($session->status !== 'completed')
                                <a href="{{ route('sessions.edit', $session->id) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    Edit
                                </a>
                                
                                <a href="{{ route('sessions.show-complete', $session->id) }}" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    Complete
                                </a>
                                
                                <form method="POST" action="{{ route('sessions.destroy', $session->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105" onclick="return confirm('Are you sure you want to delete this session?')">
                                        Delete
                                    </button>
                                </form>
                                @endif
                                
                                @if($session->status == 'completed' && !$session->reviews()->where('user_id', auth()->id())->exists())
                                <a href="{{ route('reviews.create', ['session' => $session->id]) }}" class="bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    Rate Mentor
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-12 text-center border border-white/20">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-600 to-gray-800 bg-clip-text text-transparent mb-4">No sessions yet</h3>
                <p class="text-gray-500 text-lg mb-6">Book your first mentoring session to get started.</p>
                <a href="{{ route('mentors.index') }}" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    Find a Mentor
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages())
        <div class="mt-12">
            {{ $sessions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection