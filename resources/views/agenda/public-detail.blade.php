<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $agenda->title }} - {{ config('app.name', 'Agenity') }}</title>

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
        <div class="flex-1">
            <a href="/" class="flex items-center gap-2">
                <div class="p-1.5 bg-primary rounded-lg text-primary-content">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-base-content">Agenity</span>
            </a>
        </div>
        <div class="flex-none">
            <a href="{{ route('welcome') }}" class="btn btn-ghost btn-sm gap-2">
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
                        <div class="h-4 bg-primary"></div>
                        <div class="card-body p-6 lg:p-10">
                            <div class="flex flex-wrap gap-2 mb-6">
                                <div class="badge badge-primary font-bold uppercase text-[10px] p-3">
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

                            <div class="flex items-center gap-4 p-4 bg-base-200 rounded-2xl mb-8">
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

                            <div class="prose max-w-none text-base-content/80 leading-relaxed mb-8">
                                <h3 class="text-xl font-bold text-base-content mb-3">Deskripsi Agenda</h3>
                                {!! nl2br(e($agenda->catatan ?? 'Tidak ada deskripsi tambahan untuk agenda ini.')) !!}
                            </div>

                            <div class="divider"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
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
                                            {{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('l, d F Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
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
                                        <div class="text-base font-bold text-base-content">{{ $agenda->start_time }} -
                                            {{ $agenda->end_time }} WIB</div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
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
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
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
                        <div class="card bg-base-100 shadow-xl border border-primary/20 overflow-hidden sticky top-24">
                            <div class="bg-primary p-4 text-center">
                                <h3 class="text-primary-content font-bold">Absensi Digital</h3>
                                <p class="text-primary-content/70 text-xs mt-1">Scan untuk mengisi daftar hadir</p>
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
                                        <button onclick="copyLink()" class="btn btn-sm btn-primary join-item">
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
                                    class="btn btn-primary btn-block rounded-xl gap-2">
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
                <div class="p-2 bg-primary rounded-lg text-primary-content">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tight">Agenity</span>
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
