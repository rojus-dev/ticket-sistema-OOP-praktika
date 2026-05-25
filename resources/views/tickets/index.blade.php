<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Problemų sąrašas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('tickets.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Registruoti problemą
                </a>

                <a href="{{ route('tickets.activeReportPdf') }}"
                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Aktyvių problemų PDF
                </a>

                <a href="{{ route('tickets.sendActiveReportPdf') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Siųsti PDF el. paštu
                </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('categories.index') }}"
                    class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
                        Kategorijos
                </a>
            @endif

            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Naujos problemos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $newCount }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Vykdomos problemos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $inProgressCount }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Užbaigtos problemos</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $doneCount }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Viso problemų</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $tickets->count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 mb-6">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        Problemų statistika pagal statusą
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Grafikas parodo kiek problemų yra kiekvienoje būsenoje.
                    </p>
                </div>

                <canvas id="ticketChart" height="90"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">ID</th>
                            <th class="text-left p-2">Pavadinimas</th>
                            <th class="text-left p-2">Kategorija</th>
                            <th class="text-left p-2">Statusas</th>
                            <th class="text-left p-2">Sukūrė</th>
                            <th class="text-left p-2">Veiksmai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr class="border-b">
                                <td class="p-2">{{ $ticket->id }}</td>
                                <td class="p-2">{{ $ticket->title }}</td>
                                <td class="p-2">{{ $ticket->category->name }}</td>
                                <td class="p-2">{{ $ticket->status }}</td>
                                <td class="p-2">{{ $ticket->user->name }}</td>
                                <td class="p-2 flex gap-2">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="bg-green-600 text-white px-3 py-1 rounded">
                                        Peržiūrėti
                                    </a>
                                    <a href="{{ route('tickets.edit', $ticket) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Redaguoti
                                    </a>

                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Ar tikrai šalinti?')"
                                                class="bg-red-600 text-white px-3 py-1 rounded">
                                            Šalinti
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center">
                                    Problemų dar nėra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('ticketChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Naujas', 'Vykdomas', 'Užbaigtas'],
                datasets: [{
                    label: 'Problemų kiekis',
                    data: [{{ $newCount }}, {{ $inProgressCount }}, {{ $doneCount }}],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(34, 197, 94, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(34, 197, 94, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>