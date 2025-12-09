@extends('layouts.app')

@section('title', 'Dashboard - MindFlow')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Welcome Card -->
    <div class="md:col-span-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-blue-100">{{ now()->format('l, F j, Y') }}</p>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <p class="text-sm text-slate-500 mb-2">Today's Status</p>
        <p class="text-3xl font-bold text-emerald-600">
            @if ($todayMood)
                {{ ['😢', '😕', '😐', '🙂', '😄'][$todayMood->mood_level - 1] }}
            @else
                📝
            @endif
        </p>
        <p class="text-xs text-slate-500 mt-2">
            @if ($todayMood)
                Last updated: {{ $todayMood->created_at->format('g:i A') }}
            @else
                No entry yet
            @endif
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Today's Mood Section -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Today's Mood</h2>
        @if ($todayMood)
            <div class="mb-6">
                <p class="text-sm text-slate-600 mb-2">Your mood today:</p>
                <div class="flex items-center gap-4">
                    <span class="text-5xl">{{ ['😢', '😕', '😐', '🙂', '😄'][$todayMood->mood_level - 1] }}</span>
                    <div>
                        <p class="text-lg font-semibold text-slate-700">{{ ['Very Bad', 'Not Good', 'Average', 'Good', 'Very Good'][$todayMood->mood_level - 1] }}</p>
                        @if ($todayMood->note)
                            <p class="text-sm text-slate-600 mt-2">{{ Str::limit($todayMood->note, 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <a href="{{ route('mood.create') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Update Mood
            </a>
        @else
            <p class="text-slate-600 mb-6">You haven't logged your mood yet today. Take a moment to reflect!</p>
            <a href="{{ route('mood.create') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Log Mood Now
            </a>
        @endif
    </div>

    <!-- Daily Habits Checklist -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Today's Habits</h2>
        @if ($todayHabits->count() > 0)
            <div class="space-y-3 mb-6">
                @foreach ($todayHabits as $habit)
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                        <input type="checkbox" id="habit-{{ $habit->id }}" {{ $habit->pivot->completed_at ? 'checked' : '' }} 
                            onchange="updateHabit({{ $habit->id }}, this.checked)" class="w-5 h-5 text-emerald-600 rounded">
                        <label for="habit-{{ $habit->id }}" class="flex-1 text-slate-700 cursor-pointer {{ $habit->pivot->completed_at ? 'line-through text-slate-400' : '' }}">
                            {{ $habit->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="text-sm text-slate-600 mb-4">
                Completed: <span class="font-bold">{{ $todayHabits->where('pivot.completed_at', '!=', null)->count() }}/{{ $todayHabits->count() }}</span>
            </div>
        @else
            <p class="text-slate-600 mb-6">No habits set for today. Create some to get started!</p>
        @endif
        <a href="{{ route('habits.manage') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
            → Manage Habits
        </a>
    </div>

    <!-- Motivational Quote -->
    <div class="md:col-span-2 bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-8 border-2 border-dashed border-emerald-200">
        <p class="text-lg italic text-slate-700 mb-4">
            "{{ $quote['text'] }}"
        </p>
        <p class="text-sm text-slate-600">— {{ $quote['author'] }}</p>
    </div>

    <!-- Write Journal CTA -->
    <div class="bg-gradient-to-br from-blue-100 to-emerald-100 rounded-2xl p-8 shadow-sm border border-slate-200 flex flex-col justify-center">
        <h3 class="text-xl font-bold text-slate-800 mb-3">Journal Your Thoughts</h3>
        <p class="text-sm text-slate-600 mb-6">Reflecting helps. Take a moment to write what's on your mind.</p>
        <a href="{{ route('journal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition text-center">
            ✏️ Write Entry
        </a>
    </div>
</div>

<script>
function updateHabit(habitId, completed) {
    fetch(`/habits/${habitId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ completed })
    });
}
</script>
@endsection
