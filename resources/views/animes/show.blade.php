<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $anime['title'] }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(isset($anime['images']['jpg']['image_url']))
                    <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="{{ $anime['title'] }}" class="w-64 h-auto mb-4 rounded">
                @endif

                <p class="text-gray-700 mb-4">{{ $anime['synopsis'] ?? 'Pas de synopsis disponible.' }}</p>

                <form method="POST" action="{{ route('animes.favorites.add') }}">
                    @csrf
                    <input type="hidden" name="anime_title" value="{{ $anime['title'] }}">
                    <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                    <input type="hidden" name="description" value="{{ $anime['synopsis'] ?? '' }}">
                    <input type="hidden" name="image_url" value="{{ $anime['images']['jpg']['image_url'] ?? '' }}">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Ajouter aux favoris
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
