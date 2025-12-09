<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('habits.index', compact('habits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        Habit::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category' => $validated['category'],
        ]);

        return back()->with('success', 'Habit created successfully!');
    }

    public function edit(int $id)
    {
        $habit = Habit::findOrFail($id);

        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, int $id)
    {
        $habit = Habit::findOrFail($id);

        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $habit->update($validated);

        return redirect()->route('habits.index')
            ->with('success', 'Habit updated successfully!');
    }

    public function destroy(int $id)
    {
        $habit = Habit::findOrFail($id);

        if ($habit->user_id !== Auth::id()) {
            abort(403);
        }

        $habit->delete();

        return back()->with('success', 'Habit deleted successfully!');
    }
}
