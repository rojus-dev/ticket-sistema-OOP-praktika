<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Problemos peržiūra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ticket->title }}</h3>
                    @php
                        $statusClass = match($ticket->status) {
                            'Naujas'    => 'bg-blue-100 text-blue-800',
                            'Vykdomas'  => 'bg-yellow-100 text-yellow-800',
                            'Užbaigtas' => 'bg-green-100 text-green-800',
                            default     => 'bg-gray-100 text-gray-800',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                        {{ $ticket->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4 text-sm text-gray-700 dark:text-gray-300">
                    <div><strong>Kategorija:</strong> {{ $ticket->category->name }}</div>
                    <div><strong>Sukūrė:</strong> {{ $ticket->user->name }}</div>
                    <div><strong>Sukurta:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
                    <div><strong>Atnaujinta:</strong> {{ $ticket->updated_at->format('Y-m-d H:i') }}</div>
                </div>

                <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded text-gray-900 dark:text-gray-100">
                    {{ $ticket->description }}
                </div>

                <div class="mt-6 flex gap-2">
                    @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin() || Auth::user()->isSupport())
                    <a href="{{ route('tickets.edit', $ticket) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Redaguoti
                    </a>
                    @endif
                    @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin())
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                          onsubmit="return confirm('Ar tikrai norite pašalinti?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Šalinti
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Atgal
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                    💬 Komentarai / pastabos ({{ $ticket->comments->count() }})
                </h3>

                @forelse($ticket->comments as $comment)
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded border-l-4 border-blue-400">
                        <p class="text-gray-900 dark:text-gray-100">{{ $comment->comment }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                            Parašė: <strong>{{ $comment->user->name }}</strong>
                            ({{ $comment->user->role }})
                            &bull; {{ $comment->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Komentarų dar nėra.</p>
                @endforelse

                <div class="mt-6 border-t pt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Pridėti komentarą</h4>
                    <form method="POST" action="{{ route('comments.store', $ticket) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="comment" rows="4"
                                      placeholder="Įrašykite komentarą arba pastabą..."
                                      class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Pridėti komentarą
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>