<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">User Profile</h1>
            <p class="text-sm text-base-content/60 mt-1">Halaman profil pengguna</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><span class="text-base-content">Profile</span></li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div id="success-toast" class="toast toast-top toast-end z-50 shadow-2xl rounded-xl">
            <div class="alert glass backdrop-blur-lg border border-primary text-secondary font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="error-toast" class="toast toast-bottom toast-end z-50 shadow-2xl">
            <div class="alert alert-primary border border-error text-error font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2v6m0-6V4m0 0L3 10m7-6l7 6" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="space-y-6" x-data="{
        activeTab: localStorage.getItem('profile_active_tab') || 'profile',
        switchTab(tab) {
            this.activeTab = tab;
            localStorage.setItem('profile_active_tab', tab);
        }
    }">
        <!-- Profile Header Section -->
        <div class="card bg-base-100 shadow overflow-hidden border border-base-200">
            <!-- Banner -->
            <div class="h-48 md:h-50 relative group">
                @if ($banner)
                    <img src="{{ $banner->temporaryUrl() }}" class="w-full h-full object-cover" alt="Banner Preview">
                @elseif($current_banner_url && !$remove_banner)
                    <img src="{{ $current_banner_url }}" class="w-full h-full object-cover" alt="Banner">
                @else
                    <div class="w-full h-full bg-linear-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                @endif
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-all"></div>

                <!-- Banner Action Button -->
                <button type="button" @click="document.getElementById('banner-input').click()"
                    class="absolute bottom-4 right-4 btn btn-circle btn-sm btn-primary border-white/20 shadow-lg opacity-0 group-hover:opacity-100 transition-all hover:scale-110 active:scale-95 z-30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </button>
            </div>

            <!-- Profile Info Overlap -->
            <div class="px-6 pb-6 relative">
                <div class="flex flex-col md:flex-row items-center md:items-end -mt-16 md:-mt-22 gap-4 md:gap-6">
                    <!-- Avatar -->
                    <div class="relative group self-center md:self-auto">
                        <div class="avatar">
                            <div
                                class="w-32 h-32 md:w-40 md:h-40 rounded-2xl ring ring-base-100 ring-offset-base-100 ring-offset-4 shadow-xl overflow-hidden bg-base-200">
                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview">
                                @elseif($current_photo_url && !$remove_photo)
                                    <img src="{{ $current_photo_url }}" alt="Profile">
                                @else
                                    <div
                                        class="flex items-center justify-center w-full h-full text-4xl font-bold uppercase text-base-content/20">
                                        {{ substr($name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Name & Quick Info -->
                    <div class="flex-1 text-center md:text-left pt-2 md:pt-0">
                        <div class="flex flex-col md:flex-row items-center gap-3 justify-center md:justify-start">
                            <h2 class="text-xl md:text-2xl font-bold">
                                {{ $name }}
                            </h2>
                        </div>
                        <div
                            class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 mt-3 text-sm text-base-content/60">
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <span>{{ $roles ?: 'User' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span>{{ $address ?: 'No Address' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span>Joined {{ $joined_at }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4 md:mt-0">
                        <div class="badge badge-base-300 p-4 gap-2 shadow">
                            <div class="w-2 h-2 rounded-full bg-secondary animate-pulse"></div>
                            Active Profile
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="px-6 border-t border-base-200">
                <div role="tablist" class="tabs tabs-bordered overflow-x-auto no-scrollbar py-2">
                    <a role="tab" @click="switchTab('profile')"
                        :class="{ 'tab-active': activeTab === 'profile' }"
                        class="tab font-medium flex items-center gap-2 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Profile
                    </a>
                    @can('setting-app')
                        <a role="tab" @click="switchTab('settings')"
                            :class="{ 'tab-active': activeTab === 'settings' }"
                            class="tab font-medium flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Settings
                        </a>
                    @endcan
                    <a role="tab"
                        class="tab font-medium flex items-center gap-2 whitespace-nowrap opacity-50 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Teams
                    </a>
                    <a role="tab"
                        class="tab font-medium flex items-center gap-2 whitespace-nowrap opacity-50 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                        </svg>
                        Projects
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-show="activeTab === 'profile'">
            <!-- Left Column: About & Settings -->
            <div class="lg:col-span-1 space-y-6">
                <!-- About Card -->
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-base-content/40 mb-4">About</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-base-content/50">Full Name</div>
                                    <div class="text-sm font-medium">{{ $name }}</div>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-base-content/50">Email Address</div>
                                    <div class="text-sm font-medium">{{ $email }}</div>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center text-accent shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-base-content/50">Phone Number</div>
                                    <div class="text-sm font-medium">{{ $phone ?: '-' }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-base-content/40 mb-4">Account Status
                        </h3>
                        <div class="flex items-center gap-3">
                            <div class="badge badge-success badge-sm"></div>
                            <span class="text-sm font-medium">Active Account</span>
                        </div>
                        <p class="text-xs text-base-content/50 mt-2">Akun Anda aktif dan memiliki akses penuh ke fitur
                            Monetra.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Edit Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg">Edit Profile Information</h3>
                            <span class="text-xs text-base-content/50 italic">Perbarui data diri Anda di bawah
                                ini</span>
                        </div>

                        <form wire:submit.prevent="updateProfile" class="space-y-6" data-loading>
                            <!-- Photo Upload Section -->
                            <div x-data="{
                                previewUrl: '{{ $current_photo_url }}',
                                isRemoved: @entangle('remove_photo'),
                                isOver: false,
                                handleFile(e) {
                                    const file = e.target.files[0];
                                    if (!file) return;
                                    if (file.size > 800 * 1024) {
                                        alert('Ukuran file maksimal 800KB');
                                        return;
                                    }
                                    this.previewUrl = URL.createObjectURL(file);
                                    this.isRemoved = false;
                                }
                            }" class="space-y-3">
                                <label class="label p-0"><span class="label-text font-semibold">Profile
                                        Photo</span></label>
                                <div id="dropzone"
                                    class="relative rounded-xl border-dashed border-2 p-8 min-h-48 transition-all group flex flex-col items-center justify-center text-center"
                                    :class="isOver ? 'border-primary bg-primary/5 scale-[0.99]' :
                                        'border-base-300 bg-base-50 hover:bg-base-100'"
                                    @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                                    @drop.prevent="isOver = false; $refs.photoInput.files = $event.dataTransfer.files; handleFile({target: $refs.photoInput})">

                                    <input type="hidden" name="remove_photo" :value="isRemoved ? '1' : '0'">
                                    <input id="photo-input" x-ref="photoInput" wire:model="photo" type="file"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="handleFile">

                                    <!-- Preview Overlay -->
                                    <div x-show="previewUrl && !isRemoved" x-cloak
                                        class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 rounded-xl p-4 z-20">
                                        <div class="avatar mb-4">
                                            <div
                                                class=" card w-24 h-24 ring ring-base-100 ring-offset-base-100 ring-offset-2">
                                                <img :src="previewUrl" alt="Preview">
                                            </div>
                                        </div>
                                        <button type="button"
                                            @click.stop="isRemoved = true; previewUrl = null; $wire.set('photo', null)"
                                            class="btn btn-error btn-outline btn-sm gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Hapus Foto
                                        </button>
                                    </div>

                                    <!-- Placeholder -->
                                    <div
                                        class="flex flex-col items-center gap-3 text-base-content/40 group-hover:text-primary transition-colors">
                                        <div
                                            class="w-16 h-16 rounded-full bg-base-200 flex items-center justify-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A4.523 4.523 0 0 1 18.75 18.75h-1.875" />
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium">Klik atau tarik gambar ke sini</div>
                                        <div class="text-xs">JPG, PNG, WebP (Maks. 800KB)</div>
                                    </div>
                                </div>
                                @error('photo')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Banner Upload Section -->
                            <div x-data="{
                                previewUrl: '{{ $current_banner_url }}',
                                isRemoved: @entangle('remove_banner'),
                                isOver: false,
                                handleFile(e) {
                                    const file = e.target.files[0];
                                    if (!file) return;
                                    if (file.size > 2048 * 1024) {
                                        alert('Ukuran file maksimal 2MB');
                                        return;
                                    }
                                    this.previewUrl = URL.createObjectURL(file);
                                    this.isRemoved = false;
                                }
                            }" class="space-y-3">
                                <label class="label p-0"><span class="label-text font-semibold">Profile
                                        Banner</span></label>
                                <div class="relative rounded-xl border-dashed border-2 p-4 min-h-32 transition-all group flex flex-col items-center justify-center text-center overflow-hidden"
                                    :class="isOver ? 'border-primary bg-primary/5 scale-[0.99]' :
                                        'border-base-300 bg-base-50 hover:bg-base-100'"
                                    @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                                    @drop.prevent="isOver = false; $refs.bannerInput.files = $event.dataTransfer.files; handleFile({target: $refs.bannerInput})">

                                    <input id="banner-input" x-ref="bannerInput" wire:model="banner" type="file"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="handleFile">

                                    <!-- Preview Overlay -->
                                    <div x-show="previewUrl && !isRemoved" x-cloak
                                        class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 z-20">
                                        <img :src="previewUrl"
                                            class="absolute inset-0 w-full h-full object-cover opacity-50">
                                        <div class="relative z-30">
                                            <button type="button"
                                                @click.stop="isRemoved = true; previewUrl = null; $wire.set('banner', null)"
                                                class="btn btn-error btn-outline btn-sm gap-2 glass">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus Banner
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Placeholder -->
                                    <div
                                        class="flex flex-col items-center gap-2 text-base-content/40 group-hover:text-primary transition-colors">
                                        <div
                                            class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium">Klik atau tarik banner ke sini</div>
                                        <div class="text-xs">Rekomendasi 1200x400px (Maks. 2MB)</div>
                                    </div>
                                </div>
                                @error('banner')
                                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-control">
                                    <label class="label"><span
                                            class="label-text font-semibold mb-1">Name</span></label>
                                    <input wire:model="name" type="text"
                                        class="input input-bordered w-full focus:input-primary transition-all">
                                    @error('name')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label"><span
                                            class="label-text font-semibold mb-1">Email</span></label>
                                    <input wire:model="email" type="email"
                                        class="input input-bordered w-full focus:input-primary transition-all">
                                    @error('email')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control" x-data="{ showPassword: false }">
                                    <label class="label"><span
                                            class="label-text font-semibold mb-1">Password</span></label>
                                    <div class="relative">
                                        <input wire:model="password" :type="showPassword ? 'text' : 'password'"
                                            class="input input-bordered w-full pr-12 focus:input-primary transition-all"
                                            minlength="6" placeholder="••••••••">
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-0 top-0 h-full px-4 text-base-content/30 hover:text-primary transition-colors">
                                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="label-text-alt mt-1 text-base-content/40">Biarkan kosong jika tidak
                                        ingin diubah</span>
                                    @error('password')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label"><span
                                            class="label-text font-semibold mb-1">Phone</span></label>
                                    <input wire:model="phone" type="text"
                                        class="input input-bordered w-full focus:input-primary transition-all"
                                        placeholder="+62...">
                                    @error('phone')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="md:col-span-2 form-control">
                                    <label class="label"><span
                                            class="label-text font-semibold mb-1">Address</span></label>
                                    <textarea wire:model="address" class="textarea textarea-bordered w-full focus:textarea-primary transition-all"
                                        rows="2" placeholder="Alamat lengkap..."></textarea>
                                    @error('address')
                                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="btn btn-secondary btn-wide shadow-lg shadow-secondary/20">
                                    <span wire:loading wire:target="updateProfile"
                                        class="loading loading-spinner loading-xs"></span>
                                    <span wire:loading.remove wire:target="updateProfile"
                                        class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                        </svg>
                                        Simpan Perubahan
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Activity Timeline (Mockup from image) -->
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="font-bold text-lg">Activity Timeline</h3>
                        </div>

                        <div
                            class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-linear-to-b before:from-transparent before:via-base-300 before:to-transparent">
                            <!-- Timeline Item 1 -->
                            <div
                                class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-secondary text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                    <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                                </div>
                                <div
                                    class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl bg-base-50 border border-base-200 ml-4 md:ml-0 shadow-sm">
                                    <div class="flex items-center justify-between space-x-2 mb-1">
                                        <div class="font-bold text-sm">Profile updated</div>
                                        <time class="text-xs text-base-content/40">Today</time>
                                    </div>
                                    <div class="text-xs text-base-content/60">You have updated your profile information
                                        successfully.</div>
                                </div>
                            </div>

                            <!-- Timeline Item 2 -->
                            <div
                                class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-success shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                </div>
                                <div
                                    class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl bg-base-50 border border-base-200 ml-4 md:ml-0 shadow-sm">
                                    <div class="flex items-center justify-between space-x-2 mb-1">
                                        <div class="font-bold text-sm">Logged in</div>
                                        <time class="text-xs text-base-content/40">2 hours ago</time>
                                    </div>
                                    <div class="text-xs text-base-content/60">System login detected from Chrome on
                                        MacOS.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('setting-app')
            <div x-show="activeTab === 'settings'" x-cloak>
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-bold text-lg">Application Settings</h3>
                                <p class="text-xs text-base-content/50 italic">Kelola identitas dan tampilan aplikasi
                                    Anda</p>
                            </div>
                        </div>
                        <livewire:app-setting-manager />
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const successToast = document.getElementById('success-toast');
            const errorToast = document.getElementById('error-toast');

            [successToast, errorToast].forEach(function(el) {
                if (!el) return;
                setTimeout(function() {
                    el.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => el.remove(), 500);
                }, 8000);
            });
        });
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>
