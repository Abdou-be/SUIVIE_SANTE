<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MindFlow - Mental Health Tracker')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50 text-slate-700 min-h-screen">
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-600">
                    🌿 MindFlow
                </a>
                <div class="hidden md:flex gap-6">
                    <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-blue-600 transition">Dashboard</a>
                    <a href="{{ route('mood.create') }}" class="text-slate-600 hover:text-blue-600 transition">Mood Check</a>
                    <a href="{{ route('journal.index') }}" class="text-slate-600 hover:text-blue-600 transition">Journal</a>
                    <a href="{{ route('statistics.index') }}" class="text-slate-600 hover:text-blue-600 transition">Stats</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500">{{ auth()->user()->name ?? 'Student' }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-slate-600 hover:text-red-600 transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700">
                ✓ {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white py-8 text-center text-slate-500 text-sm">
        <p>MindFlow © {{ date('Y') }} - Your mental health, our priority</p>
    </footer>
</body>
</html>
