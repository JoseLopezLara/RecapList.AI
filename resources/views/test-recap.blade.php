<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Recap Table</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 p-8 min-h-screen transition-colors duration-200">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">RecapTable.AI</h1>
                <div class="flex items-center gap-4">
                    <livewire:light-button-component />
                    <button id="darkModeToggle" class="p-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <livewire:recap-table />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const html = document.documentElement;

            darkModeToggle.addEventListener('click', function() {
                html.classList.toggle('dark');

                // Opcionalmente guardar preferencia en localStorage
                if (html.classList.contains('dark')) {
                    localStorage.theme = 'dark';
                } else {
                    localStorage.theme = 'light';
                }
            });

            // Verificar configuración guardada
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        });
    </script>
</body>
</html>
