<x-layout title="Survei Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Survei Management</h1>
            <p class="text-sm text-base-content/60 mt-1">Manajemen survei dan pengumpulan aspirasi masyarakat</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Apps</li>
                <li><a href="{{ route('survey.index') }}"><span class="text-base-content">Survei Management</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Survei</div>
                    <div class="text-sm text-white opacity-80">Monitoring survei aktif dan visibilitas publik</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Survei</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['active'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Aktif</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['public'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Public</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['private'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Private</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('survey.index') }}"
                class="btn btn-sm {{ !request()->filled('visibility') && !request()->filled('q') ? 'btn-secondary' : 'btn-ghost bg-base-100' }}">
                Semua
                <div class="badge badge-sm">{{ $stats['total'] ?? 0 }}</div>
            </a>
            <a href="{{ route('survey.index', array_merge(request()->query(), ['visibility' => 'public'])) }}"
                class="btn btn-sm {{ request('visibility') == 'public' ? 'btn-primary' : 'btn-ghost bg-base-100 text-primary' }}">
                Public
                <div class="badge badge-sm badge-primary text-white">{{ $stats['public'] ?? 0 }}</div>
            </a>
            <a href="{{ route('survey.index', array_merge(request()->query(), ['visibility' => 'private'])) }}"
                class="btn btn-sm {{ request('visibility') == 'private' ? 'btn-error' : 'btn-ghost bg-base-100 text-error' }}">
                Private
                <div class="badge badge-sm badge-error text-white">{{ $stats['private'] ?? 0 }}</div>
            </a>
        </div>
        <div class="flex gap-2">
            @can('add-survey')
                <a href="{{ route('survey.create') }}" class="btn btn-neutral gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Survey
                </a>
            @endcan
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="form-control">
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form method="GET" action="{{ route('survey.index') }}" class="flex items-center gap-2">
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
                    <input type="hidden" name="visibility" value="{{ request('visibility') }}">
                </form>
                <div class="relative w-full sm:w-auto">
                    <input id="survey-search-input" type="text" placeholder="Cari Survei..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button type="button" id="survey-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/50 {{ request('q') ? '' : 'hidden' }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div id="survey-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow-lg z-10 hidden border border-base-200">
                    </div>
                </div>
            </div>
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
        <script>
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

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

    <!-- Surveys Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Survei</th>
                            <th>Periode</th>
                            <th>OPD Penyelenggara</th>
                            <th>Status / Visibility</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surveys as $survey)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($surveys->currentPage() - 1) * $surveys->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="font-bold text-base">{{ $survey->title }}</div>
                                    <div class="text-xs text-base-content/60 mt-0.5 line-clamp-1">
                                        {{ Str::limit($survey->description, 50) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="badge badge-sm badge-ghost">Mulai</span>
                                            <span>{{ $survey->start_date->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-error font-medium">
                                            <span class="badge badge-sm badge-error text-white">Selesai</span>
                                            <span>{{ $survey->end_date->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if ($survey->opd->logo_opd)
                                            <div class="avatar">
                                                <div class="w-8 h-8 rounded-lg">
                                                    <img src="{{ Storage::url($survey->opd->logo_opd) }}"
                                                        alt="{{ $survey->opd->singkatan }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content w-8 h-8 rounded-lg">
                                                    <span
                                                        class="text-xs">{{ substr($survey->opd->singkatan, 0, 2) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-xs">{{ $survey->opd->singkatan }}</div>
                                            <div class="text-[10px] text-base-content/60">
                                                {{ Str::limit($survey->opd->name, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <div class="badge {{ $survey->status_badge_class }} badge-sm font-medium">
                                            {{ $survey->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <div
                                                class="badge {{ $survey->visibility_status['class'] }} badge-sm font-medium">
                                                {{ $survey->visibility_status['label'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-1">
                                        @can('view-survey-result')
                                            <a href="{{ route('survey.results', $survey) }}"
                                                class="btn btn-square btn-sm btn-ghost text-primary tooltip"
                                                data-tip="Lihat Hasil">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V19.875c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                                </svg>
                                            </a>
                                        @endcan
                                        @if ($survey->visibility === 'private' && $survey->tokens->count() > 0)
                                            <button class="btn btn-square btn-sm btn-ghost text-neutral tooltip"
                                                data-tip="Copy Private Link"
                                                onclick="copyText('{{ route('survey.private_access', $survey->tokens->first()->token) }}', this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </button>
                                        @elseif($survey->visibility === 'public')
                                            <button class="btn btn-square btn-sm btn-ghost text-secondary tooltip"
                                                data-tip="Copy Public Link"
                                                onclick="copyText('{{ route('survey.public_detail', $survey->id) }}', this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                </svg>
                                            </button>
                                        @endif
                                        @can('edit-survey')
                                            <a href="{{ route('survey.edit', $survey) }}"
                                                class="btn btn-square btn-sm btn-ghost text-info tooltip" data-tip="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('delete-survey')
                                            <button onclick="delete_modal_{{ $survey->id }}.showModal()"
                                                class="btn btn-square btn-sm btn-ghost text-error tooltip"
                                                data-tip="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>

                                            </button>

                                            <dialog id="delete_modal_{{ $survey->id }}" class="modal">
                                                <div class="modal-box">
                                                    <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
                                                    <p class="py-4">Apakah Anda yakin ingin menghapus survei
                                                        <strong>{{ $survey->title }}</strong>? Data yang dihapus tidak
                                                        dapat dikembalikan.
                                                    </p>
                                                    <div class="modal-action">
                                                        <form method="dialog">
                                                            <button class="btn btn-ghost">Batal</button>
                                                        </form>
                                                        <form action="{{ route('survey.destroy', $survey) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-error text-white">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada survei ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $surveys->links() }}
    </div>

    @push('scripts')
        <script>
            function copyText(text, btn) {
                navigator.clipboard.writeText(text).then(() => {
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    `;
                    btn.classList.add('text-success');

                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('text-success');
                    }, 2000);
                });
            }

            (function() {
                const input = document.getElementById('survey-search-input');
                const box = document.getElementById('survey-search-suggestions');
                const clearBtn = document.getElementById('survey-search-clear');
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
                        html = '<ul class="menu menu-sm w-full p-2">' + items.map(i =>
                            '<li><button type="button" class="w-full text-left flex flex-col items-start gap-1" data-q="' +
                            encodeURIComponent(i.title) + '">' +
                            '<span class="font-medium text-sm">' + i.title + '</span>' +
                            '<span class="text-[10px] opacity-60">' +
                            i.opd + ' • ' + i.visibility.toUpperCase() +
                            '</span>' +
                            '</button></li>'
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
                    fetch(`{{ route('survey.suggest') }}?q=` + encodeURIComponent(q), {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(r => r.json())
                        .then(d => {
                            const items = (d.data || []).map(s => ({
                                title: s.title,
                                opd: s.opd,
                                visibility: s.visibility,
                                is_active: s.is_active
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
                            window.location.href = url.toString();
                        }
                    }
                });

                clearBtn.addEventListener('click', function() {
                    input.value = '';
                    updateClear();
                    hide();
                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.location.href = url.toString();
                });

                box.addEventListener('click', function(e) {
                    const btn = e.target.closest('button[data-q]');
                    if (btn) {
                        const q = decodeURIComponent(btn.getAttribute('data-q'));
                        input.value = q;
                        const url = new URL(window.location.href);
                        url.searchParams.set('q', q);
                        window.location.href = url.toString();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!input.contains(e.target) && !box.contains(e.target)) {
                        hide();
                    }
                });
            })();

            // Toast handler
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endpush
</x-layout>
