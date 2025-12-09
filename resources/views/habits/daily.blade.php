@extends('layouts.app')

@section('title', 'Daily Habits - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Today's Habits</h1>
        <a href="{{ route('habits.manage') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            + Manage Habits
        </a>
    </div>

    @if ($habits->count() > 0)
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
            <div class="space-y-4">
                @foreach ($habits as $habit)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl hover:shadow-md transition">
                        <div class="flex items-center gap-4 flex-1">
                            <input type="checkbox" id="habit-{{ $habit->id }}" 
                                {{ $habit->pivot->completed_at ? 'checked' : '' }}
                                onchange="updateHabit({{ $habit->id }}, this.checked)"
                                class="w-6 h-6 text-emerald-600 rounded cursor-pointer">
                            <label for="habit-{{ $habit->id }}" class="flex-1 cursor-pointer">
                                <p class="font-semibold text-slate-800 {{ $habit->pivot->completed_at ? 'line-through text-slate-400' : '' }}">
                                    {{ $habit->name }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $habit->category }}</p>
                            </label>
                        </div>
                        <span class="text-sm font-bold {{ $habit->pivot->completed_at ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $habit->pivot->completed_at ? '✓ Done' : 'Pending' }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                <p class="text-emerald-800 font-semibold">
                    Progress: <span class="text-2xl">{{ $habits->where('pivot.completed_at', '!=', null)->count() }}/{{ $habits->count() }}</span>
                </p>
                <div class="w-full bg-emerald-100 rounded-full h-3 mt-3">
                    <div class="bg-emerald-600 h-3 rounded-full transition" style="width: {{ ($habits->where('pivot.completed_at', '!=', null)->count() / $habits->count()) * 100 }}%"></div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl p-12 shadow-sm border border-slate-200 text-center">
            <p class="text-slate-600 mb-6">No habits scheduled for today.</p>
            <a href="{{ route('habits.manage') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                Create Your First Habit
            </a>
        </div>
    @endif
</div>

<script>
function updateHabit(habitId, completed) {
    fetch(`/habits/${habitId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(r => r.json()).then(data => {
        if (!data.success) alert('Error updating habit');
    });
}
</script>
@endsection
