@extends('layouts.app')

@section('title', 'Rate Mentor - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">Rate Your Mentor</h1>
                <p class="text-xl text-gray-600">Share your experience and help other students</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-6 bg-teal-500"></div>
                <div class="p-8">
                    @if(isset($session))
                    <!-- Session Info -->
                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-200">
                    <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 rounded-full flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg">
                        {{ strtoupper(substr($session->mentor->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-1">{{ $session->mentor->name }}</h2>
                        <p class="text-gray-600 text-lg mb-1">{{ $session->topic }}</p>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($session->session_time)->format('H:i') }}</p>
                    </div>
                </div>

                    <!-- Rating Form -->
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                        <input type="hidden" name="mentor_id" value="{{ $session->mentor->id }}">
                    @else
                    <!-- Mentor Selection -->
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <div class="mb-8">
                            <label for="mentor_id" class="block text-sm font-bold text-gray-700 mb-2">Select Mentor</label>
                            <select id="mentor_id" name="mentor_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="">Choose a mentor to rate...</option>
                                @foreach($mentors as $mentor)
                                <option value="{{ $mentor->id }}">{{ $mentor->name }} - {{ $mentor->expertise }}</option>
                                @endforeach
                            </select>
                            @error('mentor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                        <!-- Rating -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-4">Rating</label>
                            <div class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only rating-input" required>
                                    <i class="fas fa-star text-3xl text-gray-300 hover:text-amber-400 transition-colors rating-star" data-rating="{{ $i }}"></i>
                                </label>
                                @endfor
                            </div>
                            @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Feedback -->
                        <div class="mb-8">
                            <label for="feedback" class="block text-sm font-bold text-gray-700 mb-2">Feedback</label>
                            <textarea id="feedback" name="feedback" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Share your experience with this mentor..."></textarea>
                            @error('feedback')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('sessions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const inputs = document.querySelectorAll('.rating-input');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            
            // Update radio input
            inputs[index].checked = true;
            
            // Update star colors
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-amber-400');
                } else {
                    s.classList.remove('text-amber-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('text-amber-400');
                } else {
                    s.classList.remove('text-amber-400');
                }
            });
        });
    });
    
    document.querySelector('form').addEventListener('mouseleave', function() {
        const checkedInput = document.querySelector('.rating-input:checked');
        if (checkedInput) {
            const rating = parseInt(checkedInput.value);
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('text-amber-400');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.add('text-gray-300');
                    s.classList.remove('text-amber-400');
                }
            });
        }
    });
});
</script>
@endsection