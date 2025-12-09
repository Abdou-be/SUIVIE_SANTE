<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\JournalEntry;
use App\Models\Mood;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Mood line chart for last 30 days
        $moodData = Mood::where('user_id', $userId)
            ->where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get(['date', 'mood_value']);

        // Habit statistics
        $habitStats = HabitLog::where('user_id', $userId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->with('habit')
            ->get()
            ->groupBy('habit_id')
            ->map(function ($logs) {
                return [
                    'habit_name' => $logs->first()->habit->name,
                    'total' => $logs->count(),
                    'completed' => $logs->where('completed', true)->count(),
                    'percentage' => $logs->count() > 0
                        ? round(($logs->where('completed', true)->count() / $logs->count()) * 100, 1)
                        : 0,
                ];
            })
            ->sortByDesc('percentage')
            ->values();

        // Monthly summaries
        $averageMood = Mood::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->avg('mood_value');

        $journalCount = JournalEntry::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $mostFollowedHabit = $habitStats->first();

        return view('statistics.index', compact(
            'moodData',
            'habitStats',
            'averageMood',
            'journalCount',
            'mostFollowedHabit'
        ));
    }
}
