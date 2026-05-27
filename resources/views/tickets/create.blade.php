<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tickets.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Registruoti problemą</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Nauja problema bus priskirta jums</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <form method="POST" action="{{ route('tickets.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pavadinimas</label>
                    <input type="text" name="title"
                           value="{{ old('title') }}"
                           placeholder="Trumpai apibūdinkite problemą..."
                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategorija</label>
                    <select name="category_id"
                            class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        <option value="">Pasirinkite kategoriją...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Aprašymas</label>
                    <textarea name="description" rows="5"
                              placeholder="Detaliai aprašykite problemą – kur įvyko, kaip atkartoti, kokia klaida matoma..."
                              class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                        <i class="ti ti-check text-base"></i> Išsaugoti
                    </button>
                    <a href="{{ route('tickets.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Atšaukti
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>