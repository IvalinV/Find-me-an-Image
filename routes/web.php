<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Native\Laravel\Facades\Notification;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    Artisan::call('inspire');
    return Artisan::output();
})->name('test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('openai/test', [Controller::class, 'makeRequest']);

Route::get('dogs', function () {
    $response = Http::get('https://dog.ceo/api/breeds/image/random');
    $url = $response->json()['message'];

    Notification::new()
        ->title('Dang it!')
        ->message('New doggo for you!!!')
        ->show();

    return Inertia::render('Dogs', [
        'url' => $url,
    ]);
})->name('joke');

require __DIR__.'/auth.php';
