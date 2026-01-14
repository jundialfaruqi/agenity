<x-welcome-layout>
    <!-- DEBUG: Render Check -->
    <div class="bg-base-300 text-[8px] text-center opacity-20">System: Survey View Loaded</div>
    <div class="grow bg-base-200/50 py-12" x-data="{
        step: 1,
        agreed: false,
        formData: {
            name: '',
            phone: '',
            nik: '',
            occupation: '',
            age: ''
        }
    }">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="mb-8" x-show="step === 1">
                <a href="{{ route('welcome') }}" class="btn btn-ghost btn-sm gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke Beranda
                </a>

                <div class="flex items-center gap-3 mb-4">
                    <div class="badge badge-primary badge-sm font-bold">{{ $survey->opd->name }}</div>
                    <div class="text-xs text-base-content/50">Berakhir pada
                        {{ $survey->end_date->translatedFormat('d F Y') }}</div>
                </div>

                <h1 class="text-3xl font-black mb-3">{{ $survey->title }}</h1>
                @if ($survey->description)
                    <p class="text-base-content/70 leading-relaxed">{{ $survey->description }}</p>
                @endif
            </div>

            <div class="mb-8" x-show="step === 2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="badge badge-primary badge-sm font-bold">{{ $survey->opd->name }}</div>
                </div>
                <h1 class="text-3xl font-black mb-3">{{ $survey->title }}</h1>
                <p class="text-base-content/70">Silakan isi kuesioner di bawah ini sesuai dengan pengalaman Anda.</p>
            </div>

            {{-- Step 1: Identitas --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
                    <div class="card-body p-6 md:p-10">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center text-sm">1</span>
                            Data Diri Responden
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-bold">Nama Lengkap <span
                                            class="text-error">*</span></span></label>
                                <input type="text" x-model="formData.name" placeholder="Masukkan nama lengkap"
                                    class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-bold">Nomor WhatsApp <span
                                            class="text-error">*</span></span></label>
                                <input type="tel" x-model="formData.phone" placeholder="0812..."
                                    class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-bold">NIK (Opsional)</span></label>
                                <input type="text" x-model="formData.nik" placeholder="16 digit NIK"
                                    class="input input-bordered w-full" maxlength="16" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-bold">Pekerjaan</span></label>
                                <input type="text" x-model="formData.occupation"
                                    placeholder="Contoh: PNS, Swasta, Mahasiswa" class="input input-bordered w-full" />
                            </div>
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text font-bold">Umur (Tahun)</span></label>
                                <input type="number" x-model="formData.age" placeholder="Contoh: 25"
                                    class="input input-bordered w-full" min="1" max="120" />
                            </div>
                        </div>

                        <div class="divider my-8">Keamanan Data</div>

                        <div class="bg-info/5 border border-info/20 rounded-2xl p-6 mb-6">
                            <div class="flex gap-4">
                                <div class="text-info mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.74c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base-content mb-1 text-sm md:text-base">Privasi Anda
                                        Terjamin</h4>
                                    <p class="text-sm text-base-content/60 leading-relaxed">
                                        Kami berkomitmen penuh untuk menjaga keamanan dan kerahasiaan identitas Anda.
                                        Data identitas yang Anda masukkan hanya digunakan untuk keperluan verifikasi
                                        responden dan tidak akan dipublikasikan atau diberikan kepada pihak ketiga
                                        manapun tanpa izin Anda.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label cursor-pointer justify-start gap-4 p-0">
                                <input type="checkbox" x-model="agreed" class="checkbox checkbox-primary" />
                                <span class="label-text font-medium text-base-content/80">
                                    Saya menyetujui persyaratan di atas dan menjamin data yang diisi adalah benar.
                                </span>
                            </label>
                        </div>

                        <div class="mt-8 pt-8 border-t border-base-200">
                            <button
                                @click="if(agreed && formData.name && formData.phone) { step = 2; window.scrollTo({ top: 0, behavior: 'smooth' }); }"
                                :disabled="!agreed || !formData.name || !formData.phone"
                                class="btn btn-primary btn-block btn-lg rounded-xl shadow-lg shadow-primary/20">
                                Lanjut ke Kuesioner
                            </button>
                            <p class="text-center text-xs text-base-content/40 mt-4 italic" x-show="!agreed">
                                Anda harus menyetujui persyaratan untuk melanjutkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Kuesioner --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
                    <div class="card-body p-6 md:p-10">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center text-sm">2</span>
                            Isi Kuesioner Survei
                        </h2>

                        <form action="{{ route('survey.public_submit', $survey->id) }}" method="POST"
                            class="space-y-10" id="surveyForm">
                            @csrf
                            {{-- Hidden identity fields --}}
                            <input type="hidden" name="name" :value="formData.name">
                            <input type="hidden" name="phone" :value="formData.phone">
                            <input type="hidden" name="nik" :value="formData.nik">
                            <input type="hidden" name="occupation" :value="formData.occupation">
                            <input type="hidden" name="age" :value="formData.age">

                            @foreach ($survey->questions as $question)
                                <div class="space-y-4">
                                    <label class="block">
                                        <span class="text-lg font-bold text-base-content block mb-2">
                                            {{ $loop->iteration }}. {{ $question->question_text }}
                                            @if ($question->is_required)
                                                <span class="text-error">*</span>
                                            @endif
                                        </span>
                                    </label>

                                    @if ($question->type === 'text')
                                        <input type="text" name="answers[{{ $question->id }}]"
                                            class="input input-bordered w-full" placeholder="Jawaban Anda"
                                            {{ $question->is_required ? 'required' : '' }}>
                                    @elseif($question->type === 'single_choice')
                                        <div class="grid grid-cols-1 gap-3">
                                            @foreach ($question->options as $option)
                                                <label
                                                    class="flex items-center gap-3 p-4 bg-base-200/50 hover:bg-base-200 rounded-xl border border-base-300 cursor-pointer transition-colors group">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="{{ $option->id }}" class="radio radio-primary"
                                                        {{ $question->is_required ? 'required' : '' }}>
                                                    <span
                                                        class="text-base-content group-hover:text-primary transition-colors">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'multiple_choice')
                                        <div class="grid grid-cols-1 gap-3">
                                            @foreach ($question->options as $option)
                                                <label
                                                    class="flex items-center gap-3 p-4 bg-base-200/50 hover:bg-base-200 rounded-xl border border-base-300 cursor-pointer transition-colors group">
                                                    <input type="checkbox" name="answers[{{ $question->id }}][]"
                                                        value="{{ $option->id }}"
                                                        class="checkbox checkbox-primary">
                                                    <span
                                                        class="text-base-content group-hover:text-primary transition-colors">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'rating')
                                        <div class="flex justify-center py-4">
                                            <div class="rating rating-lg gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="{{ $i }}"
                                                        class="mask mask-star-2 bg-warning"
                                                        {{ $i === 1 && $question->is_required ? 'required' : '' }}>
                                                @endfor
                                            </div>
                                        </div>
                                        <div
                                            class="flex justify-between px-2 text-[10px] uppercase font-bold text-base-content/40 tracking-widest">
                                            <span>Sangat Buruk</span>
                                            <span>Sangat Baik</span>
                                        </div>
                                    @endif

                                    @error('answers.' . $question->id)
                                        <p class="text-error text-xs mt-1">Pertanyaan ini wajib diisi.</p>
                                    @enderror
                                </div>
                                @if (!$loop->last)
                                    <div class="divider opacity-50"></div>
                                @endif
                            @endforeach

                            <div class="pt-6 border-t border-base-200 flex flex-col md:flex-row gap-4">
                                <button type="button"
                                    @click="step = 1; window.scrollTo({ top: 0, behavior: 'smooth' });"
                                    class="btn btn-ghost btn-lg flex-1 rounded-xl">
                                    Kembali ke Data Diri
                                </button>
                                <button type="submit"
                                    class="btn btn-primary btn-lg flex-2 rounded-xl shadow-lg shadow-primary/20">
                                    Kirim Jawaban Survei
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Alpine data initialized in x-data attribute
        </script>
    @endpush
</x-welcome-layout>
