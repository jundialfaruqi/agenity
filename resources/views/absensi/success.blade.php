<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil - {{ $session->agenda->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="card bg-base-100 shadow-2xl overflow-hidden">
            <div class="bg-success p-8 flex justify-center">
                <div class="rounded-full bg-white/20 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="card-body items-center text-center py-10">
                <h2 class="card-title text-2xl font-bold text-success mb-2">Absensi Berhasil!</h2>
                <p class="text-base-content/70 mb-6">Terima kasih, data kehadiran Anda telah berhasil direkam dalam
                    sistem.</p>

                <div class="bg-base-200 rounded-xl p-4 w-full mb-6 text-left">
                    <div class="text-xs opacity-50 uppercase font-bold mb-1">Nama Peserta</div>
                    <div class="font-bold text-lg mb-3">{{ $absensi->name }}</div>

                    <div class="text-xs opacity-50 uppercase font-bold mb-1">Kegiatan</div>
                    <div class="font-medium text-sm">{{ $session->agenda->title }}</div>
                    <div class="text-xs opacity-70 italic mt-1">{{ $session->session_name }}</div>

                    @if ($session->agenda->link_paparan || $session->agenda->link_zoom || $session->agenda->catatan)
                        <div class="divider my-2 opacity-20"></div>

                        @if ($session->agenda->link_paparan)
                            <div class="mb-3">
                                <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Link Paparan / Materi</div>
                                <a href="{{ $session->agenda->link_paparan }}" target="_blank"
                                    class="btn btn-xs btn-outline btn-primary normal-case">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    Buka Materi
                                </a>
                            </div>
                        @endif

                        @if ($session->agenda->link_zoom)
                            <div class="mb-3">
                                <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Link Zoom / Meeting</div>
                                <a href="{{ $session->agenda->link_zoom }}" target="_blank"
                                    class="btn btn-xs btn-outline btn-info normal-case">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                    Gabung Meeting
                                </a>
                            </div>
                        @endif

                        @if ($session->agenda->catatan)
                            <div class="mb-1">
                                <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Catatan Tambahan</div>
                                <p class="text-xs italic opacity-70 bg-base-300 p-2 rounded border-l-2 border-primary">
                                    {{ $session->agenda->catatan }}
                                </p>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="flex flex-col gap-2 w-full">
                    <div class="text-xs opacity-50 mb-2 italic">Halaman ini dapat Anda tutup sekarang.</div>
                    <a href="{{ route('welcome') }}" class="btn btn-neutral btn-block">Tutup Halaman</a>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-sm opacity-50">
            &copy; {{ date('Y') }} {{ $appSetting->app_name ?? config('app.name') }}
        </div>
    </div>
</body>

</html>
