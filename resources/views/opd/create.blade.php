<x-layout title="Create OPD Master">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Create OPD Master</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah data Organisasi Perangkat Daerah baru</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('opd.index') }}">OPD Master</a></li>
                <li><span class="text-base-content">Create</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form id="opd-create-form" method="POST" action="{{ route('opd.store') }}" enctype="multipart/form-data"
                class="space-y-6" data-loading>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Nama OPD</span></label>
                        <input name="name" type="text" value="{{ old('name') }}"
                            class="input input-bordered w-full" placeholder="Contoh: Dinas Komunikasi dan Informatika">
                        @error('name')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Singkatan</span></label>
                        <input name="singkatan" type="text" value="{{ old('singkatan') }}"
                            class="input input-bordered w-full" placeholder="Contoh: DISKOMINFO">
                        @error('singkatan')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Alamat OPD (opsional)</span></label>
                        <textarea name="address_opd" class="textarea textarea-bordered w-full" rows="3"
                            placeholder="Masukkan alamat lengkap kantor OPD">{{ old('address_opd') }}</textarea>
                        @error('address_opd')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Catatan (opsional)</span></label>
                        <input name="catatan" type="text" value="{{ old('catatan') }}"
                            class="input input-bordered w-full" placeholder="Catatan tambahan">
                        @error('catatan')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div x-data="{
                    previewUrl: null,
                    isOver: false,
                    errorTitle: '',
                    errorMessage: '',
                    showError: false,
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                
                        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
                        if (!allowed.includes(file.type)) {
                            this.errorTitle = 'Format File Salah';
                            this.errorMessage = 'Silakan pilih gambar dengan format JPG, PNG, atau WEBP.';
                            this.showError = true;
                            e.target.value = '';
                            return;
                        }
                        if (file.size > 800 * 1024) {
                            this.errorTitle = 'Ukuran Gambar Terlalu Besar';
                            this.errorMessage = 'Maksimal ukuran gambar yang diperbolehkan adalah 800KB.';
                            this.showError = true;
                            e.target.value = '';
                            return;
                        }
                
                        this.previewUrl = URL.createObjectURL(file);
                    },
                    removePhoto() {
                        this.previewUrl = null;
                        document.getElementById('logo-input').value = '';
                    }
                }">
                    <!-- Error Modal -->
                    <template x-teleport="body">
                        <div x-show="showError" x-cloak class="modal modal-open">
                            <div class="modal-box border-t-4 border-error">
                                <div class="flex items-center gap-3 text-error mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <h3 class="font-bold text-lg" x-text="errorTitle"></h3>
                                </div>
                                <p class="text-base-content/70" x-text="errorMessage"></p>
                                <div class="modal-action">
                                    <button type="button" class="btn btn-error"
                                        @click="showError = false">Tutup</button>
                                </div>
                            </div>
                            <div class="modal-backdrop bg-black/40" @click="showError = false"></div>
                        </div>
                    </template>

                    <label class="label"><span class="label-text mb-2">Logo OPD (jpg, jpeg, png, webp; max
                            800KB)</span></label>
                    <div id="dropzone"
                        class="relative rounded-lg border-dashed border-2 p-6 min-h-45 transition-colors group"
                        :class="isOver ? 'border-primary bg-primary/5' : 'border-base-300 bg-base-200/50'"
                        @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                        @drop.prevent="isOver = false; $refs.logoInput.files = $event.dataTransfer.files; handleFile({target: $refs.logoInput})">

                        <input id="logo-input" x-ref="logoInput" name="logo_opd" type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile">

                        <!-- Preview -->
                        <div x-show="previewUrl" x-cloak
                            class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 rounded-lg p-4">
                            <div class="avatar mb-3 mt-2">
                                <div class="w-24 h-24">
                                    <img :src="previewUrl" alt="Preview">
                                </div>
                            </div>
                            <!-- Delete Button -->
                            <button type="button" @click.stop="removePhoto"
                                class="btn btn-error btn-outline btn-xs gap-2 z-20 mb-2" title="Hapus logo">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Hapus Logo</span>
                            </button>
                        </div>

                        <!-- Placeholder -->
                        <div x-show="!previewUrl"
                            class="flex flex-col items-center justify-center gap-3 text-base-content/60">
                            <img src="{{ asset('assets/images/illustrations/undraw_upload_cucu.svg') }}"
                                alt="Upload illustration" class="w-24 h-24">
                            <span>Drag & drop atau klik untuk pilih gambar</span>
                        </div>
                    </div>
                    @error('logo_opd')
                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('opd.index') }}" class="btn">Batal</a>
                    <button type="submit" class="btn btn-secondary">
                        <span class="loading loading-spinner loading-xs hidden"></span>
                        <span class="btn-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
