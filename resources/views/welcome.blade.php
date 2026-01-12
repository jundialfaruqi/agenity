<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($title ?? 'Welcome') . ' - ' . ($appSetting->app_name ?? config('app.name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-base-200 min-h-screen flex flex-col">
    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50 px-4 lg:px-20">
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
        </div>
    </div>

    <main class="grow">
        <!-- Hero Section -->
        <div class="hero bg-base-100 py-16 lg:py-24">
            <div class="hero-content text-center px-4">
                <div class="max-w-2xl">
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight mb-6">Kelola Agenda & Absensi Digital
                        dengan Mudah</h1>
                    <p class="text-lg lg:text-xl text-base-content/70 mb-8 leading-relaxed">
                        Agenity adalah platform manajemen agenda digital yang membantu organisasi mengelola kegiatan,
                        sesi absensi, dan pelaporan secara real-time dan efisien.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#agendas" class="btn btn-secondary btn-lg rounded-xl px-8">Lihat Agenda Aktif</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-base-100 pb-16">
            <div class="container mx-auto px-4 lg:px-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="card rounded-full bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                        <div class="card-body p-5 flex-row items-center gap-4 text-left">
                            <div class="p-3 bg-primary/10 text-primary rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-base-content/50">Total
                                    Agenda</p>
                                <p class="text-2xl font-black mt-0.5">{{ $stats['total'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card rounded-full bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                        <div class="card-body p-5 flex-row items-center gap-4 text-left">
                            <div class="p-3 bg-success/10 text-success rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-base-content/50">Agenda
                                    Aktif</p>
                                <p class="text-2xl font-black mt-0.5">{{ $stats['active'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card rounded-full bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                        <div class="card-body p-5 flex-row items-center gap-4 text-left">
                            <div class="p-3 bg-info/10 text-info rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.125 2.25h3.75a.75.75 0 0 1 .75.75v1.125c0 .414.336.75.75.75h4.5a2.25 2.25 0 0 1 2.25 2.25v12.75a2.25 2.25 0 0 1-2.25 2.25H4.125a2.25 2.25 0 0 1-2.25-2.25V7.125a2.25 2.25 0 0 1 2.25-2.25h4.5c.414 0 .75-.336.75-.75V3a.75.75 0 0 1 .75-.75ZM9 10.125a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Zm0 3.75a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-base-content/50">Agenda
                                    Selesai</p>
                                <p class="text-2xl font-black mt-0.5">{{ $stats['finished'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card rounded-full bg-base-100 shadow border border-base-200 hover:shadow-md transition-shadow">
                        <div class="card-body p-5 flex-row items-center gap-4 text-left">
                            <div class="p-3 bg-warning/10 text-warning rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold tracking-widest text-base-content/50">Draft
                                    Agenda</p>
                                <p class="text-2xl font-black mt-0.5">{{ $stats['draft'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agendas Section -->
        <div id="agendas" class="py-20 bg-base-100">
            <div class="container mx-auto px-4 lg:px-20">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight mb-2">Agenda Publik Aktif</h2>
                        <p class="text-base-content/60">Daftar kegiatan yang sedang berlangsung dan dapat diikuti
                            secara publik.</p>
                    </div>
                    <div class="hidden md:block">
                        <span class="badge badge-lg badge-secondary gap-2 p-4">
                            <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                            {{ $agendas->total() }} Agenda Ditemukan
                        </span>
                    </div>
                </div>

                @if ($agendas->isEmpty())
                    <div class="card bg-base-200 border-2 border-dashed border-base-300 py-20">
                        <div class="card-body items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1" stroke="currentColor" class="w-16 h-16 text-base-content/20 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <h3 class="text-xl font-bold text-base-content/40">Belum ada agenda publik aktif</h3>
                            <p class="text-base-content/40">Silakan kembali lagi nanti untuk melihat agenda terbaru.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach ($agendas as $agenda)
                            <div
                                class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border border-base-200 group overflow-hidden flex flex-col h-full">
                                <figure
                                    class="relative h-48 bg-primary/5 flex items-center justify-center overflow-hidden">
                                    @if ($agenda->opdMaster->logo_url)
                                        <img src="{{ $agenda->opdMaster->logo_url }}"
                                            alt="{{ $agenda->opdMaster->name }}"
                                            class="w-32 h-32 object-contain group-hover:scale-110 transition-transform duration-500 opacity-80" />
                                    @else
                                        <div
                                            class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-12 h-12">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                                        <div
                                            class="badge badge-secondary font-bold shadow-sm uppercase text-[10px] p-2.5">
                                            {{ $agenda->visibility }}</div>
                                        <div
                                            class="badge badge-success font-bold shadow-sm uppercase text-[10px] p-2.5">
                                            {{ $agenda->status }}</div>
                                    </div>
                                </figure>
                                <div class="card-body p-6 flex flex-col grow">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div
                                            class="badge badge-outline badge-sm text-[10px] uppercase font-bold text-base-content/50">
                                            {{ $agenda->jenis_agenda }}</div>
                                        <div
                                            class="badge badge-ghost badge-sm text-[10px] uppercase font-bold text-base-content/50">
                                            {{ $agenda->mode }}</div>
                                    </div>
                                    <h2
                                        class="card-title text-xl mb-2 group-hover:text-secondary transition-colors line-clamp-2 min-h-14">
                                        <a
                                            href="{{ route('agenda.public_detail', $agenda->id) }}">{{ $agenda->title }}</a>
                                    </h2>
                                    <div class="space-y-2 mb-6 grow">
                                        <div class="flex items-center gap-3 text-sm text-base-content/60 flex-wrap">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($agenda->date)->locale('id')->translatedFormat('d F Y') }}


                                            @if ($agenda->time_status['label'])
                                                <span
                                                    class="badge badge-xs {{ $agenda->time_status['class'] }} font-bold uppercase">
                                                    {{ $agenda->time_status['label'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3 text-sm text-base-content/60">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 text-error">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            {{ $agenda->start_time }} - {{ $agenda->end_time }} WIB
                                        </div>
                                        <div class="flex items-center gap-3 text-sm text-base-content/60">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 text-success">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <span
                                                class="line-clamp-1">{{ $agenda->location ?? 'Online / TBD' }}</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-3 text-sm font-semibold text-base-content/80 mt-2">
                                            <div class="avatar placeholder">
                                                <div
                                                    class="bg-secondary text-secondary-content text-center rounded-full w-6">
                                                    <span
                                                        class="text-[10px]">{{ substr($agenda->opdMaster->singkatan, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            {{ $agenda->opdMaster->name }}
                                        </div>
                                    </div>
                                    <div
                                        class="card-actions justify-between items-center mt-auto pt-4 border-t border-base-200">
                                        <a href="{{ route('agenda.public_detail', $agenda->id) }}"
                                            class="btn btn-secondary btn-sm rounded-lg grow">Detail Agenda</a>
                                        @if ($agenda->sessions->count() > 0)
                                            <button type="button"
                                                class="btn btn-square btn-outline btn-sm rounded-lg"
                                                title="Tampilkan QR Code Absensi"
                                                onclick="showQrModal('{{ $agenda->title }}', '{{ asset('storage/' . $agenda->sessions->first()->qr_code_path) }}', '{{ route('absensi.show', $agenda->sessions->first()->token) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75ZM13.5 16.5h.75v.75h-.75v-.75ZM16.5 13.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 19.5h.75v.75h-.75v-.75Z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-12">
                        {{ $agendas->fragment('agendas')->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer
        class="footer p-10 bg-neutral text-neutral-content lg:px-20 flex flex-col md:flex-row justify-between gap-10">
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

    <!-- QR Modal -->
    <dialog id="qr_modal" class="modal">
        <div class="modal-box text-center p-8 max-w-sm rounded-2xl">
            <h3 class="font-bold text-xl mb-2" id="modal_agenda_title"></h3>
            <p class="text-sm text-base-content/60 mb-6">Scan QR code ini untuk mengisi absensi</p>

            <div class="bg-white p-4 rounded-2xl shadow-inner inline-block mb-6">
                <img id="modal_qr_image" src="" alt="QR Code" class="w-64 h-64" />
            </div>

            <div class="form-control w-full">
                <label class="label pt-0">
                    <span class="label-text-alt text-base-content/50">Link Absensi</span>
                </label>
                <div class="join">
                    <input id="modal_absensi_link" type="text" readonly
                        class="input input-bordered input-sm join-item grow text-xs focus:outline-none" />
                    <button onclick="copyLink()" class="btn btn-sm btn-primary join-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 1.927-.184" />
                        </svg>
                    </button>
                    <a id="modal_visit_link" href="" target="_blank"
                        class="btn btn-sm btn-neutral join-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>
                <div id="copy_success" class="text-[10px] text-success font-bold mt-1 opacity-0 transition-opacity">
                    Link berhasil disalin!</div>
            </div>

            <div class="modal-action mt-6">
                <form method="dialog" class="w-full">
                    <button class="btn btn-block rounded-xl">Tutup</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function showQrModal(title, qrImage, link) {
            document.getElementById('modal_agenda_title').innerText = title;
            document.getElementById('modal_qr_image').src = qrImage;
            document.getElementById('modal_absensi_link').value = link;
            document.getElementById('modal_visit_link').href = link;
            document.getElementById('qr_modal').showModal();
        }

        function copyLink() {
            const linkInput = document.getElementById('modal_absensi_link');
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
