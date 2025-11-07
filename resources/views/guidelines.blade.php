@extends('layouts.app')

@section('title', 'Guidelines - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-4">Mentoring Guidelines</h1>
                <p class="text-xl text-gray-600">Best practices for successful mentoring relationships</p>
            </div>

            <div class="space-y-8">
                <!-- For Students -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-6 bg-teal-500"></div>
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-user-graduate text-teal-500 mr-4"></i>
                            For Students
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Before the Session</h3>
                                <ul class="space-y-2 text-gray-600 ml-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Come prepared with specific questions and goals</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Research your mentor's background and expertise</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Set clear expectations for what you want to achieve</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Test your technology if it's a video call</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">During the Session</h3>
                                <ul class="space-y-2 text-gray-600 ml-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Be punctual and respectful of time</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Listen actively and take notes</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Ask follow-up questions for clarity</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Be open to feedback and constructive criticism</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">After the Session</h3>
                                <ul class="space-y-2 text-gray-600 ml-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Follow up with a thank you message</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Implement the advice and feedback received</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Provide honest feedback about your experience</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-teal-500 mr-3 mt-1"></i>
                                        <span>Schedule follow-up sessions if needed</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- For Mentors -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-6 bg-purple-500"></div>
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-chalkboard-teacher text-purple-500 mr-4"></i>
                            For Mentors
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Preparation</h3>
                                <ul class="space-y-2 text-gray-600 ml-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Review the student's background and session topic</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Prepare relevant examples and resources</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Set aside uninterrupted time for the session</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">During Sessions</h3>
                                <ul class="space-y-2 text-gray-600 ml-6">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Create a welcoming and supportive environment</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Share experiences and practical insights</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Encourage questions and active participation</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-500 mr-3 mt-1"></i>
                                        <span>Provide constructive and actionable feedback</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Guidelines -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-6 bg-emerald-500"></div>
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-handshake text-emerald-500 mr-4"></i>
                            General Guidelines
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Communication</h3>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Maintain professional and respectful communication</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Respond to messages in a timely manner</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Be clear about availability and boundaries</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Scheduling</h3>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Confirm sessions 24 hours in advance</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Provide adequate notice for cancellations</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 mr-3 mt-1"></i>
                                        <span>Reschedule if necessary rather than canceling</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-8 p-6 bg-amber-50 rounded-xl border-l-4 border-amber-400">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-amber-500 mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-amber-800 mb-2">Important Reminder</h4>
                                    <p class="text-amber-700">
                                        All mentoring sessions are free of charge. Any mentor requesting payment should be reported immediately. 
                                        This platform is designed to support the ITS community through knowledge sharing and collaboration.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code of Conduct -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-6 bg-rose-500"></div>
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-shield-alt text-rose-500 mr-4"></i>
                            Code of Conduct
                        </h2>
                        
                        <div class="space-y-4 text-gray-600">
                            <p class="flex items-start">
                                <i class="fas fa-circle text-rose-500 mr-3 mt-2 text-xs"></i>
                                <span>Respect diversity and maintain inclusive behavior</span>
                            </p>
                            <p class="flex items-start">
                                <i class="fas fa-circle text-rose-500 mr-3 mt-2 text-xs"></i>
                                <span>Maintain confidentiality of personal information shared during sessions</span>
                            </p>
                            <p class="flex items-start">
                                <i class="fas fa-circle text-rose-500 mr-3 mt-2 text-xs"></i>
                                <span>Avoid any form of harassment, discrimination, or inappropriate behavior</span>
                            </p>
                            <p class="flex items-start">
                                <i class="fas fa-circle text-rose-500 mr-3 mt-2 text-xs"></i>
                                <span>Report any violations to the platform administrators</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection