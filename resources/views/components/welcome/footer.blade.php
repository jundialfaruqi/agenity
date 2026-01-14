<footer class="footer p-10 bg-neutral text-neutral-content lg:px-20 flex flex-col md:flex-row justify-between gap-10">
    <div class="max-w-xs">
        <div class="flex items-center gap-2 mb-4">
            <div class="text-primary-content">
                @if ($appSetting && $appSetting->app_logo)
                    <img src="{{ $appSetting->app_logo_url }}" class="w-6 h-6 object-contain" alt="Logo">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
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
