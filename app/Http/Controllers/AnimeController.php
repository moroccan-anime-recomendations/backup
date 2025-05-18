<?php

namespace App\Http\Controllers;

use App\Services\JikanAnimeService;
use App\Models\AnimeFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimeController extends Controller
{
    protected $jikanService;

    public function __construct(JikanAnimeService $jikanService)
    {
        $this->jikanService = $jikanService;
    }

    /**
     * Afficher la page d'accueil avec les animes populaires
     */
    public function index()
    {
        $popularAnimes = $this->jikanService->getPopularAnimes(1, 12);
        $genres = $this->jikanService->getAnimeGenres();
        
        return view('animes.index', [
            'popularAnimes' => $popularAnimes,
            'genres' => $genres
        ]);
    }

    /**
     * Afficher les résultats de recherche d'animes
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);
        
        $results = [];
        if ($query) {
            $results = $this->jikanService->searchAnimes($query, $page, 20);
        }
        
        return view('animes.search', [
            'results' => $results,
            'query' => $query,
            'page' => $page
        ]);
    }

    /**
     * Afficher les détails d'un anime
     */
    public function show(int $animeId)
    {
        $anime = $this->jikanService->getAnimeDetails($animeId);
        
        if (!$anime) {
            abort(404, 'Anime non trouvé');
        }
        
        // Vérifier si l'anime est dans les favoris de l'utilisateur
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = AnimeFavorite::where('user_id', Auth::id())
                ->where('anime_id', $animeId)
                ->exists();
        }
        
        return view('animes.show', [
            'anime' => $anime,
            'isFavorite' => $isFavorite
        ]);
    }

    /**
     * Afficher les animes par genre
     */
    public function byGenre(int $genreId)
    {
        $animes = $this->jikanService->getAnimesByGenre($genreId, 1, 20);
        $genres = $this->jikanService->getAnimeGenres();
        
        // Trouver le nom du genre actuel
        $currentGenre = null;
        foreach ($genres as $genre) {
            if ($genre['mal_id'] == $genreId) {
                $currentGenre = $genre;
                break;
            }
        }
        
        return view('animes.by_genre', [
            'animes' => $animes,
            'genres' => $genres,
            'currentGenre' => $currentGenre
        ]);
    }

    /**
     * Ajouter un anime aux favoris (AJAX)
     */
   
}