<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submit a Complaint - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Theme initialization script (must be in head to prevent flash) --}}
    <script>
        // Apply theme before page renders to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 'auto';
            const root = document.documentElement;

            if (theme === 'dark') {
                root.classList.add('dark');
            } else if (theme === 'light') {
                root.classList.remove('dark');
            } else { // auto
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    root.classList.add('dark');
                } else {
                    root.classList.remove('dark');
                }
            }
        })();
    </script>
</head>
<body class="antialiased">
    {{-- Theme Switcher in top right corner --}}
    <div class="fixed top-4 right-4 z-50">
        <x-theme-switcher />
    </div>

    @livewire('complaint-submission')

    @livewireScripts
</body>
</html>
