@extends('layouts.app')

@section('title', 'Statistics - MindFlow')

@section('content')
<div class="max-w-7xl">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">Your Progress</h1>

    <!-- Monthly Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-8 shadow-lg">
            <p class="text-sm font-semibold opacity-90 mb-2">Average Mood</p>
            <p class="text-4xl font-bold">{{ number_format($averageMood, 1) }}/5</p>
            <p class="text-xs opacity-75 mt-3">Last 30 days</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-8 shadow-lg">
            <p class="text-sm font-semibold opacity-90 mb-2">Journal Entries</p>
            <p class="text-4xl font-bold">{{ $journalCount }}</p>
            <p class="text-xs opacity-75 mt-3">This month</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-2xl p-8 shadow-lg">
            <p class="text-sm font-semibold opacity-90 mb-2">Best Habit</p>
            <p class="text-2xl font-bold">{{ $bestHabit['name'] ?? '—' }}</p>
            <p class="text-xs opacity-75 mt-3">{{ $bestHabit['rate'] ?? 0 }}% completion</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Mood Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Mood Trend (Last 30 Days)</h2>
            <div class="w-full h-80 bg-slate-50 rounded-lg flex items-center justify-center">
                <p class="text-slate-500">📊 Chart would render here with Chart.js or similar</p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Quick Stats</h2>
            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-lg">
                    <p class="text-xs text-slate-600">Total Mood Logs</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $moodLogsCount }}</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-lg">
                    <p class="text-xs text-emerald-600">Habits Created</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $habitCount }}</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-600">Best Day</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $bestDay ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Habits Stats Table -->
    <div class="mt-8 bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Habit Statistics</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b-2 border-slate-200">
                    <tr class="text-left">
                        <th class="font-bold text-slate-700 py-3">Habit</th>
                        <th class="font-bold text-slate-700 py-3">Completed</th>
                        <th class="font-bold text-slate-700 py-3">Success Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($habitStats as $stat)
                        <tr class="hover:bg-slate-50">
                            <td class="py-4 font-semibold text-slate-800">{{ $stat['name'] }}</td>
                            <td class="py-4 text-slate-600">{{ $stat['completed'] }}/{{ $stat['total'] }} times</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-slate-200 rounded-full h-2">
                                        <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $stat['rate'] }}%"></div>
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $stat['rate'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-slate-600">No habit data yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
