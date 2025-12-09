@extends('layouts.app')

@section('title', 'Suggestions for You - MindFlow')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200 mb-6">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">
            Suggestions for you
            <span class="text-4xl">{{ ['😢', '😕', '😐', '🙂', '😄'][$mood->mood_level - 1] }}</span>
        </h1>
        <p class="text-slate-600">Based on your mood, here are some helpful suggestions:</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($suggestions as $suggestion)
            <div class="bg-gradient-to-br {{ $suggestion['gradient'] }} rounded-2xl p-6 shadow-sm border {{ $suggestion['border'] }}">
                <div class="text-3xl mb-3">{{ $suggestion['icon'] }}</div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $suggestion['title'] }}</h3>
                <p class="text-slate-700 text-sm">{{ $suggestion['description'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition">
            Back to Dashboard
        </a>
    </div>
</div>
@endsection
