<div id="mainNavbar" class="navbar sticky top-0 z-50 px-4 lg:px-20 transition-all duration-300">
    <div class="flex-1 text-secondary">
        <a href="/" class="flex items-center gap-2">
            @if ($appSetting && $appSetting->app_logo)
                <img src="{{ $appSetting->app_logo_url }}" class="w-10 h-10 object-contain" alt="Logo">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                    <path fill-rule="evenodd"
                        d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z"
                        clip-rule="evenodd" />
                </svg>
            @endif
            <span class="text-xl font-bold tracking-tight">{{ $appSetting->app_name ?? config('app.name') }}</span>
        </a>
    </div>
    <div class="flex-none gap-2">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm rounded-lg">Dashboard</a>
        @endauth

        @if (Route::currentRouteName() !== 'welcome')
            <a href="{{ route('welcome') }}" class="btn btn-ghost btn-sm gap-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        @endif
    </div>
</div>
