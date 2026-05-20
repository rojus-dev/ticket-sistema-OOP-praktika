<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Problemos peržiūra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                    {{ $ticket->title }}
                </h3>

                <p class="mb-2 text-gray-700 dark:text-gray-300">
                    <strong>Kategorija:</strong> {{ $ticket->category->name }}
                </p>

                <p class="mb-2 text-gray-700 dark:text-gray-300">
                    <strong>Statusas:</strong> {{ $ticket->status }}
                </p>

                <p class="mb-2 text-gray-700 dark:text-gray-300">
                    <strong>Sukūrė:</strong> {{ $ticket->user->name }}
                </p>

                <p class="mb-4 text-gray-700 dark:text-gray-300">
                    <strong>Sukurta:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}
                </p>

                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded text-gray-900 dark:text-gray-100">
                    {{ $ticket->description }}
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('tickets.edit', $ticket) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded">
                        Redaguoti
                    </a>

                    <a href="{{ route('tickets.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded">
                        Atgal
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                    Komentarai / pastabos
                </h3>

                @forelse($ticket->comments as $comment)
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $comment->comment }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                            Parašė: {{ $comment->user->name }},
                            {{ $comment->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        Komentarų dar nėra.
                    </p>
                @endforelse

                <form method="POST" action="{{ route('comments.store', $ticket) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1 text-gray-900 dark:text-gray-100">
                            Naujas komentaras
                        </label>

                        <textarea name="comment" rows="4"
                                  class="w-full rounded border-gray-300">{{ old('comment') }}</textarea>

                        @error('comment')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Pridėti komentarą
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>