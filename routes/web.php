<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AnimeRecommendationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AnimeFavoriteController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/signup', [SignupController::class, 'showForm'])->name('signup.form');
Route::post('/signup', [SignupController::class, 'register'])->name('signup.submit');

// Route pour afficher le formulaire de connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route pour traiter la connexion
Route::post('/login', [LoginController::class, 'login']);

// Route pour la déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route pour le tableau de bord (protégée par auth)

    Route::get('/anime/recommendations', [AnimeRecommendationController::class, 'getRecommendationsForCurrentUser']);
        Route::get('/animes', [AnimeController::class, 'index'])->name('animes.index');
    Route::get('/animes/search', [AnimeController::class, 'search'])->name('animes.search');
    Route::get('/animes/genre/{genreId}', [AnimeController::class, 'byGenre'])->name('animes.by_genre');
Route::get('/animes/{animeId}', [AnimeController::class, 'show'])
    ->where('animeId', '[0-9]+')
    ->name('animes.show');
        Route::get('/top100', [AnimeController::class, 'top100'])->name('animes.top100');
    // Routes pour la gestion des favoris (nécessite authentification)
    Route::get('/animes/favorites', [AnimeFavoriteController::class, 'index'])->name('animes.favorites');
   Route::post('/animes/favorites/add', [AnimeFavoriteController::class, 'store'])->name('animes.favorites.add');
Route::delete('/animes/favorites/{id}/remove', [AnimeFavoriteController::class, 'destroy'])->name('animes.favorites.remove');

    
    // Route pour les recommandations
    Route::get('/animes/recommendations/for-me', [AnimeRecommendationController::class, 'getRecommendationsForCurrentUser'])
        ->name('animes.recommendations');

