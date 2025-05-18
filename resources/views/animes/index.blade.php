<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Explorer les animes') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Recherche -->
            <div class="p-4 mb-6 bg-white shadow-md rounded-lg">
                <form action="{{ route('animes.search') }}" method="GET" class="flex items-center">
                    <input type="text" name="query" placeholder="Rechercher un anime..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        value="{{ request('query') }}">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                        Rechercher
                    </button>
                </form>
            </div>

            <!-- Genres -->
            <div class="p-4 mb-6 bg-white shadow-md rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Genres</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($genres as $genre)
                        <a href="{{ route('animes.by_genre', $genre['mal_id']) }}" 
                            class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 text-sm">
                            {{ $genre['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Animes populaires -->
            <div class="p-4 bg-white shadow-md rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Animes populaires</h3>
                
                @if(count($popularAnimes) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($popularAnimes as $anime)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                <a href="{{ route('animes.show', $anime['mal_id']) }}">
                                    <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="{{ $anime['title'] }}" 
                                        class="w-full h-56 object-cover">
                                    <div class="p-4">
                                        <h4 class="text-md font-medium line-clamp-2 h-12">{{ $anime['title'] }}</h4>
                                        <div class="flex justify-between mt-2 text-sm text-gray-600">
                                            <span>{{ $anime['type'] ?? 'TV' }}</span>
                                            <span>⭐ {{ $anime['score'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aucun anime trouvé</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>