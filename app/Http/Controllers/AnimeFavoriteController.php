<?php

namespace App\Http\Controllers;

use App\Models\AnimeFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AnimeFavoriteController extends Controller
{
    /**
     * Afficher la liste des animes favoris de l'utilisateur
     */
    public function index()
    {
        $favorites = AnimeFavorite::where('user_id', Auth::id())->get();
        
        return view('animes.favorites', [
            'favorites' => $favorites
        ]);
    }

    /**
     * Ajouter un anime aux favoris
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'anime_title' => 'required|string|max:255',
            'anime_id' => 'nullable|string|max:255',
            'image_url' => 'nullable|string',
            'description' => 'nullable|string'
        ]);
        
        // Vérifier si cet anime est déjà dans les favoris
        $existingFavorite = AnimeFavorite::where('user_id', Auth::id())
            ->where('anime_title', $validated['anime_title'])
            ->first();
            
        if ($existingFavorite) {
            return response()->json([
                'success' => false,
                'message' => 'Cet anime est déjà dans vos favoris'
            ]);
        }
        
        // Ajouter aux favoris
        $favorite = AnimeFavorite::create([
            'user_id' => Auth::id(),
            'anime_title' => $validated['anime_title'],
            'anime_id' => $validated['anime_id'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'description' => $validated['description'] ?? null
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Anime ajouté aux favoris',
            'favorite' => $favorite
        ]);
    }

    /**
     * Supprimer un anime des favoris
     */
    public function destroy(int $id): JsonResponse
    {
        $favorite = AnimeFavorite::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Favori non trouvé ou vous n\'avez pas la permission de le supprimer'
            ], 404);
        }
        
        $favorite->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Anime retiré des favoris'
        ]);
    }
}