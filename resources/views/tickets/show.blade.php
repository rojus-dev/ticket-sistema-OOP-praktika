<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tickets.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ticket->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    #{{ $ticket->id }} &middot; {{ $ticket->category->name }} &middot; {{ $ticket->created_at->format('Y-m-d H:i') }}
                </p>
            </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full {{ $ticket->statusClass() }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                {{ $ticket->status }}
            </span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-700 dark:text-emerald-300 text-sm">
            <i class="ti ti-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Aprašymas</h2>
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $ticket->description }}</p>

                @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin() || Auth::user()->isSupport())
                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                    @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin() || Auth::user()->isSupport())
                    <a href="{{ route('tickets.edit', $ticket) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <i class="ti ti-edit text-base"></i> Redaguoti
                    </a>
                    @endif
                    @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin())
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                          onsubmit="return confirm('Ar tikrai norite pašalinti?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                            <i class="ti ti-trash text-base"></i> Šalinti
                        </button>
                    </form>
                    @endif
                </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">
                    Komentarai
                    <span class="ml-1.5 px-1.5 py-0.5 bg-gray-100 dark:bg-gray-800 rounded text-xs text-gray-500">{{ $ticket->comments->count() }}</span>
                </h2>

                @forelse($ticket->comments as $comment)
                    <div class="flex gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs font-medium text-gray-600 dark:text-gray-300 shrink-0">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded {{ $comment->user->roleClass() }}">
                                        {{ $comment->user->role }}
                                    </span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->comment }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500">Komentarų dar nėra.</p>
                @endforelse

                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <form method="POST" action="{{ route('comments.store', $ticket) }}">
                        @csrf
                        <textarea name="comment" rows="3"
                                  placeholder="Parašykite komentarą..."
                                  class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none mb-2">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mb-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                            <i class="ti ti-send text-base"></i> Komentuoti
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-5">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Informacija</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Kategorija</dt>
                        <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->category->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Sukūrė</dt>
                        <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Sukurta</dt>
                        <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Atnaujinta</dt>
                        <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->updated_at->format('Y-m-d H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>