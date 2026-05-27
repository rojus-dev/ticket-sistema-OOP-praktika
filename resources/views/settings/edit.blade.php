<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tickets.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Sistemos nustatymai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Tik administratoriui</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-700 dark:text-emerald-300 text-sm">
            <i class="ti ti-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-md">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <form method="POST" action="{{ route('settings.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        El. paštas PDF ataskaitai
                    </label>
                    <p class="text-xs text-gray-400 mb-2">Į šį adresą bus siunčiamos aktyvių problemų ataskaitos.</p>
                    <input type="email" name="report_email"
                           value="{{ old('report_email', $reportEmail) }}"
                           placeholder="admin@imone.lt"
                           class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                    @error('report_email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-3">
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