<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Berakhir - {{ $session->agenda->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="card bg-base-100 shadow-2xl overflow-hidden">
            <div class="bg-error p-8 flex justify-center">
                <div class="rounded-full bg-white/20 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="card-body items-center text-center py-10">
                <h2 class="card-title text-2xl font-bold text-error mb-2">Akses Ditolak</h2>
                <p class="text-base-content/70 mb-6">{{ $message }}</p>

                <div class="bg-base-200 rounded-xl p-4 w-full mb-6 text-left">
                    <div class="text-xs opacity-50 uppercase font-bold mb-1">Kegiatan</div>
                    <div class="font-medium text-sm">{{ $session->agenda->title }}</div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Mulai Absensi</div>
                            <div class="text-xs font-bold">
                                {{ \Carbon\Carbon::parse($session->start_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Batas Akhir</div>
                            <div class="text-xs font-bold">
                                {{ \Carbon\Carbon::parse($session->end_at)->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full">
                    <p class="text-xs opacity-50 mb-4">Silakan hubungi panitia penyelenggara jika Anda merasa ini adalah
                        kesalahan.</p>
                    @if (isset($show_login) && $show_login)
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login ke Agenity</a>
                    @endif
                    <a href="/" class="btn btn-neutral btn-block">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-sm opacity-50">
            &copy; {{ date('Y') }} {{ $appSetting->app_name ?? config('app.name') }}
        </div>
    </div>
</body>

</html>
