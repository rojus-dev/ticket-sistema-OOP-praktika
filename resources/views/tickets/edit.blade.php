<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Redaguoti problemą
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Pavadinimas</label>
                        <input type="text" name="title" class="w-full rounded border-gray-300" value="{{ old('title', $ticket->title) }}">
                        @error('title')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Kategorija</label>
                        <select name="category_id" class="w-full rounded border-gray-300">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($ticket->category_id == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                @if(Auth::user()->isAdmin() || Auth::user()->isSupport())
                    <div class="mb-4">
                        <label class="block mb-1">Statusas</label>
                        <select name="status" class="w-full rounded border-gray-300">
                            <option value="Naujas" @if($ticket->status == 'Naujas') selected @endif>Naujas</option>
                            <option value="Vykdomas" @if($ticket->status == 'Vykdomas') selected @endif>Vykdomas</option>
                            <option value="Užbaigtas" @if($ticket->status == 'Užbaigtas') selected @endif>Užbaigtas</option>
                        </select>
                    </div>
                @endif

                    <div class="mb-4">
                        <label class="block mb-1">Aprašymas</label>
                        <textarea name="description" rows="5" class="w-full rounded border-gray-300">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Atnaujinti
                        </button>

                        <a href="{{ route('tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Atgal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>