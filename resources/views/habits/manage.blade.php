@extends('layouts.app')

@section('title', 'Manage Habits - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">Manage Your Habits</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Add New Habit -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 sticky top-24">
                <h2 class="text-xl font-bold text-slate-800 mb-4">+ New Habit</h2>
                <form action="{{ route('habits.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="habit_name" class="block text-sm font-semibold text-slate-700 mb-2">Habit Name</label>
                        <input type="text" id="habit_name" name="name" required maxlength="100" placeholder="e.g., Meditate"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                        <select id="category" name="category" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a category</option>
                            <option value="wellness">🧘 Wellness</option>
                            <option value="exercise">💪 Exercise</option>
                            <option value="learning">📚 Learning</option>
                            <option value="social">👥 Social</option>
                            <option value="sleep">😴 Sleep</option>
                            <option value="nutrition">🥗 Nutrition</option>
                            <option value="mindfulness">🌿 Mindfulness</option>
                        </select>
                        @error('category')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg transition">
                        Create Habit
                    </button>
                </form>
            </div>
        </div>

        <!-- Habits List -->
        <div class="md:col-span-2">
            <div class="space-y-4">
                @forelse ($habits as $habit)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">{{ $habit->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $habit->category }}</p>
                            </div>
                            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                Created {{ $habit->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('habits.edit', $habit) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                                Edit
                            </a>
                            <form action="{{ route('habits.destroy', $habit) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this habit?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 shadow-sm border border-slate-200 text-center">
                        <p class="text-slate-600 mb-6">No habits yet. Create one to get started!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
