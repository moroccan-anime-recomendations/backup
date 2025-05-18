<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recommandations d\'animes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(isset($recommendations) && count($recommendations) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recommendations as $recommendation)
                                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <h3 class="text-xl font-bold mb-2">{{ $recommendation['title'] }}</h3>
                                    <p class="text-gray-700">{{ $recommendation['reason'] }}</p>
                                    
                                    <form action="{{ route('anime.favorites.store') }}" method="POST" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="anime_title" value="{{ $recommendation['title'] }}">
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                                            Ajouter aux favoris
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 mb-4">Ajoutez des animes à vos favoris pour obtenir des recommandations personnalisées!</p>
                            <a href="{{ route('anime.favorites.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Gérer mes favoris
                            </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>