<x-layout title="Master Pakaian Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Pakaian</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data pakaian</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Master Pakaian</li>
                <li><a href="{{ route('pakaian.index') }}"><span class="text-base-content">Pakaian</span></a></li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Pakaian</div>
                    <div class="text-sm text-white opacity-80">Monitoring data pakaian sistem</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Pakaian</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['total_kategori'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Kategori</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="form-control">
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form method="GET" action="{{ route('pakaian.index') }}" class="flex items-center gap-2">
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
                    <input id="pakaian-search-input" type="text" placeholder="Search Pakaian..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button type="button" id="pakaian-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/50 {{ !request('q') ? 'hidden' : '' }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div id="pakaian-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow z-10 hidden">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pakaian.create') }}" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Pakaian
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

    <!-- Pakaian Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-center w-16">#</th>
                            <th>Kategori Pakaian</th>
                            <th>Contoh Pakaian</th>
                            <th class="text-center w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pakaians as $pakaian)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($pakaians->currentPage() - 1) * $pakaians->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="badge badge-outline">{{ $pakaian->kategoriPakaian->name }}</div>
                                </td>
                                <td>
                                    <div class="font-bold text-sm">{{ $pakaian->contoh_pakaian }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown dropdown-left dropdown-end">
                                        <button class="btn btn-ghost btn-xs btn-square rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                            </svg>
                                        </button>
                                        <ul tabindex="0"
                                            class="dropdown-content menu p-2 shadow-md bg-base-100 glass rounded-box w-36">
                                            <li>
                                                <a href="{{ route('pakaian.edit', $pakaian->uuid) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="text-error"
                                                    onclick="delete_modal.showModal(); document.getElementById('delete-item-name').innerText = '{{ $pakaian->contoh_pakaian }}'; document.getElementById('delete-form').action = '{{ route('pakaian.destroy', $pakaian->uuid) }}';">
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-sm text-base-content/60">Tidak ada data
                                    Pakaian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($pakaians->hasPages())
            <div class="card-actions justify-between items-center p-4 border-t border-base-200">
                <div class="w-full">
                    {!! $pakaians->appends(request()->query())->onEachSide(1)->links() !!}
                </div>
            </div>
        @endif
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
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2 text-error flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Konfirmasi Hapus
            </h3>
            <p class="text-sm text-base-content/70">Apakah Anda yakin ingin menghapus Pakaian <span
                    id="delete-item-name" class="font-bold text-base-content"></span>? Tindakan ini tidak dapat
                dibatalkan.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Batal</button>
                </form>
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
            const input = document.getElementById('pakaian-search-input');
            const box = document.getElementById('pakaian-search-suggestions');
            const clearBtn = document.getElementById('pakaian-search-clear');
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
                    html = '<div class="p-3 text-sm text-base-content/50 italic">No pakaian found</div>';
                } else {
                    html = '<ul class="menu p-2">';
                    items.forEach(item => {
                        html +=
                            `<li><a href="{{ route('pakaian.index') }}?q=${encodeURIComponent(item.name)}">${item.name}</a></li>`;
                    });
                    html += '</ul>';
                }
                box.innerHTML = html;
                box.classList.remove('hidden');
            }

            input.addEventListener('input', () => {
                updateClear();
                clearTimeout(timer);
                const q = input.value.trim();
                if (q.length < 1) return hide();

                timer = setTimeout(() => {
                    fetch(`{{ route('pakaian.suggest') }}?q=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(res => show(res.data || []))
                        .catch(hide);
                }, 300);
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    const q = input.value.trim();
                    const url = new URL(window.location.href);
                    if (q) url.searchParams.set('q', q);
                    else url.searchParams.delete('q');
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                }
            });

            clearBtn.addEventListener('click', () => {
                input.value = '';
                updateClear();
                hide();
                const url = new URL(window.location.href);
                url.searchParams.delete('q');
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            });

            document.addEventListener('click', (e) => {
                if (!input.contains(e.target) && !box.contains(e.target)) hide();
            });

            // Handle success toast timeout
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if (toast) toast.remove();
                const errorToast = document.getElementById('error-toast');
                if (errorToast) errorToast.remove();
            }, 3000);
        })();
    </script>
</x-layout>
