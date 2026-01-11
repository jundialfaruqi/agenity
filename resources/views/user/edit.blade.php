<x-layout title="Edit User">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Edit User</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data pengguna</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li><span class="text-base-content">Edit</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form id="user-edit-form" method="POST" action="{{ route('users.update', $user) }}"
                enctype="multipart/form-data" class="space-y-6" data-loading>
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Name</span></label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="input input-bordered w-full">
                        @error('name')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Email</span></label>
                        <input name="email" type="email" value="{{ old('email', $user->email) }}"
                            class="input input-bordered w-full">
                        @error('email')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div x-data="{ showPassword: false }">
                        <label class="label"><span class="label-text mb-2">Password (kosongkan jika tidak ingin
                                diubah)</span></label>
                        <div class="relative">
                            <input name="password" :type="showPassword ? 'text' : 'password'"
                                class="input input-bordered w-full pr-12" minlength="6" placeholder="••••">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-0 top-0 h-full px-4 text-base-content/50 hover:text-base-content transition-colors">
                                <!-- Eye Icon (Show) -->
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <!-- Eye Slash Icon (Hide) -->
                                <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Status</span></label>
                        <select name="status" class="select select-bordered w-full">
                            <option value="active" @selected(old('status', $user->status) === 'active')>Active</option>
                            <option value="pending" @selected(old('status', $user->status) === 'pending')>Pending</option>
                            <option value="inactive" @selected(old('status', $user->status) === 'inactive')>Inactive</option>
                        </select>
                        @error('status')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Role</span></label>
                        <select name="role" class="select select-bordered w-full">
                            <option value="">Tidak ada</option>
                            @foreach ($roles ?? [] as $r)
                                <option value="{{ $r }}" @selected(old('role', $user->getRoleNames()->first()) === $r)>{{ $r }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Phone (opsional)</span></label>
                        <input name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                            class="input input-bordered w-full">
                        @error('phone')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div x-data="{
                        open: false,
                        search: '',
                        results: [],
                        selected: {{ $user->opdMaster
                            ? json_encode([
                                'id' => $user->opdMaster->id,
                                'name' => $user->opdMaster->name,
                                'singkatan' => $user->opdMaster->singkatan,
                                'logo_url' =>
                                    $user->opdMaster->logo_url ?:
                                    'https://ui-avatars.com/api/?name=' .
                                        urlencode($user->opdMaster->singkatan) .
                                        '&color=7F9CF5&background=EBF4FF',
                            ])
                            : 'null' }},
                        loading: false,
                    
                        async init() {
                            // Fetch default results on init
                            this.fetchResults();
                    
                            // Handle old input after validation error
                            const oldId = '{{ old('opd_master_id') }}';
                            if (oldId && (!this.selected || this.selected.id != oldId)) {
                                try {
                                    const res = await fetch(`/master-opd/suggest?id=${oldId}`);
                                    const json = await res.json();
                                    if (json.data && json.data.length > 0) {
                                        this.selected = json.data[0];
                                    }
                                } catch (e) {
                                    console.error('Error fetching old OPD:', e);
                                }
                            }
                        },
                    
                        async fetchResults() {
                            this.loading = true;
                            try {
                                const res = await fetch(`/master-opd/suggest?q=${encodeURIComponent(this.search)}`);
                                const json = await res.json();
                                this.results = json.data;
                            } catch (e) {
                                console.error(e);
                            } finally {
                                this.loading = false;
                            }
                        },
                    
                        selectOpd(opd) {
                            this.selected = opd;
                            this.open = false;
                            this.search = '';
                        },
                    
                        toggleModal() {
                            this.open = !this.open;
                            if (this.open && this.results.length === 0) {
                                this.fetchResults();
                            }
                        }
                    }">
                        <label class="label"><span class="label-text mb-2">OPD</span></label>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="opd_master_id" :value="selected ? selected.id : ''">

                        <!-- Trigger Button / Display -->
                        <div class="relative">
                            <button type="button" @click="toggleModal()"
                                class="flex items-center justify-between w-full px-4 py-3 bg-base-200 hover:bg-base-300 rounded-lg transition-colors border border-base-300 dark:border-white/20"
                                :class="selected ? 'border-primary/30' : ''">
                                <div class="flex items-center gap-3">
                                    <template x-if="selected">
                                        <div class="flex items-center gap-3 text-left">
                                            <div class="avatar">
                                                <div class="w-8 h-8 rounded-lg">
                                                    <img :src="selected.logo_url" :alt="selected.name">
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <div class="text-sm font-bold leading-tight"
                                                    x-text="selected.singkatan"></div>
                                                <div class="text-[10px] opacity-60 truncate max-w-37.5"
                                                    x-text="selected.name"></div>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!selected">
                                        <div class="flex items-center gap-3 text-base-content/50">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-base-300 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                            </div>
                                            <span class="text-sm">Pilih OPD...</span>
                                        </div>
                                    </template>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Picker -->
                        <template x-teleport="body">
                            <div x-show="open" x-cloak class="modal modal-open">
                                <div
                                    class="modal-box p-0 overflow-hidden max-w-lg border border-base-300 shadow-2xl bg-base-100">
                                    <!-- Search Header -->
                                    <div class="p-4 border-b border-base-200 bg-base-200/30">
                                        <div class="relative">
                                            <input type="text" x-model="search"
                                                @input.debounce.300ms="fetchResults"
                                                placeholder="Cari nama atau singkatan OPD..."
                                                class="input input-bordered w-full pl-12 focus:ring-2 focus:ring-primary/20"
                                                autofocus>
                                            <div class="absolute left-4 top-1/2 -translate-y-1/2">
                                                <template x-if="!loading">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 opacity-40">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                    </svg>
                                                </template>
                                                <template x-if="loading">
                                                    <span class="loading loading-spinner loading-xs opacity-50"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Results List -->
                                    <div class="max-h-100 overflow-y-auto p-2 space-y-1">
                                        <template x-if="results.length === 0 && !loading">
                                            <div class="p-8 text-center opacity-50">
                                                <div class="mb-2 flex justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-12 h-12">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                                    </svg>
                                                </div>
                                                <p>Tidak ada OPD ditemukan</p>
                                            </div>
                                        </template>

                                        <template x-for="opd in results" :key="opd.id">
                                            <button type="button" @click="selectOpd(opd)"
                                                class="flex items-center gap-4 w-full p-3 rounded-xl hover:bg-primary/5 hover:text-primary text-left transition-all group border border-transparent"
                                                :class="selected && selected.id === opd.id ?
                                                    'bg-primary/10 text-primary border-primary/20' :
                                                    'hover:border-primary/20'">
                                                <div class="avatar">
                                                    <div class="w-12 h-12 rounded-xl shadow-sm border border-base-200 group-hover:border-primary/30 transition-colors bg-white"
                                                        :class="selected && selected.id === opd.id ? 'border-primary/30' : ''">
                                                        <img :src="opd.logo_url" :alt="opd.name"
                                                            class="p-1 object-contain">
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-bold truncate" x-text="opd.singkatan"></div>
                                                    <div class="text-xs opacity-60 truncate" x-text="opd.name"></div>
                                                </div>
                                                <div :class="selected && selected.id === opd.id ? 'opacity-100' :
                                                    'opacity-0 group-hover:opacity-100'"
                                                    class="transition-opacity">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </template>
                                    </div>

                                    <!-- Footer -->
                                    <div class="p-4 border-t border-base-200 flex justify-end bg-base-200/30">
                                        <button type="button" class="btn btn-ghost btn-sm"
                                            @click="open = false">Tutup</button>
                                    </div>
                                </div>
                                <div class="backdrop-blur-sm" @click="open = false"></div>
                            </div>
                        </template>

                        @error('opd_master_id')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="label"><span class="label-text mb-2">Address (opsional)</span></label>
                        <textarea name="address" class="textarea textarea-bordered w-full min-h-14.5 leading-tight py-3" rows="1">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div x-data="{
                    previewUrl: '{{ $user->photo_url }}',
                    isRemoved: false,
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
                        this.isRemoved = false;
                    },
                    removePhoto() {
                        this.previewUrl = null;
                        this.isRemoved = true;
                        document.getElementById('photo-input').value = '';
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

                    <label class="label"><span class="label-text mb-2">Photo (jpg, jpeg, png, webp; max
                            800KB)</span></label>
                    <div id="dropzone"
                        class="relative rounded-lg border-dashed border-2 p-6 min-h-45 transition-colors group"
                        :class="isOver ? 'border-primary bg-primary/5' : 'border-base-300 bg-base-200/50'"
                        @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                        @drop.prevent="isOver = false; $refs.photoInput.files = $event.dataTransfer.files; handleFile({target: $refs.photoInput})">

                        <input type="hidden" name="remove_photo" :value="isRemoved ? '1' : '0'">
                        <input id="photo-input" x-ref="photoInput" name="photo" type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile">

                        <!-- Preview -->
                        <div x-show="previewUrl && !isRemoved" x-cloak
                            class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 rounded-lg p-4">
                            <div class="avatar mb-3 mt-4">
                                <div class="mask mask-squircle w-24 h-24">
                                    <img :src="previewUrl" alt="Preview">
                                </div>
                            </div>
                            <!-- Delete Button -->
                            <button type="button" @click.stop="removePhoto"
                                class="btn btn-error btn-outline btn-xs gap-2 z-20 mb-4" title="Hapus foto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Hapus Foto</span>
                            </button>
                        </div>

                        <!-- Placeholder -->
                        <div x-show="!previewUrl || isRemoved"
                            class="flex flex-col items-center justify-center gap-3 text-base-content/60">
                            <img src="{{ asset('assets/images/illustrations/undraw_upload_cucu.svg') }}"
                                alt="Upload illustration" class="w-24 h-24">
                            <span>Drag & drop atau klik untuk pilih gambar</span>
                        </div>
                    </div>
                    @error('photo')
                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('users.index') }}" class="btn">Batal</a>
                    <button type="submit" class="btn btn-secondary">
                        <span class="loading loading-spinner loading-xs hidden"></span>
                        <span class="btn-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
