@extends('layouts.app')

@section('title', 'My Progress')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">My Learning Journey</h1>
        <p class="text-xl text-gray-600">Track your mentorship sessions, monitor progress towards your goals, and celebrate your achievements.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-gradient-to-br from-teal-400 to-cyan-500 text-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-calendar-alt text-3xl mb-2"></i>
            <h2 class="text-3xl font-bold">{{ $totalSessions }}</h2>
            <p class="text-white/90">Total Sessions</p>
        </div>
        <div class="bg-gradient-to-br from-green-400 to-emerald-500 text-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-check-circle text-3xl mb-2"></i>
            <h2 class="text-3xl font-bold">{{ $completedSessions }}</h2>
            <p class="text-white/90">Completed Sessions</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white shadow-lg rounded-lg p-6 text-center">
            <i class="fas fa-star text-3xl mb-2"></i>
            <h2 class="text-3xl font-bold">{{ number_format($averageRating, 2) }}</h2>
            <p class="text-white/90">Average Rating</p>
        </div>
    </div>

    <!-- Session History now comes first -->
    <div class="bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg p-1 mb-10 shadow-lg">
        <div class="bg-white bg-opacity-90 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-indigo-800 mb-4"><i class="fas fa-history mr-2 text-indigo-600"></i> Session History</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-indigo-100">
                        <tr class="text-left text-gray-700">
                            <th class="py-2 px-4">Date</th>
                            <th class="py-2 px-4">Mentor</th>
                            <th class="py-2 px-4">Topic</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($sessionHistory as $session)
                            <tr class="border-b hover:bg-indigo-50">
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</td>
                                <td class="py-2 px-4">{{ $session->mentor->name ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $session->topic }}</td>
                                <td class="py-2 px-4">
                                    <span class="{{ $session->status == 'completed' ? 'text-green-600' : 'text-yellow-500' }} font-semibold">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 text-center">{{ $session->review->rating ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- My Goals (after) -->
    <div class="bg-gradient-to-br from-purple-400 to-fuchsia-500 rounded-lg p-1 mb-10 shadow-lg">
        <div class="bg-white bg-opacity-90 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-purple-800 mb-4"><i class="fas fa-bullseye mr-2 text-purple-600"></i> My Goals</h2>

            @if ($goals->isEmpty())
                <p class="text-gray-600 mb-4">You haven’t set any goals yet.</p>
            @else
                <div class="space-y-4 mb-6">
                    @foreach ($goals as $goal)
                        @php
                            $percent = min(100, $goal->target_sessions > 0 ? ($goal->sessions_completed / $goal->target_sessions) * 100 : 0);
                        @endphp
                        <div class="p-4 border rounded-lg bg-white shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-bold text-lg text-teal-800">{{ $goal->title }}</h3>
                                <span class="text-sm text-gray-500">
                                    {{ $goal->deadline ? \Carbon\Carbon::parse($goal->deadline)->format('d M Y') : 'No Deadline' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Mentor: <span class="font-medium">{{ $goal->mentor_name ?? '-' }}</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                                <div class="bg-gradient-to-r from-green-400 to-emerald-600 h-4 rounded-full text-xs text-white text-center transition-all duration-300" style="width: {{ $percent }}%">
                                    {{ round($percent) }}%
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Progress: <strong>{{ $goal->sessions_completed }}</strong> / {{ $goal->target_sessions }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('goals.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center bg-white p-4 rounded-md border border-gray-200 shadow-sm">
                @csrf
                <input type="text" name="title" placeholder="Goal Title (e.g. Learn Laravel)" required class="form-input border border-gray-300 rounded-md p-2 focus:ring-teal-500 focus:border-teal-500">
                <input type="text" name="mentor_name" placeholder="Mentor Name (optional)" class="form-input border border-gray-300 rounded-md p-2 focus:ring-teal-500 focus:border-teal-500">
                <input type="number" name="target_sessions" placeholder="Target Sessions" required class="form-input border border-gray-300 rounded-md p-2 focus:ring-teal-500 focus:border-teal-500">
                <input type="text" name="deadline" placeholder="dd/mm/yyyy" class="form-input border border-gray-300 rounded-md p-2 focus:ring-teal-500 focus:border-teal-500" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                <div class="col-span-1 md:col-span-4 flex justify-end">
                    <button type="submit" class="bg-gradient-to-br from-purple-400 to-fuchsia-500 text-white font-bold py-2 px-5 rounded shadow hover:opacity-90 transition-all duration-200">
                        <i class="fas fa-plus mr-1"></i> Set New Goal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
