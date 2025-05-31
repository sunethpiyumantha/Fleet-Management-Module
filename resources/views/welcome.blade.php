@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-100 py-14 px-6">
    <div class="max-w-5xl mx-auto bg-white border-l-8 border-orange-400 shadow-2xl rounded-3xl p-12 text-center animate-fade-in relative overflow-hidden">

        <!-- Decorative circles -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-orange-100 rounded-full z-0 blur-2xl opacity-50"></div>
        <div class="absolute -bottom-10 -right-10 w-52 h-52 bg-orange-200 rounded-full z-0 blur-3xl opacity-30"></div>

        <div class="relative z-10">
            <h1 class="text-5xl font-extrabold text-orange-600 mb-6 drop-shadow-sm">
                Welcome to <span class="text-gray-900">Fleet Management System</span>
            </h1>
            <div class="text-sm text-gray-500 border-t pt-4">
                <p>&copy; {{ date('Y') }} <span class="text-orange-500 font-semibold">Fleet Management System</span>. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

@endsection
