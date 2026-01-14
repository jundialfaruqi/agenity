<x-layout title="Edit Survei">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Edit Survei: {{ $survey->title }}</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola detail survei dan daftar pertanyaan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('survey.index') }}">Survei</a></li>
                <li><span class="text-base-content">Edit</span></li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Form Detail & Pertanyaan --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Detail Survei Card --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Detail Survei</h2>
                    <form action="{{ route('survey.update', $survey) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">Judul
                                        Survei</span></label>
                                <input name="title" type="text" value="{{ old('title', $survey->title) }}"
                                    class="input input-bordered w-full" placeholder="Masukkan judul survei" required>
                                @error('title')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">Deskripsi
                                        Survei</span></label>
                                <textarea name="description" class="textarea textarea-bordered w-full h-32"
                                    placeholder="Masukkan penjelasan mengenai tujuan survei ini">{{ old('description', $survey->description) }}</textarea>
                                @error('description')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-secondary">Simpan Perubahan Detail</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Pertanyaan Card --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="card-title text-lg">Daftar Pertanyaan</h2>
                        <button onclick="add_question_modal.showModal()" class="btn btn-neutral btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Pertanyaan
                        </button>
                    </div>

                    <div class="space-y-4">
                        @forelse($survey->questions as $question)
                            <div class="p-4 bg-base-200/50 rounded-xl border border-base-300 group">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="badge badge-sm badge-neutral">{{ $loop->iteration }}</span>
                                            <span
                                                class="badge badge-sm badge-outline opacity-60">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</span>
                                            @if ($question->is_required)
                                                <span class="badge badge-sm badge-error badge-outline">Wajib</span>
                                            @endif
                                        </div>
                                        <p class="font-medium text-base-content">{{ $question->question_text }}</p>

                                        @if (in_array($question->type, ['single_choice', 'multiple_choice']))
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @foreach ($question->options as $option)
                                                    <span
                                                        class="badge badge-ghost text-[10px]">{{ $option->option_text }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="btn btn-square btn-xs text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <button onclick="delete_question_modal_{{ $question->id }}.showModal()"
                                            class="btn btn-square btn-xs text-error">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>

                                        <dialog id="delete_question_modal_{{ $question->id }}" class="modal">
                                            <div class="modal-box">
                                                <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
                                                <p class="py-4">Apakah Anda yakin ingin menghapus pertanyaan ini? Data
                                                    jawaban yang terkait juga akan terhapus.</p>
                                                <div class="modal-action">
                                                    <form method="dialog">
                                                        <button class="btn btn-ghost btn-sm">Batal</button>
                                                    </form>
                                                    <form action="{{ route('survey.questions.destroy', $question) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-error btn-sm text-white">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </dialog>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center py-10 bg-base-200/30 rounded-xl border border-dashed border-base-300">
                                <p class="text-base-content/50 italic">Belum ada pertanyaan. Klik "Tambah Pertanyaan"
                                    untuk memulai.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Pengaturan Sidebar --}}
        <div
            class="lg:col-span-1 space-y-6 lg:sticky lg:top-0 lg:max-h-[calc(100vh-120px)] lg:overflow-y-auto lg:pr-2 custom-scrollbar">
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h2 class="card-title text-sm uppercase tracking-widest opacity-60 mb-4">Pengaturan Publikasi</h2>
                    <form action="{{ route('survey.update', $survey) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        {{-- Hidden fields to preserve detail data when updating sidebar --}}
                        <input type="hidden" name="title" value="{{ $survey->title }}">

                        <div class="space-y-5">
                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">OPD
                                        Penyelenggara</span></label>
                                <select name="opd_id" class="select select-bordered w-full select-sm" required>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" @selected(old('opd_id', $survey->opd_id) == $opd->id)>
                                            {{ $opd->singkatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="label"><span
                                        class="label-text font-bold mb-2">Visibility</span></label>
                                <select name="visibility" class="select select-bordered w-full select-sm" required>
                                    <option value="public" @selected(old('visibility', $survey->visibility) === 'public')>Public</option>
                                    <option value="private" @selected(old('visibility', $survey->visibility) === 'private')>Private</option>
                                </select>
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">Tanggal
                                        Mulai</span></label>
                                <input name="start_date" type="date"
                                    value="{{ old('start_date', $survey->start_date->format('Y-m-d')) }}"
                                    class="input input-bordered w-full input-sm" required>
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">Tanggal
                                        Selesai</span></label>
                                <input name="end_date" type="date"
                                    value="{{ old('end_date', $survey->end_date->format('Y-m-d')) }}"
                                    class="input input-bordered w-full input-sm" required>
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-bold mb-2">Kuota Responden
                                        (Opsional)</span></label>
                                <input name="max_respondents" type="number"
                                    value="{{ old('max_respondents', $survey->max_respondents) }}"
                                    class="input input-bordered w-full input-sm"
                                    placeholder="Kosongkan jika tidak dibatasi" min="1">
                                <div class="mt-1 text-[10px] text-base-content/50 italic text-center">Kosongkan jika
                                    tidak
                                    dibatasi.</div>
                            </div>

                            <div class="form-control">
                                <label class="label cursor-pointer justify-start gap-4">
                                    <input type="checkbox" name="is_active"
                                        class="checkbox checkbox-secondary checkbox-sm" @checked($survey->is_active) />
                                    <span class="label-text font-bold">Aktifkan Survei</span>
                                </label>
                            </div>

                            <div class="divider"></div>

                            <button type="submit" class="btn btn-secondary btn-block btn-sm">Perbarui
                                Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Statistik Ringkas --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h2 class="card-title text-sm uppercase tracking-widest opacity-60 mb-4">Statistik</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-base-200/50 p-3 rounded-xl text-center">
                            <div class="text-xl font-bold">{{ $survey->questions->count() }}</div>
                            <div class="text-[10px] opacity-60">Pertanyaan</div>
                        </div>
                        <div class="bg-base-200/50 p-3 rounded-xl text-center">
                            <div class="text-xl font-bold">{{ $survey->respondents->count() }}</div>
                            <div class="text-[10px] opacity-60">Responden</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Link Survei --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-6">
                    <h2 class="card-title text-sm uppercase tracking-widest opacity-60 mb-4">Link Survei</h2>
                    @if ($survey->visibility === 'public')
                        <div class="space-y-3">
                            <div class="text-xs text-base-content/60 italic">Survei ini bersifat publik dan dapat
                                diakses melalui link berikut:</div>
                            <div class="join w-full">
                                <input type="text" value="{{ route('survey.public_detail', $survey->id) }}"
                                    class="input input-bordered input-sm join-item flex-1 bg-base-200" readonly
                                    id="public_link">
                                <button class="btn btn-sm btn-secondary join-item"
                                    onclick="copyToClipboard('public_link')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            <div class="text-xs text-base-content/60 italic">Survei ini bersifat privat. Bagikan link
                                rahasia ini kepada responden:</div>
                            @if ($survey->tokens->count() > 0)
                                <div class="join w-full">
                                    <input type="text"
                                        value="{{ route('survey.private_access', $survey->tokens->first()->token) }}"
                                        class="input input-bordered input-sm join-item flex-1 bg-base-200" readonly
                                        id="private_link">
                                    <button class="btn btn-sm btn-secondary join-item"
                                        onclick="copyToClipboard('private_link')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 1.927-.184" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-warning text-[10px] p-2">
                                    <span>Token belum dibuat. Simpan pengaturan untuk membuat token.</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Pertanyaan --}}
    <dialog id="add_question_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg mb-4">Tambah Pertanyaan Baru</h3>
            <form action="{{ route('survey.questions.store', $survey) }}" method="POST" id="question_form"
                class="space-y-4">
                @csrf
                <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                <div>
                    <label class="label"><span class="label-text font-bold mb-2">Teks Pertanyaan</span></label>
                    <textarea name="question_text" class="textarea textarea-bordered w-full h-24"
                        placeholder="Contoh: Bagaimana pendapat Anda tentang layanan kami?" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Tipe Pertanyaan</span></label>
                        <select name="type" class="select select-bordered w-full" id="question_type" required>
                            <option value="text">Teks Jawaban Pendek</option>
                            <option value="single_choice">Pilihan Tunggal (Radio)</option>
                            <option value="multiple_choice">Pilihan Ganda (Checkbox)</option>
                            <option value="rating">Rating (1-5)</option>
                        </select>
                    </div>
                    <div class="flex items-end pb-3">
                        <label class="label cursor-pointer justify-start gap-4">
                            <input type="checkbox" name="is_required" class="checkbox checkbox-primary" checked />
                            <span class="label-text font-bold">Wajib Diisi</span>
                        </label>
                    </div>
                </div>

                {{-- Container for Options (only shown for single/multiple choice) --}}
                <div id="options_container" class="hidden space-y-3 p-4 bg-base-200 rounded-xl">
                    <label class="label pt-0"><span class="label-text font-bold">Pilihan Jawaban</span></label>
                    <div id="options_list" class="space-y-2">
                        <div class="flex gap-2">
                            <input type="text" name="options[]" class="input input-bordered input-sm flex-1"
                                placeholder="Pilihan 1">
                            <button type="button" class="btn btn-sm btn-square btn-ghost text-error remove-option">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.34 6m-4.74 6 4.74-6m4.74 6-4.74-6m4.74 6-4.74-6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="add_option_btn" class="btn btn-xs btn-ghost gap-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Pilihan
                    </button>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="add_question_modal.close()" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
                </div>
            </form>
        </div>
    </dialog>

    @push('scripts')
        <script>
            function copyToClipboard(elementId) {
                const input = document.getElementById(elementId);
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices
                navigator.clipboard.writeText(input.value).then(() => {
                    // Show a small toast or change button state
                    const btn = input.nextElementSibling;
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    `;
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-success');

                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-secondary');
                    }, 2000);
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const questionType = document.getElementById('question_type');
                const optionsContainer = document.getElementById('options_container');
                const addOptionBtn = document.getElementById('add_option_btn');
                const optionsList = document.getElementById('options_list');

                questionType.addEventListener('change', function() {
                    if (this.value === 'single_choice' || this.value === 'multiple_choice') {
                        optionsContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                });

                addOptionBtn.addEventListener('click', function() {
                    const div = document.createElement('div');
                    div.className = 'flex gap-2';
                    div.innerHTML = `
                        <input type="text" name="options[]" class="input input-bordered input-sm flex-1" placeholder="Pilihan Baru">
                        <button type="button" class="btn btn-sm btn-square btn-ghost text-error remove-option">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 6m-4.74 6 4.74-6m4.74 6-4.74-6m4.74 6-4.74-6" />
                            </svg>
                        </button>
                    `;
                    optionsList.appendChild(div);
                });

                optionsList.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-option')) {
                        e.target.closest('.flex').remove();
                    }
                });
            });
        </script>
    @endpush
</x-layout>
