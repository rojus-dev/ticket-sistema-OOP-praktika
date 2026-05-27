<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tickets.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Statistika</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Problemų analizė ir grafikai</p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Problemos pagal statusą</h2>
            <p class="text-xs text-gray-400 mb-4">Kiek problemų yra kiekvienoje būsenoje</p>
            <canvas id="statusChart" height="220"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <h2 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Problemos pagal kategoriją</h2>
            <p class="text-xs text-gray-400 mb-4">Kurioje kategorijoje daugiausia problemų</p>
            <canvas id="categoryChart" height="220"></canvas>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
        <h2 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Problemų registravimas per 14 dienų</h2>
        <p class="text-xs text-gray-400 mb-4">Kiek problemų buvo užregistruota kiekvieną dieną</p>
        <canvas id="dailyChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statusLabels = @json($statusCounts->keys());
        const statusData   = @json($statusCounts->values());

        const categoryLabels = @json($categoryCounts->keys());
        const categoryData   = @json($categoryCounts->values());

        const dailyLabels = @json($dates->keys());
        const dailyData   = @json($dates->values());

        const gridColor = 'rgba(156,163,175,0.15)';
        const textColor = '#9ca3af';

        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#eff6ff', '#fffbeb', '#ecfdf5'],
                    borderColor: ['#3b82f6', '#f59e0b', '#10b981'],
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { color: textColor } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, precision: 0 } }
                }
            }
        });

        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: ['#eff6ff', '#fffbeb', '#ecfdf5', '#fdf2f8'],
                    borderColor: ['#3b82f6', '#f59e0b', '#10b981', '#d946ef'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, padding: 16, font: { size: 12 } }
                    }
                }
            }
        });

        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Užregistruota problemų',
                    data: dailyData,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    borderWidth: 2,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 4,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { color: textColor, maxTicksLimit: 7 } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, precision: 0 } }
                }
            }
        });
    </script>
</x-app-layout>