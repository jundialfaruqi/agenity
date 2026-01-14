<header class="h-16 bg-base-100 flex items-center justify-between px-6 border-b border-base-200 shrink-0">
    <style>
        @keyframes bell-ring {

            0%,
            100% {
                transform: rotate(0deg);
            }

            5%,
            15%,
            25% {
                transform: rotate(15deg);
            }

            10%,
            20%,
            30% {
                transform: rotate(-15deg);
            }

            35% {
                transform: rotate(0deg);
            }
        }

        .animate-bell-ring {
            animation: bell-ring 2s ease-in-out infinite;
            transform-origin: top center;
        }
    </style>
    <div class="flex items-center gap-4">
        <!-- Hamburger Menu (Mobile Toggle) -->
        <label for="my-drawer" class="btn btn-square btn-ghost lg:hidden drawer-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
        <!-- Search -->
        <div class="form-control hidden sm:block">
            <div class="input-group">
                <div class="relative">
                    <input type="text" placeholder="Search"
                        class="input input-bordered w-full max-w-xs pl-10 h-10 bg-base-100 rounded-full" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <!-- Notifications -->
        <div class="dropdown dropdown-end">
            <button tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                <div class="indicator">
                    @if ($dashboardNotifications->count() > 0)
                        <div class="indicator-item inline-grid *:[grid-area:1/1] scale-75">
                            <div class="status status-primary animate-ping"></div>
                            <div class="status status-primary"></div>
                        </div>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 @if ($dashboardNotifications->count() > 0) animate-bell-ring @endif">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
            </button>
            <div tabindex="0"
                class="dropdown-content z-1 card card-compact w-80 shadow bg-base-100 border border-base-200 mt-2">
                <div class="card-body p-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <h3 class="font-bold text-sm">Notifikasi</h3>
                        <span class="badge badge-sm badge-neutral">{{ $dashboardNotifications->count() }}</span>
                    </div>
                    <div class="max-h-80 overflow-y-auto space-y-1 -mx-1 px-1">
                        @forelse($dashboardNotifications as $notif)
                            <a href="{{ $notif['url'] }}"
                                class="flex items-start gap-2 p-2 rounded-lg hover:bg-base-200 transition-colors border border-transparent hover:border-base-300 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-{{ $notif['color'] }}/10 flex items-center justify-center shrink-0 group-hover:bg-{{ $notif['color'] }}/20">
                                    @if ($notif['icon'] === 'calendar')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 text-{{ $notif['color'] }}">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                    @elseif($notif['icon'] === 'ticket')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 text-{{ $notif['color'] }}">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 text-{{ $notif['color'] }}">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-1 mb-0.5">
                                        <span
                                            class="text-[9px] font-bold uppercase tracking-wider text-base-content/40">{{ $notif['category'] }}</span>
                                        <span
                                            class="text-[9px] font-bold px-1 rounded-full bg-{{ $notif['color'] }}/10 text-{{ $notif['color'] }}">{{ $notif['type'] }}</span>
                                    </div>
                                    <p class="text-xs font-bold truncate text-base-content">{{ $notif['title'] }}
                                    </p>
                                    <p class="text-[11px] text-base-content/60 line-clamp-2 mt-0.5 leading-tight">
                                        {{ $notif['message'] }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="py-10 text-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 opacity-20">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-base-content/40">Tidak ada data yang memerlukan
                                    perhatian</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- Theme Toggle -->
        <button id="theme-toggle"
            class="btn btn-circle btn-sm btn-secondary hover:bg-neutral hover:text-primary-content">
            <!-- Sun Icon -->
            <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <!-- Moon Icon -->
            <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
        </button>

        <!-- Divider -->
        <div class="hidden md:block h-8 border-l border-dotted border-base-content/20"></div>

        <!-- Date and Time -->
        <div class="hidden md:flex flex-col items-start leading-tight">
            <span class="text-xs font-bold text-base-content/80">
                {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd') }}
            </span>
            <span class="text-[10px] text-base-content/50">
                {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}
            </span>
        </div>
    </div>
</header>
