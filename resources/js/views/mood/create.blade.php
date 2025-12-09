@extends('layouts.app')

@section('title', 'How Are You Feeling? - MindFlow')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">How do you feel today?</h1>
        <p class="text-slate-600 mb-8">Take a moment to reflect on your emotional state.</p>

        <form action="{{ route('mood.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Mood Selection -->
            <div>
                <label class="block text-lg font-semibold text-slate-700 mb-6">Select your mood</label>
                <div class="grid grid-cols-5 gap-4">
                    @foreach ([
                        1 => ['😢', 'Very Bad', 'text-red-500', 'border-red-300'],
                        2 => ['😕', 'Not Good', 'text-orange-500', 'border-orange-300'],
                        3 => ['😐', 'Average', 'text-yellow-500', 'border-yellow-300'],
                        4 => ['🙂', 'Good', 'text-emerald-500', 'border-emerald-300'],
                        5 => ['😄', 'Very Good', 'text-green-500', 'border-green-300']
                    ] as $level => $mood)
                        <label class="cursor-pointer group">
                            <input type="radio" name="mood_level" value="{{ $level }}" required class="hidden peer" 
                                {{ old('mood_level') == $level ? 'checked' : '' }}>
                            <div class="flex flex-col items-center p-4 border-2 border-slate-200 rounded-xl transition group-hover:border-blue-300 peer-checked:border-2 peer-checked:{{ $mood[3] }} peer-checked:bg-slate-50">
                                <span class="text-4xl mb-2">{{ $mood[0] }}</span>
                                <span class="text-xs text-slate-600 text-center">{{ $mood[2] == 'text-yellow-500' ? 'Average' : $mood[1] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('mood_level')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Optional Note -->
            <div>
                <label for="note" class="block text-lg font-semibold text-slate-700 mb-3">
                    What's on your mind? (optional)
                </label>
                <textarea id="note" name="note" rows="5" maxlength="200" placeholder="Share your thoughts, feelings, or what triggered this mood..."
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                    {{ old('note') ? 'value=' . old('note') : '' }}></textarea>
                <p class="text-xs text-slate-500 mt-2">
                    <span id="charCount">0</span>/200 characters
                </p>
                @error('note')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-bold py-4 rounded-lg transition shadow-md">
                Save Mood & Get Suggestions
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('note')?.addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});
</script>
@endsection
