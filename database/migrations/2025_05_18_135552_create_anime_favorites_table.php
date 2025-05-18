<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        // Modifier la table anime_favorites existante ou la créer si elle n'existe pas
        if (Schema::hasTable('anime_favorites')) {
            Schema::table('anime_favorites', function (Blueprint $table) {
                // Ajouter les colonnes nécessaires si elles n'existent pas déjà
                if (!Schema::hasColumn('anime_favorites', 'anime_id')) {
                    $table->integer('anime_id')->after('user_id');
                }
                if (!Schema::hasColumn('anime_favorites', 'image_url')) {
                    $table->string('image_url')->nullable()->after('anime_title');
                }
                
                // Supprimer l'index unique existant s'il existe
                if (Schema::hasTable('anime_favorites') && 
                    Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes('anime_favorites')) {
                    try {
                        $table->dropUnique(['user_id', 'anime_title']);
                    } catch (\Exception $e) {
                        // L'index n'existe peut-être pas
                    }
                }
                
                // Ajouter un nouvel index unique
                $table->unique(['user_id', 'anime_id']);
            });
        } else {
            // Créer la table si elle n'existe pas
            Schema::create('anime_favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('anime_id');
                $table->string('anime_title');
                $table->string('image_url')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
                
                // Assurer qu'un utilisateur ne peut pas ajouter deux fois le même anime
                $table->unique(['user_id', 'anime_id']);
            });
        }
        
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        // Ne pas supprimer la table, juste revenir aux colonnes d'origine
        Schema::table('anime_favorites', function (Blueprint $table) {
            // Vous ne pouvez pas vraiment "supprimer" des colonnes qui existaient peut-être déjà
            // Si c'est nécessaire, vous pouvez modifier leur type ou les rendre nullable
        });
    }
};