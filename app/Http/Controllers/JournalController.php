<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Redirect home → dashboard OR login depending on auth status
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Mood Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/mood', [MoodController::class, 'index'])->name('mood.index');
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');

    /*
    |--------------------------------------------------------------------------
    | Habit Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::get('/habits/{id}/edit', [HabitController::class, 'edit'])->name('habits.edit');
    Route::put('/habits/{id}', [HabitController::class, 'update'])->name('habits.update');
    Route::delete('/habits/{id}', [HabitController::class, 'destroy'])->name('habits.destroy');

    /*
    |--------------------------------------------------------------------------
    | Habit Logs Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/habits/logs', [HabitLogController::class, 'index'])->name('habits.logs.index');
    Route::post('/habits/logs/{id}', [HabitLogController::class, 'update'])->name('habits.logs.update');

    /*
    |--------------------------------------------------------------------------
    | Journal Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/journal/create', [JournalController::class, 'create'])->name('journal.create');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::get('/journal/{id}/edit', [JournalController::class, 'edit'])->name('journal.edit');
    Route::put('/journal/{id}', [JournalController::class, 'update'])->name('journal.update');
    Route::delete('/journal/{id}', [JournalController::class, 'destroy'])->name('journal.destroy');

    /*
    |--------------------------------------------------------------------------
    | Statistics Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});


/*
|--------------------------------------------------------------------------
| Breeze / Auth Routes
|--------------------------------------------------------------------------
|
| These are auto-included when Breeze is installed.
| DO NOT DELETE:
| - login
| - register
| - forgot-password
| - reset-password
| - email verification
|
*/

require __DIR__.'/auth.php';
