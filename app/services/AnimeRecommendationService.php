<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\AnimeFavorite;
use Exception;
use Illuminate\Support\Facades\Log;

class AnimeRecommendationService
{
    protected $apiUrl;

    public function __construct()
    {
        // URL de l'API Python de recommandation
        $this->apiUrl = env('ANIME_RECOMMENDATION_API_URL', 'http://localhost:8000');
    }

    /**
     * Obtenir des recommandations d'animes basées sur les favoris de l'utilisateur
     *
     * @param int $userId ID de l'utilisateur
     * @return array Recommandations d'animes
     */
    public function getRecommendations(int $userId): array
    {
        try {
            // Récupérer les animes favoris de l'utilisateur depuis la base de données
            $favorites = AnimeFavorite::where('user_id', $userId)
                ->pluck('anime_title')
                ->toArray();

            // Si l'utilisateur n'a pas de favoris, retourner un tableau vide
            if (empty($favorites)) {
                return [
                    'success' => false,
                    'recommendations' => [],
                    'message' => 'Aucun anime favori trouvé pour cet utilisateur'
                ];
            }

            // Préparer les données pour l'API de recommandation
            $requestData = [
                'user_id' => $userId,
                'animes_favoris' => $favorites
            ];

            // Appeler l'API Python
            $response = Http::post("{$this->apiUrl}/recommendation", $requestData);

            // Vérifier si la requête a réussi
            if ($response->successful()) {
                $recommendations = $response->json();
                
                return [
                    'success' => true,
                    'recommendations' => $recommendations['recommendations'] ?? [],
                    'original_response' => $recommendations['original_response'] ?? null
                ];
            } else {
                // Journaliser l'erreur de l'API
                Log::error('Erreur API de recommandation d\'animes', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'message' => 'Impossible d\'obtenir des recommandations. Erreur du service: ' . $response->status(),
                    'recommendations' => []
                ];
            }
        } catch (Exception $e) {
            // Journaliser l'exception
            Log::error('Exception lors de la récupération des recommandations d\'animes', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des recommandations: ' . $e->getMessage(),
                'recommendations' => []
            ];
        }
    }
}