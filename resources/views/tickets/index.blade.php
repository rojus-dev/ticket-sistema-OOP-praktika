<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Problemų sąrašas</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Viso {{ $tickets->count() }} problemų sistemoje</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tickets.activeReportPdf') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <i class="ti ti-file-type-pdf text-base"></i> PDF
                </a>
                @if(Auth::user()->isAdmin() || Auth::user()->isSupport())
                <a href="{{ route('tickets.sendActiveReportPdf') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <i class="ti ti-send text-base"></i> Siųsti PDF
                </a>
                @endif
                @if(Auth::user()->isAdmin())
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <i class="ti ti-tag text-base"></i> Kategorijos
                </a>
                @endif
                <a href="{{ route('tickets.create') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                    <i class="ti ti-plus text-base"></i> Registruoti
                </a>
            </div>
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

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Naujos</p>
            <p class="text-2xl font-semibold text-blue-600 dark:text-blue-400">{{ $newCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Vykdomos</p>
            <p class="text-2xl font-semibold text-amber-600 dark:text-amber-400">{{ $inProgressCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Užbaigtos</p>
            <p class="text-2xl font-semibold text-emerald-600 dark:text-emerald-400">{{ $doneCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Viso</p>
            <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $tickets->count() }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl mb-6 p-4">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Problemų statistika</p>
        <canvas id="ticketChart" height="70"></canvas>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">#</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">Pavadinimas</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">Kategorija</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">Statusas</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">Sukūrė</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400">Veiksmai</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition">
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $ticket->id }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('tickets.show', $ticket) }}"
                               class="text-sm font-medium text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                                {{ $ticket->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md">
                                {{ $ticket->category->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full {{ $ticket->statusClass() }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $ticket->user->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition" title="Peržiūrėti">
                                    <i class="ti ti-eye text-sm"></i>
                                </a>
                                @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin() || Auth::user()->isSupport())
                                <a href="{{ route('tickets.edit', $ticket) }}"
                                   class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition" title="Redaguoti">
                                    <i class="ti ti-edit text-sm"></i>
                                </a>
                                @endif
                                @if(Auth::id() === $ticket->user_id || Auth::user()->isAdmin())
                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                      onsubmit="return confirm('Ar tikrai norite pašalinti?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition" title="Šalinti">
                                        <i class="ti ti-trash text-sm"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <i class="ti ti-inbox text-3xl text-gray-300 dark:text-gray-600 block mb-2"></i>
                            <p class="text-sm text-gray-400">Problemų dar nėra.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? '#1f2937' : '#f3f4f6';

        new Chart(document.getElementById('ticketChart'), {
            type: 'bar',
            data: {
                labels: @json($statuses),
                datasets: [{
                    data: [{{ $newCount }}, {{ $inProgressCount }}, {{ $doneCount }}],
                    backgroundColor: ['#eff6ff','#fffbeb','#ecfdf5'],
                    borderColor: ['#3b82f6','#f59e0b','#10b981'],
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 12 } } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, precision: 0, font: { size: 12 } } }
                }
            }
        });
    </script>
</x-app-layout>