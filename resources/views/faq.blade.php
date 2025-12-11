@extends('layouts.app')

@section('title', 'FAQ - ITS MentorMatch')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto animate-fade-in">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Frequently Asked Questions
        </h1>
        <p class="text-gray-600 mb-8">
            Here we answer some common questions about how ITS MentorMatch works for mentees and mentors.
        </p>

        <div class="space-y-4">
            {{-- Item 1 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-900 mb-2">
                    1. What is ITS MentorMatch?
                </h2>
                <p class="text-gray-600 text-sm md:text-base">
                    ITS MentorMatch is a platform that connects ITS students with experienced mentors
                    to support academic goals, career planning, and personal development.
                </p>
            </div>

            {{-- Item 2 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-900 mb-2">
                    2. How do I book a mentoring session?
                </h2>
                <p class="text-gray-600">
                    You can browse available mentors on the
                    <a href="{{ route('mentors.index') }}"
                    class="text-teal-600 font-semibold hover:underline">
                        Mentors
                    </a>
                    page, open a mentor profile, and follow the steps to create a new session.
                    Make sure you are logged in first.
                </p>
            </div>

            {{-- Item 3 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-900 mb-2">
                    3. How can I become a mentor?
                </h2>
                <p class="text-gray-600 text-sm md:text-base">
                    If you meet the requirements, you can apply through the
                    <a href="{{ route('mentors.create') }}" class="text-teal-600 font-semibold hover:underline">
                        Become a Mentor
                    </a> page and fill out the registration form.
                </p>
            </div>

            {{-- Item 4 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-900 mb-2">
                    4. Where can I see my upcoming sessions?
                </h2>
                <p class="text-gray-600 text-sm md:text-base">
                    After logging in, you can open the
                    <a href="{{ route('sessions.index') }}" class="text-teal-600 font-semibold hover:underline">
                        My Sessions
                    </a>
                    page to see your upcoming and past mentoring sessions.
                </p>
            </div>

            {{-- Item 5 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-900 mb-2">
                    5. Who should I contact if I face issues?
                </h2>
                <p class="text-gray-600 text-sm md:text-base">
                    If you experience technical problems or have questions about the program,
                    please contact the ITS MentorMatch admin through the official channel provided by your department.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
