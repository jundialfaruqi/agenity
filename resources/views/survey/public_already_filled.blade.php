<x-welcome-layout>
    <div class="grow bg-base-200/50 py-20">
        <div class="container mx-auto px-4 max-w-2xl text-center">
            <div class="card bg-base-100 shadow-2xl border border-base-200 overflow-hidden">
                <div class="card-body p-10 md:p-16">
                    <div class="flex justify-center mb-8">
                        <div class="w-24 h-24 bg-warning/10 text-warning rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>

                    <h1 class="text-3xl font-black mb-4">Sudah Mengisi Survei</h1>
                    <p class="text-lg text-base-content/70 leading-relaxed mb-10">
                        Sepertinya Anda sudah mengisi survei <strong>{{ $survey->title }}</strong> sebelumnya. 
                        Untuk menjaga validitas data, setiap responden hanya diperbolehkan mengisi survei sekali dalam 24 jam.
                    </p>

                    <div class="bg-base-200/50 rounded-2xl p-6 mb-10 text-left">
                        <div class="flex gap-4">
                            <div class="text-info mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-base-content mb-1">Informasi</h4>
                                <p class="text-sm text-base-content/60 leading-relaxed">
                                    Jika Anda merasa belum mengisi survei ini atau ingin memberikan masukan tambahan, silakan hubungi pihak <strong>{{ $survey->opd->name }}</strong> atau coba kembali besok.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg rounded-xl shadow-lg shadow-primary/20">
                            Kembali ke Beranda
                        </a>
                        <p class="text-xs text-base-content/40 italic">
                            Terima kasih atas partisipasi Anda sebelumnya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-welcome-layout>
