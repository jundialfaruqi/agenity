<x-layout title="Tambah Survei Baru">
    @if (session('error'))
        <div id="error-toast" class="toast toast-top toast-end z-50 shadow-2xl rounded-xl">
            <div class="alert alert-error shadow-lg text-white font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('error-toast');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    @if ($errors->any())
        <div id="validation-toast" class="toast toast-top toast-end z-50 shadow-2xl rounded-xl">
            <div class="alert alert-error shadow-lg text-white font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="text-xs list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('validation-toast');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 8000);
        </script>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Tambah Survei Baru</h1>
            <p class="text-sm text-base-content/60 mt-1">Buat kuesioner baru untuk masyarakat</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('survey.index') }}">Survei</a></li>
                <li><span class="text-base-content">Tambah</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <form action="{{ route('survey.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Judul Survei (Full Width) --}}
                    <div class="lg:col-span-3">
                        <label class="label"><span class="label-text font-bold mb-2">Judul Survei</span></label>
                        <input name="title" type="text" value="{{ old('title') }}"
                            class="input input-bordered w-full" placeholder="Masukkan judul survei" required>
                        @error('title')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kolom Kiri: Deskripsi --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="label"><span class="label-text font-bold mb-2">Deskripsi Survei
                                    (Opsional)</span></label>
                            <textarea name="description" class="textarea textarea-bordered w-full h-48"
                                placeholder="Masukkan penjelasan mengenai tujuan survei ini">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="mt-1 text-xs text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">Informasi</h3>
                                <div class="text-xs">Setelah membuat survei, Anda dapat menambahkan pertanyaan pada
                                    halaman edit survei.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Atribut Lainnya --}}
                    <div
                        class="lg:col-span-1 space-y-6 lg:sticky lg:top-0 lg:max-h-[calc(100vh-120px)] lg:overflow-y-auto lg:pr-2 custom-scrollbar">
                        {{-- Action Buttons --}}
                        <div class="bg-base-50/50 rounded-xl flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Survei
                                </button>
                            </div>
                            <div class="tooltip tooltip-left" data-tip="Batal">
                                <a href="{{ route('survey.index') }}"
                                    class="btn btn-sm btn-square text-base-content/60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="bg-base-50/50 p-4 rounded-xl border border-base-200">
                            <div class="grid grid-cols-1 gap-5">
                                <div>
                                    <label class="label"><span class="label-text font-bold mb-2">OPD
                                            Penyelenggara</span></label>
                                    <select name="opd_id" class="select select-bordered w-full" required>
                                        <option value="">Pilih OPD...</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}" @selected(old('opd_id') == $opd->id || Auth::user()->opd_master_id == $opd->id)>
                                                {{ $opd->singkatan }} -
                                                {{ $opd->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('opd_id')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="label"><span class="label-text font-bold mb-2">Kuota Responden
                                            (Opsional)</span></label>
                                    <input name="max_respondents" type="number"
                                        value="{{ old('max_respondents') }}" class="input input-bordered w-full"
                                        placeholder="Kosongkan jika tidak dibatasi" min="1">
                                    <div class="mt-1 text-[10px] text-base-content/50 italic">Kosongkan jika tidak
                                        ingin
                                        membatasi jumlah pengisi.</div>
                                    @error('max_respondents')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="label"><span
                                        class="label-text font-bold mb-2">Visibility</span></label>
                                <select name="visibility" class="select select-bordered w-full" required>
                                    <option value="public" @selected(old('visibility') === 'public')>Public (Terbuka Umum)
                                    </option>
                                    <option value="private" @selected(old('visibility') === 'private')>Private (Internal OPD)
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="label"><span class="label-text font-bold mb-2">Tanggal
                                        Mulai</span></label>
                                <input name="start_date" type="date"
                                    value="{{ old('start_date', date('Y-m-d')) }}"
                                    class="input input-bordered w-full" required>
                                @error('start_date')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="label"><span class="label-text font-bold mb-2">Tanggal
                                        Selesai</span></label>
                                <input name="end_date" type="date"
                                    value="{{ old('end_date', date('Y-m-d', strtotime('+1 month'))) }}"
                                    class="input input-bordered w-full" required>
                                @error('end_date')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label cursor-pointer justify-start gap-2">
                                    <input type="checkbox" name="is_active"
                                        class="checkbox checkbox-secondary checkbox-sm" checked />
                                    <span class="label-text font-bold">Aktifkan Survei</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile/Bottom Submit Button --}}
                    <div class="lg:hidden mt-6">
                        <button type="submit" class="btn btn-secondary w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Survei
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
