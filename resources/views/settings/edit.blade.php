@extends('layouts.app')

@section('title', 'Settings - ITS MentorMatch')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 bg-clip-text text-transparent mb-8">Account Settings</h2>

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

           <div>
            <label class="block text-gray-700 font-semibold mb-1" for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1" for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1" for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1" for="department">Department</label>
                <input type="text" id="department" name="department" value="{{ old('department', $user->department) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1" for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1" for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1" for="new_password_confirmation">Confirm Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-teal-200 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white py-3 px-6 rounded font-bold">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
