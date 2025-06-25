<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardgameController;




// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/boardgames');

Auth::routes(['verify' => true]);
// Importe les routes suivantes pour l'authentification
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('boardgames', BoardgameController::class);
Route::resource('boardgames', BoardgameController::class)->only(['index', 'show']);

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('boardgames', \App\Http\Controllers\BoardgameController::class)->except(['index', 'show']);
    Route::get('boardgames', [\App\Http\Controllers\BoardgameController::class, 'index'])->name('boardgames.index');
});

Route::post('/boardgames/{boardgame}/upload-file', [BoardgameController::class, 'uploadFile'])->name('boardgames.uploadFile');
Route::delete('/boardgames/files/{file}', [BoardgameController::class, 'destroyFile'])->name('boardgames.files.destroy');

