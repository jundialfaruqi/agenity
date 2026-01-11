<header class="h-16 bg-base-100 flex items-center justify-between px-6 border-b border-base-200 shrink-0">
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
        <button class="btn btn-base btn-circle btn-sm">
            <div class="indicator">
                <span class="indicator-item status status-primary"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
        </button>
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
            <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 hidden">
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
