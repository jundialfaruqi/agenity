<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($title ?? 'Welcome') . ' - ' . ($appSetting?->app_name ?? config('app.name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-white min-h-screen flex flex-col">
    <!-- Navbar -->
    <x-welcome.header />

    <main class="grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-welcome.footer />

    <script>
        const navbar = document.getElementById("mainNavbar");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 20) {
                navbar.classList.add(
                    "glass",
                    "backdrop-blur-md"
                );
            } else {
                navbar.classList.remove(
                    "glass",
                    "backdrop-blur-md"
                );
            }
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
