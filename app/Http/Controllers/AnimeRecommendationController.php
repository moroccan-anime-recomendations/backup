<?php

namespace App\Http\Controllers;

use App\Services\AnimeRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnimeRecommendationController extends Controller
{
    protected $recommendationService;

    /**
     * Constructeur avec injection du service de recommandation
     */
    public function __construct(AnimeRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Obtenir des recommandations pour l'utilisateur connecté
     */
    public function getRecommendationsForCurrentUser(): JsonResponse
    {
        // Récupérer l'ID de l'utilisateur actuellement connecté
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }
        
        // Obtenir les recommandations
        $recommendations = $this->recommendationService->getRecommendations($userId);
        
        return response()->json($recommendations);
    }

    /**
     * Obtenir des recommandations pour un utilisateur spécifique (admin uniquement)
     */
    public function getRecommendationsForUser(Request $request, int $userId): JsonResponse
    {
        // Vérifier si l'utilisateur actuel est administrateur
        if (!Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Permission refusée. Accès réservé aux administrateurs.'
            ], 403);
        }
        
        // Vérifier si l'utilisateur cible existe
        if (!User::find($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }
        
        // Obtenir les recommandations
        $recommendations = $this->recommendationService->getRecommendations($userId);
        
        return response()->json($recommendations);
    }
}