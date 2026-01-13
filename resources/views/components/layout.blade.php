<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' - ' . ($appSetting->app_name ?? config('app.name')) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Check theme preference before page load to avoid flash
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-theme', 'night');
        }
    </script>
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

    <!-- jQuery for Summernote -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote Lite (No Bootstrap Dependency) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
        /* Custom scrollbar for sidebar if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-base-200 font-sans text-base-content">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <!-- Drawer Content (Main Page) -->
        <div class="drawer-content flex flex-col h-screen overflow-hidden">
            <!-- Top Header -->
            <x-dashboard.header />

            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            <x-dashboard.footer />
        </div>

        <!-- Sidebar (Drawer Side) -->
        <x-dashboard.sidebar />
    </div>
    @livewireScripts
    <script src="{{ asset('js/global-loading.js') }}"></script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
    @stack('scripts')
</body>

</html>
