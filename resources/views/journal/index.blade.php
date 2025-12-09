@extends('layouts.app')

@section('title', 'Journal Entries - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Your Journal</h1>
        <a href="{{ route('journal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
            ✏️ New Entry
        </a>
    </div>

    @if ($entries->count() > 0)
        <div class="space-y-4">
            @foreach ($entries as $entry)
                <article class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition group cursor-pointer">
                    <a href="{{ route('journal.show', $entry) }}" class="block">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800 group-hover:text-blue-600 transition">
                                    {{ $entry->title ?: 'Untitled Entry' }}
                                </h2>
                                <p class="text-sm text-slate-500">{{ $entry->created_at->format('M d, Y · g:i A') }}</p>
                            </div>
                            @if ($entry->mood)
                                <span class="text-3xl">{{ ['😢', '😕', '😐', '🙂', '😄'][$entry->mood - 1] }}</span>
                            @endif
                        </div>
                        <p class="text-slate-600 line-clamp-2">{{ Str::limit($entry->content, 150) }}</p>
                    </a>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('journal.edit', $entry) }}" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold px-3 py-1 rounded transition">
                            Edit
                        </a>
                        <form action="{{ route('journal.destroy', $entry) }}" method="POST" class="inline" onsubmit="return confirm('Delete this entry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-3 py-1 rounded transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $entries->links() }}
    @else
        <div class="bg-white rounded-2xl p-16 shadow-sm border border-slate-200 text-center">
            <p class="text-slate-600 text-lg mb-6">You haven't written any journal entries yet.</p>
            <a href="{{ route('journal.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                Write Your First Entry
            </a>
        </div>
    @endif
</div>
@endsection
