<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mes Animes Favoris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($favorites->isEmpty())
                <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow-sm">
                    <p class="text-gray-600">Vous n'avez ajouté aucun anime en favori.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($favorites as $anime)
                        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                            <img src="{{ $anime->image_url }}" alt="{{ $anime->anime_title }}" class="object-cover w-full h-48">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $anime->anime_title }}</h3>
                                <a href="{{ route('animes.show', $anime->anime_id) }}"
                                   class="inline-block mt-2 text-sm text-blue-600 hover:underline">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
