<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardgameController;
use \App\Http\Controllers\Dashboard\BoardgameController as DashboardBoardgameController;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/boardgames');

Route::get('/boardgames', [BoardgameController::class, 'index'])->name('boardgames.index');

Auth::routes(['verify' => true]);
// Importe les routes suivantes pour l'authentification
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

Route::get('/boardgames', [App\Http\Controllers\HomeController::class, 'index'])->name('boardgames');


Route::middleware(['auth'])->group(function () {
    Route::resource('boardgames', BoardgameController::class)->only(['index', 'show']);
});

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






