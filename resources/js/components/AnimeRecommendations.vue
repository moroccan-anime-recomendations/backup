// resources/js/components/AnimeRecommendations.vue

<template>
  <div class="anime-recommendations">
    <h2 class="text-2xl font-bold mb-4">{{ title }}</h2>
    
    <div v-if="loading" class="my-4 text-center">
      <div class="spinner"></div>
      <p>Chargement des recommandations...</p>
    </div>
    
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>
    
    <div v-else-if="recommendations.length === 0" class="p-4 bg-gray-100 rounded-lg">
      <p>Ajoutez des animes à vos favoris pour obtenir des recommandations!</p>
    </div>
    
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div 
        v-for="(recommendation, index) in recommendations" 
        :key="index" 
        class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow"
      >
        <h3 class="text-xl font-bold mb-2">{{ recommendation.title }}</h3>
        <p class="text-gray-700">{{ recommendation.reason }}</p>
        
        <button 
          @click="addToFavorites(recommendation.title)"
          class="mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors"
        >
          Ajouter aux favoris
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'Recommandations pour vous'
    }
  },
  
  data() {
    return {
      recommendations: [],
      loading: true,
      error: null
    }
  },
  
  mounted() {
    this.fetchRecommendations();
  },
  
  methods: {
    async fetchRecommendations() {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await fetch('/anime/recommendations');
        const data = await response.json();
        
        if (data.success) {
          this.recommendations = data.recommendations || [];
        } else {
          this.error = data.message || 'Erreur lors du chargement des recommandations';
        }
      } catch (error) {
        this.error = 'Erreur de communication avec le serveur';
        console.error('Erreur lors de la récupération des recommandations:', error);
      } finally {
        this.loading = false;
      }
    },
    
    async addToFavorites(animeTitle) {
      try {
        const response = await fetch('/anime/favorites', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            anime_title: animeTitle
          })
        });
        
        const data = await response.json();
        
        if (data.success) {
          // Afficher une notification de succès
          this.$emit('favorite-added', data.favorite);
          alert('Anime ajouté aux favoris!');
        } else {
          alert(data.message || 'Erreur lors de l\'ajout aux favoris');
        }
      } catch (error) {
        console.error('Erreur lors de l\'ajout aux favoris:', error);
        alert('Erreur de communication avec le serveur');
      }
    }
  }
}
</script>

<style scoped>
.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border-left-color: #09f;
  animation: spin 1s linear infinite;
  margin: 0 auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>