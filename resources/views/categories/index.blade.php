<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Kategorijų valdymas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 flex gap-2">
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    Pridėti kategoriją
                </a>

                <a href="{{ route('tickets.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded">
                    Atgal į problemas
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">ID</th>
                            <th class="text-left p-2">Pavadinimas</th>
                            <th class="text-left p-2">Veiksmai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b">
                                <td class="p-2">{{ $category->id }}</td>
                                <td class="p-2">{{ $category->name }}</td>
                                <td class="p-2 flex gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Redaguoti
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Ar tikrai šalinti kategoriją?')"
                                                class="bg-red-600 text-white px-3 py-1 rounded">
                                            Šalinti
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center">
                                    Kategorijų nėra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>