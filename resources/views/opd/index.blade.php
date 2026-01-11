<x-layout title="Master OPD Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Master OPD</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data Organisasi Perangkat Daerah</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Setting</li>
                <li><a href="{{ route('opd.index') }}"><span class="text-base-content">Master OPD</span></a></li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Master OPD</div>
                    <div class="text-sm text-white opacity-80">Monitoring data Organisasi Perangkat Daerah</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total OPD</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['total_users'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Users</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['new_this_month'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Baru Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <!-- Total OPD -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium uppercase tracking-wider">
                                Total OPD</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Unit</span>
                            </div>
                        </div>
                        <div class="p-2 bg-primary/10 text-primary rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium uppercase tracking-wider">
                                Total Users</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['total_users'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Pegawai</span>
                            </div>
                        </div>
                        <div class="p-2 bg-info/10 text-info rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New OPD This Month -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium uppercase tracking-wider">OPD
                                Baru</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold text-success">{{ $stats['new_this_month'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Bulan ini</span>
                            </div>
                        </div>
                        <div class="p-2 bg-success/10 text-success rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Without Address -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium uppercase tracking-wider">
                                Tanpa Alamat</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span
                                    class="text-2xl font-bold text-warning">{{ $stats['without_address'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Perlu update</span>
                            </div>
                        </div>
                        <div class="p-2 bg-warning/10 text-warning rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008h-.008v-.008Z" />
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
                <form method="GET" action="{{ route('opd.index') }}" class="flex items-center gap-2">
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
                </form>
                <div class="relative w-full sm:w-auto">
                    <input id="opd-search-input" type="text" placeholder="Search OPD..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button type="button" id="opd-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/50">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div id="opd-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow z-10 hidden">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="join">
                @if (request()->hasAny(['q']))
                    <a href="{{ route('opd.index') }}" class="btn btn-outline btn-error join-item border-r-0"
                        title="Reset Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
            <a href="{{ route('opd.create') }}" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add OPD
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

    <!-- OPD Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Logo</th>
                            <th>Nama OPD</th>
                            <th>Singkatan</th>
                            <th>Alamat</th>
                            <th>Catatan</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opds as $opd)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($opds->currentPage() - 1) * $opds->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="avatar">
                                        <div class=" w-10 h-10 bg-transparent">
                                            <img src="{{ $opd->logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($opd->singkatan) . '&background=random' }}"
                                                alt="{{ $opd->name }}">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-bold text-sm">{{ $opd->name }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-sm badge-outline whitespace-nowrap">{{ $opd->singkatan }}
                                    </div>
                                </td>
                                <td class="text-sm max-w-xs truncate">{{ $opd->address_opd ?? '-' }}</td>
                                <td class="text-sm max-w-xs truncate">{{ $opd->catatan ?? '-' }}</td>
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
                                                <a href="{{ route('opd.edit', $opd) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="text-error"
                                                    data-delete-id="{{ $opd->id }}"
                                                    data-delete-name="{{ $opd->name }}">
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-sm text-base-content/60">Tidak ada data OPD
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-actions justify-between items-center p-4 border-t border-base-200">
            <div class="w-full">
                {!! $opds->appends(request()->query())->onEachSide(1)->links() !!}
            </div>
        </div>
    </div>

    @if (session('error'))
        <div id="error-toast" class="toast toast-bottom toast-end z-50 shadow-2xl">
            <div class="alert alert-error text-white font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <dialog id="delete-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2 text-error flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Konfirmasi Hapus
            </h3>
            <p class="text-sm text-base-content/70">Apakah Anda yakin ingin menghapus OPD <span id="delete-item-name"
                    class="font-bold text-base-content"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-action">
                <button type="button" class="btn" data-close="delete-modal">Batal</button>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-white">Ya, Hapus</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        (function() {
            const input = document.getElementById('opd-search-input');
            const box = document.getElementById('opd-search-suggestions');
            const clearBtn = document.getElementById('opd-search-clear');
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
                        '<span class="text-[10px] opacity-60">' + (i.singkatan ?? '') + '</span>' +
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
                fetch(`{{ route('opd.suggest') }}?q=` + encodeURIComponent(q), {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(d => {
                        const items = (d.data || []).map(o => ({
                            name: o.name,
                            singkatan: o.singkatan,
                            query: o.name || o.singkatan || q
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
            // Delete Modal
            const deleteButtons = document.querySelectorAll('[data-delete-id]');
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = document.getElementById('delete-form');
            const deleteItemName = document.getElementById('delete-item-name');

            function show(modal) {
                if (modal?.showModal) modal.showModal();
            }

            function closeByAttr() {
                document.querySelectorAll('button[data-close]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-close');
                        const dlg = document.getElementById(id);
                        if (dlg && dlg.close) dlg.close();
                    });
                });
            }

            closeByAttr();

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.deleteId;
                    const name = this.dataset.deleteName;
                    deleteItemName.textContent = name;
                    deleteForm.action = `{{ url('master-opd') }}/${id}`;
                    show(deleteModal);
                });
            });

            // Auto-hide success toast
            const successToast = document.getElementById('success-toast');
            if (successToast) {
                setTimeout(() => {
                    successToast.style.opacity = '0';
                    successToast.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => successToast.remove(), 500);
                }, 3000);
            }

            const errorToast = document.getElementById('error-toast');
            if (errorToast) {
                setTimeout(() => {
                    errorToast.style.opacity = '0';
                    errorToast.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => errorToast.remove(), 500);
                }, 8000);
            }
        })();
    </script>
</x-layout>
