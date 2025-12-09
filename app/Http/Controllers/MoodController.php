<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function index()
    {
        $todayMood = Mood::where('user_id', Auth::id())
            ->whereDate('date', today())
            ->first();

        return view('mood.index', compact('todayMood'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood_value' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string|max:200',
        ]);

        $mood = Mood::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => today(),
            ],
            [
                'mood_value' => $validated['mood_value'],
                'note' => $validated['note'] ?? null,
            ]
        );

        $suggestions = $this->getMoodSuggestions($mood->mood_value);

        return back()->with([
            'success' => 'Mood logged successfully!',
            'suggestions' => $suggestions,
        ]);
    }

    private function getMoodSuggestions(int $moodValue): array
    {
        return match (true) {
            $moodValue <= 2 => [
                'Take a 10 min break',
                'Listen to relaxing music',
                'Call a friend',
            ],
            $moodValue === 3 => [
                'Read a book',
                'Do a creative activity',
                'Try yoga',
            ],
            $moodValue >= 4 => [
                'Exercise',
                'Learn something new',
                'Write in your journal',
            ],
        };
    }
}
