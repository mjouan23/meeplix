<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardgameController;
use App\Models\Boardgame;
use \App\Http\Controllers\Dashboard\BoardgameController as DashboardBoardgameController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     $boardgames = Boardgame::orderBy('created_at', 'desc')->get();
//     return view('boardgames.index', compact('boardgames'));
// });

// Route::get('/boardgames', function () {
//     $boardgames = Boardgame::orderBy('created_at', 'desc')->get();
//     return view('boardgames.index', compact('boardgames'));
// })->name('boardgames.index');

Route::get('/', [BoardgameController::class, 'index']);
Route::get('/boardgames', [BoardgameController::class, 'index'])->name('boardgames.index');
Route::get('/boardgames/{boardgame}', [BoardgameController::class, 'show'])->name('boardgames.show');

Auth::routes(['verify' => true]);
// Importe les routes suivantes pour l'authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
// routes pour le changement de mot de passe
Route::get('password/change', [PasswordChangeController::class, 'show'])
    ->name('password.change')
    ->middleware('auth');

Route::post('password/change', [PasswordChangeController::class, 'update'])
    ->name('password.change.update')
    ->middleware('auth');

// Création de jeux : uniquement admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/dashboard/boardgames/create', [DashboardBoardgameController::class, 'create'])->name('dashboard.boardgames.create');
    Route::post('/dashboard/boardgames', [DashboardBoardgameController::class, 'store'])->name('dashboard.boardgames.store');

    Route::delete('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'destroy'])->name('dashboard.boardgames.destroy');
});

// Dashboard et Administration des jeux accessibles aux admin et modérateurs
Route::middleware(['auth', 'role:admin,moderator'])->group(function () {

    Route::get('/dashboard/boardgames', [DashboardBoardgameController::class, 'index'])->name('dashboard.boardgames.index');
    Route::get('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'show'])->name('dashboard.boardgames.show');

    Route::get('/dashboard/boardgames/{boardgame}/edit', [DashboardBoardgameController::class, 'edit'])->name('dashboard.boardgames.edit');
    Route::put('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'update'])->name('dashboard.boardgames.update');

    Route::post('/dashboard/boardgames/{boardgame}/upload-file', [DashboardBoardgameController::class, 'uploadFile'])->name('dashboard.boardgames.uploadFile');
    Route::delete('/dashboard/boardgames/files/{file}', [DashboardBoardgameController::class, 'destroyFile'])->name('dashboard.boardgames.files.destroy');
});