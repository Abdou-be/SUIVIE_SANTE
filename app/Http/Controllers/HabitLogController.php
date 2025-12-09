<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitLogController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = today();

        $habits = Habit::where('user_id', $userId)->get();

        foreach ($habits as $habit) {
            HabitLog::firstOrCreate(
                [
                    'habit_id' => $habit->id,
                    'user_id' => $userId,
                    'date' => $today,
                ],
                [
                    'completed' => false,
                ]
            );
        }

        $logs = HabitLog::with('habit')
            ->where('user_id', $userId)
            ->whereDate('date', $today)
            ->get();

        return view('habits.logs', compact('logs'));
    }

    public function update(int $id)
    {
        $log = HabitLog::findOrFail($id);

        if ($log->user_id !== Auth::id()) {
            abort(403);
        }

        $log->update([
            'completed' => !$log->completed,
        ]);

        return back()->with('success', 'Habit log updated!');
    }
}
