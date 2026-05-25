<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Redaguoti kategoriją
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 text-gray-900 dark:text-gray-100">Kategorijos pavadinimas</label>
                        <input type="text" name="name" class="w-full rounded border-gray-300"
                               value="{{ old('name', $category->name) }}">

                        @error('name')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Atnaujinti
                        </button>

                        <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Atgal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>