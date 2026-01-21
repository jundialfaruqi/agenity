<div class="drawer-side z-50">
    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="menu p-0 w-64 h-full bg-base-100 border-r border-base-300 flex flex-col overflow-hidden">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-base-200 shrink-0">
            <div class="flex items-center gap-2 text-secondary font-bold text-2xl">
                @if ($appSetting && $appSetting->app_logo)
                    <img src="{{ $appSetting->app_logo_url }}" class="w-8 h-8 object-contain" alt="Logo">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd"
                            d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
                <span>{{ $appSetting->app_name ?? config('app.name') }}</span>
            </div>
        </div>

        <!-- Scrollable Navigation -->
        <div class="flex-1 overflow-y-auto no-scrollbar py-4">
            <ul class="menu w-full px-4 gap-1">
                <li class="menu-title text-xs font-semibold opacity-50 uppercase mb-1">Overview</li>

                <li>
                    <a wire:navigate href="{{ route('dashboard.index') }}"
                        class="{{ request()->routeIs('dashboard.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li class="menu-title text-xs font-semibold opacity-50 uppercase mt-4 mb-1">Apps</li>
                @can('view-agenda')
                    <li>
                        <a wire:navigate href="{{ route('agenda.index') }}"
                            class="{{ request()->routeIs('agenda.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12V12.75zm3 0h.008v.008H15V12.75zm0 3h.008v.008H15v-.008zm-3 0h.008v.008H12v-.008zm-3 0h.008v.008H9v-.008zm0-3h.008v.008H9V12.75z" />
                                </svg>
                                <span>Agenda</span>
                            </div>
                            <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen agenda dan absensi
                                digital</span>
                        </a>
                    </li>
                @endcan

                @can('view-event')
                    <li>
                        <a wire:navigate href="{{ route('event.index') }}"
                            class="{{ request()->routeIs('event.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span>Event</span>
                            </div>
                            <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen publikasi kegiatan dan
                                event</span>
                        </a>
                    </li>
                @endcan

                @can('view-survey')
                    <li>
                        <a wire:navigate href="{{ route('survey.index') }}"
                            class="{{ request()->routeIs('survey.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                            <div class="flex items-center gap-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                </svg>
                                <span>Survei</span>
                                <span class="badge badge-primary badge-sm ml-auto">New</span>
                            </div>
                            <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen survei dan feedback
                                masyarakat</span>
                        </a>
                    </li>
                @endcan

                @can('view-dokumentasi')
                    <li>
                        <a wire:navigate href="{{ route('dokumentasi.index') }}"
                            class="{{ request()->routeIs('dokumentasi.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span>Dokumentasi</span>
                            </div>
                            <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen dokumentasi Rapat</span>
                        </a>
                    </li>
                @endcan

                <li class="menu-title text-xs font-semibold opacity-50 uppercase mt-4 mb-1">Settings</li>

                @role(['super-admin', 'admin'])
                    <li>
                        <details
                            {{ request()->routeIs('users.*') || request()->routeIs('role_permission.*') ? 'open' : '' }}>
                            <summary class="group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                User Management
                            </summary>
                            <ul>
                                <li>
                                    <a wire:navigate href="{{ route('users.index') }}"
                                        class="{{ request()->routeIs('users.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                        Users
                                    </a>
                                </li>
                                @role('super-admin')
                                    <li>
                                        <a href="{{ route('role_permission.index') }}"
                                            class="{{ request()->routeIs('role_permission.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                            Role & Permissions
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </details>
                    </li>
                @endrole

                @can('view-master-opd')
                    <li>
                        <a href="{{ route('opd.index') }}"
                            class="{{ request()->routeIs('opd.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>

                            Master OPD
                        </a>
                    </li>
                @endcan

                @can('view-master-pakaian')
                    <li>
                        <details
                            {{ request()->routeIs('kategori-pakaian.*') || request()->routeIs('pakaian.*') ? 'open' : '' }}>
                            <summary class="group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Master Pakaian
                            </summary>
                            <ul>
                                <li>
                                    <a wire:navigate href="{{ route('kategori-pakaian.index') }}"
                                        class="{{ request()->routeIs('kategori-pakaian.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                        Kategori Pakaian
                                    </a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('pakaian.index') }}"
                                        class="{{ request()->routeIs('pakaian.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                        Pakaian
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                @endcan
                <li class="mt-4">
                    <a class="text-secondary font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                        </svg>
                        Components
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile (Bottom Sidebar) -->
        <div class="p-4 border-t border-base-200 shrink-0">
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="w-10 rounded-full">
                        <img
                            src="{{ auth()->user()->photo_url ?? 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp' }}" />
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-base-content/60 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                <div class="dropdown dropdown-end dropdown-top">
                    <label tabindex="0" class="btn btn-ghost btn-xs btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40 border border-base-200">
                        <li class="{{ request()->routeIs('profile') ? 'bg-primary/10 rounded-lg' : '' }}">
                            <a href="{{ route('profile') }}"
                                class="{{ request()->routeIs('profile') ? 'text-primary font-medium' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button" onclick="logout_modal.showModal()"
                                    class="flex items-center gap-2 cursor-pointer w-full text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>

    <!-- Logout Confirmation Modal -->
    <dialog id="logout_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Konfirmasi Logout</h3>
            <p class="py-4 text-base-content/70">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Batal</button>
                </form>
                <button type="button" onclick="document.getElementById('logout-form').submit()"
                    class="btn btn-error text-white">Logout</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>
