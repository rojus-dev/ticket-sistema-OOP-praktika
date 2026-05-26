<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ⚙ Sistemos nustatymai
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">
                            El. paštas PDF ataskaitai
                        </label>
                        <p class="text-sm text-gray-500 mb-2">
                            Į šį el. paštą bus siunčiamos aktyvių problemų PDF ataskaitos.
                        </p>
                        <input type="email" name="report_email"
                               class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                               value="{{ old('report_email', $reportEmail) }}"
                               placeholder="pvz. admin@imone.lt">
                        @error('report_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Išsaugoti
                        </button>
                        <a href="{{ route('tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Atgal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>