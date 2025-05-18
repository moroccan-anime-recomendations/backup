<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Log;

class JikanAnimeService
{
    protected $baseUrl;
    protected $cacheTime;

    public function __construct()
    {
        // URL de l'API Jikan
        $this->baseUrl = 'https://api.jikan.moe/v4';
        
        // Temps de cache en minutes (pour éviter de dépasser les limites de taux de l'API)
        $this->cacheTime = 60; // 1 heure
    }

    /**
     * Récupérer une liste d'animes populaires
     *
     * @param int $page Numéro de page
     * @param int $limit Nombre d'animes par page
     * @return array
     */
    public function getPopularAnimes(int $page = 1, int $limit = 15): array
    {
        $cacheKey = "popular_animes_page_{$page}_limit_{$limit}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($page, $limit) {
            try {
                $response = Http::get("{$this->baseUrl}/top/anime", [
                    'page' => $page,
                    'limit' => $limit,
                    'filter' => 'bypopularity'
                ]);
                
                if ($response->successful()) {
                    return $response->json()['data'] ?? [];
                }
                
                Log::error('Erreur lors de la récupération des animes populaires', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [];
            } catch (Exception $e) {
                Log::error('Exception lors de la récupération des animes populaires', [
                    'message' => $e->getMessage()
                ]);
                
                return [];
            }
        });
    }

    /**
     * Rechercher des animes par titre
     *
     * @param string $query Terme de recherche
     * @param int $page Numéro de page
     * @param int $limit Nombre d'animes par page
     * @return array
     */
    public function searchAnimes(string $query, int $page = 1, int $limit = 15): array
    {
        $cacheKey = "search_animes_query_{$query}_page_{$page}_limit_{$limit}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($query, $page, $limit) {
            try {
                $response = Http::get("{$this->baseUrl}/anime", [
                    'q' => $query,
                    'page' => $page,
                    'limit' => $limit
                ]);
                
                if ($response->successful()) {
                    return $response->json()['data'] ?? [];
                }
                
                Log::error('Erreur lors de la recherche d\'animes', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [];
            } catch (Exception $e) {
                Log::error('Exception lors de la recherche d\'animes', [
                    'message' => $e->getMessage()
                ]);
                
                return [];
            }
        });
    }

    /**
     * Récupérer les détails d'un anime par son ID
     *
     * @param int $animeId ID de l'anime
     * @return array|null
     */
    public function getAnimeDetails(int $animeId): ?array
    {
        $cacheKey = "anime_details_{$animeId}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($animeId) {
            try {
                $response = Http::get("{$this->baseUrl}/anime/{$animeId}");
                
                if ($response->successful()) {
                    return $response->json()['data'] ?? null;
                }
                
                Log::error('Erreur lors de la récupération des détails de l\'anime', [
                    'anime_id' => $animeId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return null;
            } catch (Exception $e) {
                Log::error('Exception lors de la récupération des détails de l\'anime', [
                    'anime_id' => $animeId,
                    'message' => $e->getMessage()
                ]);
                
                return null;
            }
        });
    }

    /**
     * Récupérer les animes par genre
     *
     * @param int $genreId ID du genre
     * @param int $page Numéro de page
     * @param int $limit Nombre d'animes par page
     * @return array
     */
    public function getAnimesByGenre(int $genreId, int $page = 1, int $limit = 15): array
    {
        $cacheKey = "animes_by_genre_{$genreId}_page_{$page}_limit_{$limit}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($genreId, $page, $limit) {
            try {
                $response = Http::get("{$this->baseUrl}/anime", [
                    'genres' => $genreId,
                    'page' => $page,
                    'limit' => $limit
                ]);
                
                if ($response->successful()) {
                    return $response->json()['data'] ?? [];
                }
                
                Log::error('Erreur lors de la récupération des animes par genre', [
                    'genre_id' => $genreId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [];
            } catch (Exception $e) {
                Log::error('Exception lors de la récupération des animes par genre', [
                    'genre_id' => $genreId,
                    'message' => $e->getMessage()
                ]);
                
                return [];
            }
        });
    }

    /**
     * Récupérer la liste des genres d'anime
     *
     * @return array
     */
    public function getAnimeGenres(): array
    {
        $cacheKey = "anime_genres";
        
        return Cache::remember($cacheKey, 24 * 60, function () { // Cache pour 24 heures
            try {
                $response = Http::get("{$this->baseUrl}/genres/anime");
                
                if ($response->successful()) {
                    return $response->json()['data'] ?? [];
                }
                
                Log::error('Erreur lors de la récupération des genres d\'anime', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [];
            } catch (Exception $e) {
                Log::error('Exception lors de la récupération des genres d\'anime', [
                    'message' => $e->getMessage()
                ]);
                
                return [];
            }
        });
    }
}