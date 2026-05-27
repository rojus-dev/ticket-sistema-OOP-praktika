<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tickets.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                    <i class="ti ti-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Kategorijos</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Viso {{ $categories->count() }} kategorijų</p>
                </div>
            </div>
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                <i class="ti ti-plus text-base"></i> Pridėti
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-700 dark:text-emerald-300 text-sm">
            <i class="ti ti-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-300 text-sm">
            <i class="ti ti-alert-circle text-base"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-2xl">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
            @forelse($categories as $category)
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50 dark:border-gray-800 last:border-0 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                            <i class="ti ti-tag text-sm text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</p>
                            <p class="text-xs text-gray-400">#{{ $category->id }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition" title="Redaguoti">
                            <i class="ti ti-edit text-sm"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                              onsubmit="return confirm('Ar tikrai šalinti kategoriją?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition" title="Šalinti">
                                <i class="ti ti-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-12 text-center">
                    <i class="ti ti-tag text-3xl text-gray-300 dark:text-gray-600 block mb-2"></i>
                    <p class="text-sm text-gray-400">Kategorijų dar nėra.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>