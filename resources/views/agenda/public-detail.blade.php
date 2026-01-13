<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $agenda->title }} - {{ $appSetting->app_name ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .agenda-detail-body img {
            display: block !important;
            margin: 1.5rem auto !important;
            max-width: 100% !important;
            height: auto !important;
            border-radius: 1rem;
            float: none !important;
        }

        /* Ensure images inside paragraphs or other containers are centered */
        .agenda-detail-body p,
        .agenda-detail-body div {
            text-align: center;
        }

        /* Reset text alignment for non-image content to left */
        .agenda-detail-body p:not(:has(img)) {
            text-align: left;
        }

        /* If :has is not supported, at least the images themselves are block + margin auto */
        .agenda-detail-body {
            line-height: 1.8;
            color: currentColor;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex flex-col">
    <!-- Navbar -->
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
                <span class="text-xl font-bold tracking-tight">
                    {{ $appSetting->app_name ?? config('app.name') }}
                </span>
            </a>
        </div>
        <div class="flex-none gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm rounded-lg">Dashboard</a>
            @endauth
            <a href="{{ route('welcome') }}" class="btn btn-ghost btn-sm gap-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <main class="grow py-8 lg:py-12">
        <div class="container mx-auto px-4 lg:px-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden">
                        <div class="h-4 bg-secondary"></div>
                        <div class="card-body p-6 lg:p-10">
                            <div class="flex flex-wrap gap-2 mb-6">
                                <div class="badge badge-secondary font-bold uppercase text-[10px] p-3">
                                    {{ $agenda->visibility }}</div>
                                <div class="badge badge-success font-bold uppercase text-[10px] p-3">
                                    {{ $agenda->status }}</div>
                                <div class="badge badge-outline font-bold uppercase text-[10px] p-3">
                                    {{ $agenda->jenis_agenda }}</div>
                                <div class="badge badge-ghost font-bold uppercase text-[10px] p-3">{{ $agenda->mode }}
                                </div>
                            </div>

                            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight mb-4 text-base-content">
                                {{ $agenda->title }}</h1>

                            <div class="flex items-center gap-4 p-4 bg-base-200 rounded-2xl mb-4">
                                <div class="avatar placeholder">
                                    <div class="bg-base text-primary-content rounded-lg w-12">
                                        @if ($agenda->opdMaster->logo_url)
                                            <img src="{{ $agenda->opdMaster->logo_url }}"
                                                alt="{{ $agenda->opdMaster->name }}" />
                                        @else
                                            <span
                                                class="text-xl font-bold">{{ substr($agenda->opdMaster->singkatan, 0, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-base-content">{{ $agenda->opdMaster->name }}
                                    </div>
                                    <div class="text-xs text-base-content/60">Penyelenggara Kegiatan</div>
                                </div>
                            </div>

                            <div class="max-w-none text-base-content/80 leading-relaxed mb-8">
                                @if ($agenda->content)
                                    <div class="agenda-content">
                                        <div class="agenda-detail-body">
                                            {!! $agenda->content !!}
                                        </div>
                                    </div>
                                    <div class="border-t-2 border-dotted border-base-300 my-10"></div>
                                @endif

                                <h3 class="text-xl font-bold text-base-content mb-3">Catatan Agenda</h3>
                                {!! nl2br(e($agenda->catatan ?? 'Tidak ada catatan tambahan untuk agenda ini.')) !!}

                                @if ($agenda->wifi_name || $agenda->password_wifi)
                                    <div class="mt-8 p-6 bg-primary/5 border border-primary/10 rounded-2xl">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="text-primary rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-base-content">Informasi Akses WiFi</h4>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @if ($agenda->wifi_name)
                                                <div class="bg-base-100 p-3 rounded-xl border border-base-200">
                                                    <div
                                                        class="text-[10px] uppercase font-bold text-base-content tracking-widest mb-1">
                                                        SSID / Nama WiFi</div>
                                                    <div class="flex items-center justify-between gap-2">
                                                        <span
                                                            class="font-mono font-bold text-primary text-[20px]">{{ $agenda->wifi_name }}</span>
                                                        <button
                                                            onclick="copyToClipboard('{{ $agenda->wifi_name }}', this)"
                                                            class="btn btn-ghost btn-xs">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-3 h-3">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($agenda->password_wifi)
                                                <div class="bg-base-100 p-3 rounded-xl border border-base-200">
                                                    <div
                                                        class="text-[10px] uppercase font-bold text-base-content tracking-widest mb-1">
                                                        Password</div>
                                                    <div class="flex items-center justify-between gap-2">
                                                        <span class="font-mono font-bold text-secondary text-[20px]"
                                                            id="wifi-pass-text"
                                                            style="display: none;">{{ $agenda->password_wifi }}</span>
                                                        <span class="font-mono font-bold text-secondary text-[20px]"
                                                            id="wifi-pass-placeholder">••••••••</span>
                                                        <div class="flex gap-1">
                                                            <button onclick="toggleWifiPass(this)"
                                                                class="btn btn-ghost btn-xs">
                                                                <svg id="pw-icon-show"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-3 h-3">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                                </svg>
                                                                <svg id="pw-icon-hide"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-3 h-3 hidden">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                            </button>
                                                            <button
                                                                onclick="copyToClipboard('{{ $agenda->password_wifi }}', this)"
                                                                class="btn btn-ghost btn-xs">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-3 h-3">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($agenda->link_lainnya)
                                    <div class="mt-6 p-4 bg-base-200 rounded-xl">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <div
                                                    class="text-xs font-bold text-base-content/60 uppercase tracking-wider mb-1">
                                                    {{ $agenda->ket_link_lainnya ?? 'Link Tambahan' }}
                                                </div>
                                                <div id="link-display-text"
                                                    class="font-mono text-sm break-all hidden">
                                                    {{ $agenda->link_lainnya }}
                                                </div>
                                                <div id="link-display-placeholder"
                                                    class="font-mono text-sm italic text-base-content/40">
                                                    ••••••••••••••••••••••••••••••••
                                                </div>
                                            </div>
                                            <div class="join">
                                                <button onclick="toggleLinkVisibility(this)"
                                                    class="btn btn-sm join-item btn-ghost border-base-300"
                                                    title="Tampilkan/Sembunyikan">
                                                    <svg id="icon-show" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    <svg id="icon-hide" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-4 h-4 text-primary hidden">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                </button>
                                                <button onclick="copyToClipboard('{{ $agenda->link_lainnya }}', this)"
                                                    class="btn btn-sm join-item btn-ghost border-base-300"
                                                    title="Salin Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                                                </button>
                                                <a href="{{ $agenda->link_lainnya }}" target="_blank"
                                                    class="btn btn-sm join-item btn-ghost border-base-300"
                                                    title="Kunjungi Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="border-t-2 border-dotted border-base-300 mb-8"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex gap-4">
                                    <div class="p-3 bg-secondary/10 text-secondary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Tanggal</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ \Carbon\Carbon::parse($agenda->date)->locale('id')->translatedFormat('l, d F Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-secondary/10 text-secondary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Waktu</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-secondary/10 text-secondary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Lokasi</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ $agenda->location ?? 'Online / TBD' }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-secondary/10 text-secondary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Admin / PIC</div>
                                        <div class="text-base font-bold text-base-content">{{ $agenda->user->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar / QR Code -->
                <div class="space-y-6">
                    @if ($agenda->sessions->count() > 0)
                        @php $session = $agenda->sessions->first(); @endphp
                        <div
                            class="card bg-base-100 shadow-xl border border-secondary/20 overflow-hidden sticky top-24">
                            <div class="bg-secondary p-4 text-center">
                                <h3 class="text-secondary-content font-bold">Absensi Digital</h3>
                                <p class="text-secondary-content/70 text-xs mt-1">Scan untuk mengisi daftar hadir</p>
                            </div>
                            <div class="card-body items-center text-center p-8">
                                <div class="bg-white p-4 rounded-2xl shadow-inner mb-6 border border-base-200">
                                    <img src="{{ asset('storage/' . $session->qr_code_path) }}" alt="QR Code"
                                        class="w-full h-auto max-w-50" />
                                </div>

                                <div class="form-control w-full mb-4">
                                    <label class="label pt-0">
                                        <span class="label-text-alt text-base-content/50">Link Absensi Langsung</span>
                                    </label>
                                    <div class="join">
                                        <input id="absensi_link" type="text" readonly
                                            value="{{ route('absensi.show', $session->token) }}"
                                            class="input input-bordered input-sm join-item grow text-xs focus:outline-none" />
                                        <button onclick="copyLink()" class="btn btn-sm btn-secondary join-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 1.927-.184" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="copy_success"
                                        class="text-[10px] text-success font-bold mt-1 opacity-0 transition-opacity">
                                        Link disalin!</div>
                                </div>

                                <a href="{{ route('absensi.show', $session->token) }}"
                                    class="btn btn-secondary btn-block rounded-xl gap-2">
                                    Isi Absensi Sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                            <div class="bg-base-200 p-4 text-center">
                                <p class="text-[10px] text-base-content/50 uppercase font-bold tracking-widest">Powered
                                    by Agenity</p>
                            </div>
                        </div>
                    @else
                        <div class="card bg-base-100 shadow-sm border border-base-200">
                            <div class="card-body items-center text-center p-8">
                                <div class="p-4 bg-warning/10 text-warning rounded-full mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-base-content">Sesi Absensi Belum Tersedia</h3>
                                <p class="text-sm text-base-content/60">Panitia belum membuka sesi absensi untuk agenda
                                    ini.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer
        class="footer p-10 bg-neutral text-neutral-content lg:px-20 mt-12 flex flex-col md:flex-row justify-between gap-10">
        <div class="max-w-xs">
            <div class="flex items-center gap-2 mb-4">
                <div class="text-primary-content">
                    @if ($appSetting && $appSetting->app_logo)
                        <img src="{{ $appSetting->app_logo_url }}" class="w-6 h-6 object-contain" alt="Logo">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10">
                            <path fill-rule="evenodd"
                                d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z"
                                clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-2xl font-bold tracking-tight">
                    {{ $appSetting->app_name ?? config('app.name') }}
                </span>
            </div>
            <p>Agenity Digital Agenda Management.<br />Solusi cerdas untuk pengelolaan kegiatan dan absensi.</p>
            <p class="text-xs opacity-50 mt-4">&copy; {{ date('Y') }} Agenity. All rights reserved.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-10 md:gap-20">
            <div class="flex flex-col gap-2">
                <span class="footer-title opacity-100 font-bold text-white mb-2">Layanan</span>
                <a class="link link-hover">Agenda Publik</a>
                <a class="link link-hover">Absensi Digital</a>
                <a class="link link-hover">Pelaporan</a>
            </div>
            <div class="flex flex-col gap-2">
                <span class="footer-title opacity-100 font-bold text-white mb-2">Organisasi</span>
                <a class="link link-hover">Tentang Kami</a>
                <a class="link link-hover">Kontak</a>
                <a class="link link-hover">Panduan Pengguna</a>
            </div>
            <div class="flex flex-col gap-2">
                <span class="footer-title opacity-100 font-bold text-white mb-2">Legal</span>
                <a class="link link-hover">Ketentuan Layanan</a>
                <a class="link link-hover">Kebijakan Privasi</a>
                <a class="link link-hover">Kebijakan Cookie</a>
            </div>
        </div>
    </footer>

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

        function toggleWifiPass(btn) {
            const passText = document.getElementById('wifi-pass-text');
            const placeholder = document.getElementById('wifi-pass-placeholder');
            const iconShow = document.getElementById('pw-icon-show');
            const iconHide = document.getElementById('pw-icon-hide');

            if (passText.style.display === 'none') {
                passText.style.display = 'inline';
                placeholder.style.display = 'none';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                passText.style.display = 'none';
                placeholder.style.display = 'inline';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }

        function toggleLinkVisibility(btn) {
            const linkText = document.getElementById('link-display-text');
            const placeholder = document.getElementById('link-display-placeholder');
            const iconShow = btn.querySelector('#icon-show');
            const iconHide = btn.querySelector('#icon-hide');

            if (linkText.classList.contains('hidden')) {
                linkText.classList.remove('hidden');
                placeholder.classList.add('hidden');
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                linkText.classList.add('hidden');
                placeholder.classList.remove('hidden');
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }

        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalContent = btn.innerHTML;
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-success">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                `;
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function copyLink() {
            const linkInput = document.getElementById('absensi_link');
            linkInput.select();
            linkInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(linkInput.value);

            const successMsg = document.getElementById('copy_success');
            successMsg.classList.remove('opacity-0');
            setTimeout(() => {
                successMsg.classList.add('opacity-0');
            }, 2000);
        }
    </script>
</body>

</html>
