<x-layout title="Edit Agenda">
    @push('styles')
    @endpush

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Edit Agenda</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data agenda kegiatan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('agenda.index') }}">Agenda</a></li>
                <li><span class="text-base-content">Edit</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <form action="{{ route('agenda.update', $agenda->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Judul Agenda (Full Width) --}}
                    <div class="lg:col-span-3">
                        <label class="label"><span class="label-text font-bold mb-2">Judul Agenda</span></label>
                        <input name="title" type="text" value="{{ old('title', $agenda->title) }}"
                            class="input input-bordered w-full" placeholder="Masukkan judul kegiatan/rapat" required>
                        @error('title')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kolom Kiri: Konten & Catatan (Lebih Lebar) --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="label"><span class="label-text font-bold mb-2">Konten Detail Agenda
                                    (Opsional)</span></label>
                            <div class="prose max-w-none">
                                <textarea name="content" id="editor" class="hidden">{{ old('content', $agenda->content) }}</textarea>
                            </div>
                            @error('content')
                                <div class="mt-1 text-xs text-error">{{ $message }}</div>
                            @enderror
                            <p class="text-xs text-base-content/50 mt-2">Gunakan editor ini untuk menulis detail agenda
                                seperti artikel (bisa gambar, list, bold, dll).</p>
                        </div>

                        <div>
                            <label class="label"><span class="label-text font-bold mb-2">Catatan
                                    Tambahan</span></label>
                            <textarea name="catatan" class="textarea textarea-bordered w-full h-32"
                                placeholder="Masukkan informasi tambahan jika ada">{{ old('catatan', $agenda->catatan) }}</textarea>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Atribut Lainnya (Lebih Sempit) --}}
                    <div class="lg:col-span-1 space-y-6">
                        {{-- Action Buttons --}}
                        <div
                            class="bg-base-50/50 p-3 rounded-xl border border-base-200 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <button type="submit" name="status" value="active" class="btn btn-secondary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Kirim
                                </button>
                                <button type="submit" name="status" value="draft" class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Draft
                                </button>
                                <button type="submit" name="status" value="finished" class="btn btn-success btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Selesai
                                </button>
                            </div>
                            <div class="tooltip tooltip-left" data-tip="Batal">
                                <a href="{{ route('agenda.index') }}"
                                    class="btn btn-ghost btn-sm btn-square text-base-content/60">
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
                                    <label class="label"><span class="label-text font-bold mb-2">Jenis
                                            Agenda</span></label>
                                    <input name="jenis_agenda" type="text"
                                        value="{{ old('jenis_agenda', $agenda->jenis_agenda) }}"
                                        class="input input-bordered w-full"
                                        placeholder="Contoh: Rapat Koordinasi, Seminar, dsb" required>
                                    @error('jenis_agenda')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="label"><span class="label-text font-bold mb-2">OPD
                                            Penyelenggara</span></label>
                                    <select name="master_opd_id" class="select select-bordered w-full" required>
                                        <option value="">Pilih OPD...</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}" @selected(old('master_opd_id', $agenda->master_opd_id) == $opd->id)>
                                                {{ $opd->singkatan }} -
                                                {{ $opd->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('master_opd_id')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="label"><span
                                            class="label-text font-bold mb-2">Visibility</span></label>
                                    <select name="visibility" class="select select-bordered w-full" required>
                                        <option value="public" @selected(old('visibility', $agenda->visibility) === 'public')>Public (Terbuka Umum)
                                        </option>
                                        <option value="private" @selected(old('visibility', $agenda->visibility) === 'private')>Private (Internal OPD)
                                        </option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="label"><span
                                                class="label-text font-bold mb-2">Mode</span></label>
                                        <select name="mode" class="select select-bordered w-full" required>
                                            <option value="offline" @selected(old('mode', $agenda->mode) === 'offline')>Offline</option>
                                            <option value="online" @selected(old('mode', $agenda->mode) === 'online')>Online</option>
                                            <option value="hybrid" @selected(old('mode', $agenda->mode) === 'hybrid')>Hybrid</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="label"><span
                                                class="label-text font-bold mb-2">Tanggal</span></label>
                                        <input name="date" type="date"
                                            value="{{ old('date', $agenda->date) }}"
                                            class="input input-bordered w-full" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="label"><span class="label-text font-bold mb-2">Jam
                                                Mulai</span></label>
                                        <input name="start_time" type="time"
                                            value="{{ old('start_time', \Carbon\Carbon::parse($agenda->start_time)->format('H:i')) }}"
                                            class="input input-bordered w-full" required>
                                    </div>
                                    <div>
                                        <label class="label"><span class="label-text font-bold mb-2">Jam
                                                Selesai</span></label>
                                        <input name="end_time" type="time"
                                            value="{{ old('end_time', \Carbon\Carbon::parse($agenda->end_time)->format('H:i')) }}"
                                            class="input input-bordered w-full" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="label"><span class="label-text font-bold mb-2">Lokasi /
                                            Ruangan</span></label>
                                    <input name="location" type="text"
                                        value="{{ old('location', $agenda->location) }}"
                                        class="input input-bordered w-full" placeholder="Contoh: Ruang Rapat Lt. 3">
                                </div>

                                <div class="divider text-xs opacity-50 uppercase tracking-widest">Link & Koneksi</div>

                                <div class="space-y-4">
                                    <input name="link_paparan" type="url"
                                        value="{{ old('link_paparan', $agenda->link_paparan) }}"
                                        class="input input-sm input-bordered w-full"
                                        placeholder="Link Paparan (https://...)">

                                    <input name="link_zoom" type="url"
                                        value="{{ old('link_zoom', $agenda->link_zoom) }}"
                                        class="input input-sm input-bordered w-full" placeholder="Link Zoom/Meeting">

                                    <input name="link_streaming_youtube" type="url"
                                        value="{{ old('link_streaming_youtube', $agenda->link_streaming_youtube) }}"
                                        class="input input-sm input-bordered w-full" placeholder="Link YouTube">

                                    <div class="grid grid-cols-1 gap-2">
                                        <input name="link_lainnya" type="url"
                                            value="{{ old('link_lainnya', $agenda->link_lainnya) }}"
                                            class="input input-sm input-bordered w-full" placeholder="Link Lainnya">
                                        <input name="ket_link_lainnya" type="text"
                                            value="{{ old('ket_link_lainnya', $agenda->ket_link_lainnya) }}"
                                            class="input input-xs input-ghost w-full"
                                            placeholder="Keterangan link lainnya...">
                                    </div>
                                </div>

                                <div class="divider text-xs opacity-50 uppercase tracking-widest">WiFi</div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input name="wifi_name" type="text"
                                        value="{{ old('wifi_name', $agenda->wifi_name) }}"
                                        class="input input-sm input-bordered w-full" placeholder="SSID">
                                    <input name="password_wifi" type="text"
                                        value="{{ old('password_wifi', $agenda->password_wifi) }}"
                                        class="input input-sm input-bordered w-full" placeholder="Password">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom buttons removed as they are now in the right sidebar --}}
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#editor').summernote({
                    tabsize: 2,
                    minHeight: 400,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onImageUpload: function(files) {
                            uploadImage(files[0]);
                        },
                        onMediaDelete: function(target) {
                            deleteImage(target[0].src);
                        }
                    }
                });

                function uploadImage(file) {
                    let data = new FormData();
                    data.append("file", file);
                    data.append("_token", "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{ route('editor.upload') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: "POST",
                        success: function(url) {
                            $('#editor').summernote('insertImage', url);
                        },
                        error: function(data) {
                            let response = data.responseJSON;
                            alert(response.error.message || "Gagal mengunggah gambar.");
                        }
                    });
                }

                function deleteImage(src) {
                    $.ajax({
                        data: {
                            src: src,
                            _token: "{{ csrf_token() }}"
                        },
                        type: "POST",
                        url: "{{ route('editor.delete') }}",
                        cache: false,
                        success: function(response) {
                            console.log(response.message);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-layout>
