@extends('layouts.app')

@section('title', 'Write Journal Entry - MindFlow')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $entry ? 'Edit Entry' : 'Write a New Entry' }}</h1>
        <p class="text-slate-600 mb-8">Take your time. This is your safe space.</p>

        <form action="{{ $entry ? route('journal.update', $entry) : route('journal.store') }}" method="POST" class="space-y-6">
            @csrf
            @if ($entry)
                @method('PUT')
            @endif

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Title (optional)</label>
                <input type="text" id="title" name="title" maxlength="200" placeholder="Give your entry a title..."
                    value="{{ old('title', $entry?->title ?? '') }}"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-bold text-slate-700 mb-2">What's on your mind?</label>
                <textarea id="content" name="content" rows="12" required placeholder="Write freely here. There's no judgment, only reflection..."
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none font-serif">{{ old('content', $entry?->content ?? '') }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mood -->
            <div>
                <label for="mood" class="block text-sm font-bold text-slate-700 mb-3">How did you feel while writing? (optional)</label>
                <div class="flex gap-3">
                    @foreach ([
                        1 => '😢',
                        2 => '😕',
                        3 => '😐',
                        4 => '🙂',
                        5 => '😄'
                    ] as $level => $emoji)
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="{{ $level }}" {{ old('mood', $entry?->mood ?? '') == $level ? 'checked' : '' }} class="hidden peer">
                            <span class="inline-block text-3xl peer-checked:scale-125 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-lg p-2 transition">{{ $emoji }}</span>
                        </label>
                    @endforeach
                </div>
                @error('mood')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-bold py-3 rounded-lg transition">
                    {{ $entry ? 'Update Entry' : 'Save Entry' }}
                </button>
                <a href="{{ route('journal.index') }}" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold py-3 rounded-lg transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
