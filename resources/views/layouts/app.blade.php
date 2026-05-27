<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ticket Sistema') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950">

    <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center gap-3">
                    <a href="{{ route('tickets.index') }}" class="flex items-center gap-2 text-gray-900 dark:text-white font-semibold text-sm">
                        <i class="ti ti-ticket text-emerald-600 text-lg"></i>
                        Ticket Sistema
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 dark:text-gray-500 hidden sm:block">
                        {{ Auth::user()->name }}
                        <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-medium {{ Auth::user()->roleClass() }}">
                            {{ Auth::user()->role }}
                        </span>
                    </span>

                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('settings.edit') }}"
                       class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="ti ti-settings text-base"></i>
                    </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 px-2.5 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <i class="ti ti-logout text-sm"></i>
                            Atsijungti
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @if(isset($header))
    <div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            {{ $header }}
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

</body>
</html>