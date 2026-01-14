<x-welcome-layout>
    <div class="grow bg-base-200/50 py-20">
        <div class="container mx-auto px-4 max-w-2xl text-center">
            <div class="card bg-base-100 shadow-2xl border border-base-200 overflow-hidden">
                <div class="card-body p-10 md:p-16">
                    <div class="flex justify-center mb-8">
                        <div class="w-24 h-24 bg-info/10 text-info rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.998 5.998 0 00-5.017-5.913m-2.74 3.57c1.337.036 2.712.121 4.1.255m0 0L15 15.833M15 15.833V4.697M15 15.833H3.74a3 3 0 00-3 3v.33a3 3 0 003 3h11.26a3 3 0 003-3v-.33z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>

                    <h1 class="text-3xl font-black mb-4">Kuota Terpenuhi</h1>
                    <p class="text-lg text-base-content/70 leading-relaxed mb-10">
                        Terima kasih atas minat Anda. Saat ini kuota responden untuk survei <strong>{{ $survey->title }}</strong> sudah terpenuhi.
                    </p>

                    <div class="bg-base-200/50 rounded-2xl p-6 mb-10 text-left">
                        <div class="flex gap-4">
                            <div class="text-primary mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-base-content mb-1">Informasi</h4>
                                <p class="text-sm text-base-content/60 leading-relaxed">
                                    Partisipasi masyarakat telah mencapai batas yang ditentukan oleh <strong>{{ $survey->opd->name }}</strong>. Kami sangat menghargai kesediaan Anda untuk berkontribusi dalam survei ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg rounded-xl shadow-lg shadow-primary/20">
                            Kembali ke Beranda
                        </a>
                        <p class="text-xs text-base-content/40 italic">
                            Anda masih dapat mengikuti survei lain yang tersedia di halaman utama.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-welcome-layout>
