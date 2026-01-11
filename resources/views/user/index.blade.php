<x-layout title="User Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">User Management</h1>
            <p class="text-sm text-base-content/60 mt-1">Manage users, roles, and permissions</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Settings</li>
                <li><a href="{{ route('users.index') }}"><span class="text-base-content">User Management</span></a></li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data User</div>
                    <div class="text-sm text-white opacity-80">Monitoring data pengguna dan status</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total User</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['active'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Aktif</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Total Pengguna</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Akun terdaftar</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14c3.866 0 7 1.343 7 3v1H5v-1c0-1.657 3.134-3 7-3z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 12a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Pengguna Disetujui</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['active'] ?? 0 }}</span>
                                <span class="text-xs text-success">Status aktif</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4" />
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Pengguna Belum Disetujui
                            </h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['pending'] ?? 0 }}</span>
                                <span class="text-xs text-warning">Status pending</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" class="w-6 h-6">
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 7v5l3 3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Pengguna Tidak Aktif</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['inactive'] ?? 0 }}</span>
                                <span class="text-xs text-error">Status inactive</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" class="w-6 h-6">
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 9l6 6M15 9l-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Actions Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="form-control">
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2">
                    <div class="join">
                        <span
                            class="btn btn-disabled join-item text-base-content pointer-events-none rounded-left-md">Show</span>
                        <select name="per_page" class="select join-item w-24 rounded-end-md"
                            onchange="this.form.submit()">
                            @php $pp = (int) request('per_page', 10); @endphp
                            <option value="10" @selected($pp === 10)>10</option>
                            <option value="20" @selected($pp === 20)>20</option>
                            <option value="50" @selected($pp === 50)>50</option>
                            <option value="100" @selected($pp === 100)>100</option>
                        </select>
                    </div>
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <input type="hidden" name="role" value="{{ request('role') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                </form>
                <div class="relative w-full sm:w-auto">
                    <input id="users-search-input" type="text" placeholder="Search users..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button type="button" id="users-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/50">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div id="users-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow z-10 hidden">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="join">
                @if (request()->hasAny(['q', 'role', 'status', 'sort']))
                    <a wire:navigate href="{{ route('users.index') }}"
                        class="btn btn-outline btn-error join-item border-r-0" title="Reset Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
                <button id="btn-filter" class="btn btn-outline join-item gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    Filter
                </button>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add User
            </a>
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

    <!-- Users Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Joined Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-base-200">
                                                <img src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                                    alt="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">{{ $user->name }}</div>
                                            <div class="text-xs opacity-50">{{ $user->email }}</div>
                                            @if ($user->opdMaster)
                                                <div class="text-[10px] badge badge-ghost badge-xs mt-1">
                                                    ({{ $user->opdMaster->singkatan }})
                                                    {{ $user->opdMaster->name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $role = $user->roles->first();
                                    @endphp
                                    <div class="badge badge-sm border-none text-white px-2 py-3 gap-1 whitespace-nowrap"
                                        style="background-color: {{ $role->color ?? '#64748b' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                        </svg>
                                        {{ $role->name ?? 'No Role' }}
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="badge {{ $user->status === 'active' ? 'badge-success' : ($user->status === 'pending' ? 'badge-warning' : 'badge-error') }} gap-1 text-white">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                        {{ $user->status ? ucfirst($user->status) : 'Inactive' }}
                                    </div>
                                </td>
                                <td class="text-sm">{{ optional($user->updated_at)->diffForHumans() }}</td>
                                <td class="text-sm">{{ optional($user->created_at)->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-left dropdown-end">
                                        <button class="btn btn-ghost btn-xs btn-square rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                            </svg>
                                        </button>
                                        <ul tabindex="0"
                                            class="dropdown-content menu p-2 shadow-md bg-base-100 glass rounded-box w-36">
                                            <li>
                                                <a wire:navigate href="{{ route('users.edit', $user) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="text-error"
                                                    data-delete-id="{{ $user->id }}"
                                                    data-delete-name="{{ $user->name }}">
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-sm text-base-content/60">Tidak ada data
                                    pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-actions justify-between items-center p-4 border-t border-base-200">
            <div class="w-full">
                {!! $users->appends(request()->query())->onEachSide(1)->links() !!}
            </div>
        </div>
    </div>
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
    <dialog id="delete-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-base-content/70">Apakah Anda yakin ingin menghapus user <span id="delete-user-name"
                    class="font-semibold"></span>?</p>
            <div class="modal-action">
                <button type="button" class="btn" data-close="delete-modal">Batal</button>
                <form id="delete-user-form" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">Hapus</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <dialog id="filter-modal" class="modal backdrop-blur-xs">
        <div class="modal-box shadow">
            <h3 class="font-bold text-lg mb-4">Filter Users</h3>
            <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label mb-2">
                            <span class="label-text">Role</span>
                        </label>
                        <select name="role" class="select select-bordered w-full">
                            <option value="">Semua Role</option>
                            @foreach ($roles ?? [] as $r)
                                <option value="{{ $r }}" @selected(($role ?? '') === $r)>{{ $r }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label mb-2">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select select-bordered w-full">
                            <option value="">Semua Status</option>
                            @php $statuses = ['active' => 'Active', 'pending' => 'Pending', 'inactive' => 'Inactive']; @endphp
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(($status ?? '') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="q" value="{{ $q ?? '' }}">
                <div class="modal-action">
                    <button type="button" class="btn" data-close="filter-modal">Batal</button>
                    <button type="submit" class="btn btn-secondary">Terapkan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <div class="fab fab-flower fab-bottom fab-end mb-12">
        <!-- a focusable div with tabindex is necessary to work on all browsers. role="button" is necessary for accessibility -->
        <div tabindex="0" role="button" class="btn btn-circle btn-lg btn-primary">
            <svg aria-label="New" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                class="size-6">
                <path
                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
            </svg>
        </div>

        <div class="fab-close">
            <span class="btn btn-circle btn-lg btn-error">✕</span>
        </div>

        <!-- buttons that show up when FAB is open -->
        <a wire:navigate href="{{ route('users.create') }}" class="tooltip btn btn-circle btn-lg btn-primary"
            id="fab-add-user" data-tip="Add User">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path
                    d="M5.25 6.375a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25V13.5a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
            </svg>
        </a>
    </div>

    <script>
        (function() {
            const input = document.getElementById('users-search-input');
            const box = document.getElementById('users-search-suggestions');
            const clearBtn = document.getElementById('users-search-clear');
            let timer = null;

            function hide() {
                box.classList.add('hidden');
                box.innerHTML = '';
            }

            function updateClear() {
                const has = input.value.trim().length > 0;
                if (has) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            }

            function show(items) {
                let html = '';
                if (!items.length) {
                    html = '<div class="p-3 text-sm text-base-content/60">Tidak ada data</div>';
                } else {
                    html = '<ul class="menu menu-sm w-full">' + items.map(i =>
                        '<li><button type="button" data-q="' + encodeURIComponent(i.query) + '">' +
                        '<div class="flex flex-col text-left">' +
                        '<span class="font-medium">' + (i.name ?? '') + '</span>' +
                        '<span class="text-[10px] opacity-60">' + [i.email, i.role, i.opd, i.status].filter(
                            Boolean).join(
                            ' • ') +
                        '</span>' +
                        '</div></button></li>'
                    ).join('') + '</ul>';
                }
                box.innerHTML = html;
                box.classList.remove('hidden');
            }

            function search(q) {
                if (!q) {
                    hide();
                    updateClear();
                    return;
                }
                fetch(`{{ route('users.suggest') }}?q=` + encodeURIComponent(q), {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(d => {
                        const items = (d.data || []).map(u => ({
                            name: u.name,
                            email: u.email,
                            role: u.role,
                            opd: u.opd,
                            status: u.status,
                            query: u.name || u.email || u.role || u.opd || u.status || q
                        }));
                        show(items);
                    })
                    .catch(() => show([]));
            }
            input.addEventListener('input', function() {
                clearTimeout(timer);
                const q = this.value.trim();
                timer = setTimeout(() => search(q), 200);
                updateClear();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    const q = this.value.trim();
                    if (q) {
                        const url = new URL(window.location.href);
                        url.searchParams.set('q', q);
                        window.location = url.toString();
                    }
                }
            });
            box.addEventListener('mousedown', function(e) {
                const btn = e.target.closest('button[data-q]');
                if (btn) {
                    const q = decodeURIComponent(btn.getAttribute('data-q'));
                    const url = new URL(window.location.href);
                    url.searchParams.set('q', q);
                    window.location = url.toString();
                }
            });
            document.addEventListener('click', function(e) {
                if (!box.contains(e.target) && e.target !== input) hide();
            });
            clearBtn.addEventListener('click', function() {
                input.value = '';
                hide();
                updateClear();
                const url = new URL(window.location.href);
                url.searchParams.delete('q');
                window.location = url.toString();
            });
            updateClear();
        })();
    </script>
    <script>
        (function() {
            const filterBtn = document.getElementById('btn-filter');
            const filterModal = document.getElementById('filter-modal');
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = document.getElementById('delete-user-form');
            const deleteNameEl = document.getElementById('delete-user-name');
            const successToast = document.getElementById('success-toast');
            const errorToast = document.getElementById('error-toast');

            function show(modal) {
                if (modal?.showModal) modal.showModal();
            }

            function closeByAttr(attr) {
                document.querySelectorAll('button[data-close]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-close');
                        const dlg = document.getElementById(id);
                        if (dlg && dlg.close) dlg.close();
                    });
                });
            }
            filterBtn.addEventListener('click', () => show(filterModal));
            closeByAttr();
            document.querySelectorAll('button[data-delete-id]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-delete-id');
                    const nm = this.getAttribute('data-delete-name') || '';
                    deleteForm.setAttribute('action', `{{ url('/users') }}/${id}`);
                    deleteNameEl.textContent = nm;
                    show(deleteModal);
                });
            });
            [successToast, errorToast].forEach(function(el) {
                if (!el) return;
                setTimeout(function() {
                    el.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => el.remove(), 500);
                }, 8000);
            });
        })();
    </script>
</x-layout>
