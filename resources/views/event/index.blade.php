<x-layout title="Event Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Event Management</h1>
            <p class="text-sm text-base-content/60 mt-1">Manajemen event dan kegiatan OPD</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Apps</li>
                <li><a href="{{ route('event.index') }}"><span class="text-base-content">Event Management</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Event</div>
                    <div class="text-sm text-white opacity-80">Monitoring event kegiatan OPD</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Event</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['past_active'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Past Active</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['active'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Aktif</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['draft'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Draft</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('event.index') }}"
                class="btn btn-sm {{ !request()->filled('status') && !request()->filled('q') ? 'btn-secondary' : 'btn-ghost bg-base-100' }}">
                Semua
                <div class="badge badge-sm">{{ $stats['total'] ?? 0 }}</div>
            </a>
            <a href="{{ route('event.index', array_merge(request()->query(), ['status' => 'past_active'])) }}"
                class="btn btn-sm {{ request('status') == 'past_active' ? 'btn-error' : 'btn-ghost bg-base-100 text-error' }}">
                Past Active
                <div class="badge badge-sm badge-error text-white">{{ $stats['past_active'] ?? 0 }}</div>
            </a>
            <a href="{{ route('event.index', array_merge(request()->query(), ['status' => 'active'])) }}"
                class="btn btn-sm {{ request('status') == 'active' ? 'btn-success' : 'btn-ghost bg-base-100 text-success' }}">
                Active
                <div class="badge badge-sm badge-success text-white">{{ $stats['active'] ?? 0 }}</div>
            </a>
            <a href="{{ route('event.index', array_merge(request()->query(), ['status' => 'draft'])) }}"
                class="btn btn-sm {{ request('status') == 'draft' ? 'btn-warning' : 'btn-ghost bg-base-100 text-warning' }}">
                Draft
                <div class="badge badge-sm badge-warning text-white">{{ $stats['draft'] ?? 0 }}</div>
            </a>
            <a href="{{ route('event.index', array_merge(request()->query(), ['status' => 'finished'])) }}"
                class="btn btn-sm {{ request('status') == 'finished' ? 'btn-neutral' : 'btn-ghost bg-base-100' }}">
                Finished
                <div class="badge badge-sm">{{ $stats['finished'] ?? 0 }}</div>
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('event.create') }}" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Event
            </a>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="form-control">
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form method="GET" action="{{ route('event.index') }}" class="flex items-center gap-2">
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
                    <input type="hidden" name="status" value="{{ request('status') }}">
                </form>
                <div class="relative w-full sm:w-auto">
                    <input id="event-search-input" type="text" placeholder="Cari Event..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button id="event-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 {{ request('q') ? '' : 'hidden' }}">
                        <svg class="w-5 h-5 text-base-content/50 hover:text-error cursor-pointer" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <div id="event-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow-xl z-50 hidden border border-base-200">
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
    @endif

    <!-- Events Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Event</th>
                            <th>Jenis / Mode</th>
                            <th>Waktu & Lokasi</th>
                            <th>OPD Penyelenggara</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($events->currentPage() - 1) * $events->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="font-bold text-sm">{{ $event->title }}</div>
                                    <div class="text-xs opacity-50">By: {{ $event->user->name }}</div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="badge badge-sm badge-outline whitespace-nowrap">{{ $event->jenis_event }}</span>
                                        <span
                                            class="badge badge-sm badge-ghost text-xs uppercase">{{ $event->mode }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm font-medium">
                                        {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs opacity-70">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</div>
                                    <div class="text-xs italic mt-1">{{ $event->location ?? 'Online' }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if ($event->opdMaster->logo_url)
                                            <img src="{{ $event->opdMaster->logo_url }}"
                                                class="w-6 h-6 object-contain">
                                        @endif
                                        <div class="text-xs font-semibold">{{ $event->opdMaster->singkatan }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="badge badge-sm {{ $event->status_badge_class }} uppercase font-bold text-[10px]">{{ $event->status }}</span>
                                        <span
                                            class="badge whitespace-nowrap badge-sm badge-neutral text-[10px] {{ $event->time_status['text_class'] }} italic leading-tight">
                                            {{ $event->time_status['label'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('event.public_detail', $event->slug) }}" target="_blank"
                                            class="btn btn-square btn-xs btn-ghost text-info tooltip"
                                            data-tip="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            class="btn btn-square btn-xs btn-ghost text-secondary tooltip"
                                            data-tip="Copy Public Link"
                                            onclick="copyText('{{ route('event.public_detail', $event->slug) }}', this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                            </svg>
                                        </button>
                                        @can('edit-event')
                                            <a href="{{ route('event.edit', $event) }}"
                                                class="btn btn-square btn-xs btn-ghost text-warning tooltip"
                                                data-tip="Edit Event">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @else
                                            <div class="btn btn-square btn-ghost btn-xs opacity-50 cursor-not-allowed"
                                                title="Tidak ada akses">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </div>
                                        @endcan
                                        @can('delete-event')
                                            <button type="button" data-delete-id="{{ $event->uuid }}"
                                                data-delete-title="{{ $event->title }}"
                                                class="btn btn-square btn-xs btn-ghost text-error tooltip"
                                                data-tip="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @else
                                            <div class="btn btn-square btn-ghost btn-xs opacity-50 cursor-not-allowed"
                                                title="Tidak ada akses">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="p-3 bg-base-200 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-8 h-8 opacity-20">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                        </div>
                                        <div class="text-base-content/40 font-medium">Belum ada data event</div>
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
        {{ $events->links() }}
    </div>

    <!-- Delete Modal -->
    <dialog id="delete-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-base-content/70">Apakah Anda yakin ingin menghapus event <span
                    id="delete-event-title" class="font-semibold text-error"></span>? Data event akan dihapus secara
                permanen.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Batal</button>
                </form>
                <form id="delete-event-form" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-white">Hapus Event</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            function copyText(text, btn) {
                if (!navigator.clipboard) {
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showCopySuccess(btn);
                    } catch (err) {
                        console.error('Fallback: Oops, unable to copy', err);
                    }
                    document.body.removeChild(textArea);
                    return;
                }
                navigator.clipboard.writeText(text).then(() => {
                    showCopySuccess(btn);
                }).catch(err => {
                    console.error('Async: Could not copy text: ', err);
                });
            }

            function showCopySuccess(btn) {
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
            }

            (function() {
                const input = document.getElementById('event-search-input');
                const box = document.getElementById('event-search-suggestions');
                const clearBtn = document.getElementById('event-search-clear');
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
                            '<li><button type="button" data-q="' + encodeURIComponent(i.title) + '">' +
                            '<div class="flex flex-col text-left">' +
                            '<span class="font-medium">' + (i.title ?? '') + '</span>' +
                            '<span class="text-[10px] opacity-60">' + [i.jenis, i.opd, i.status].filter(
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
                    fetch(`{{ route('event.suggest') }}?q=` + encodeURIComponent(q), {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(r => r.json())
                        .then(d => {
                            const items = (d.data || []).map(a => ({
                                title: a.title,
                                jenis: a.jenis,
                                opd: a.opd,
                                status: a.status
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
                        const url = new URL(window.location.href);
                        if (q) {
                            url.searchParams.set('q', q);
                        } else {
                            url.searchParams.delete('q');
                        }
                        window.location = url.toString();
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

            (function() {
                const deleteModal = document.getElementById('delete-modal');
                const deleteForm = document.getElementById('delete-event-form');
                const deleteTitleEl = document.getElementById('delete-event-title');

                document.querySelectorAll('button[data-delete-id]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-delete-id');
                        const title = this.getAttribute('data-delete-title') || '';
                        deleteForm.setAttribute('action', `{{ url('/event/delete') }}/${id}`);
                        deleteTitleEl.textContent = title;
                        if (deleteModal?.showModal) deleteModal.showModal();
                    });
                });
            })();

            document.addEventListener('DOMContentLoaded', function() {
                const successToast = document.getElementById('success-toast');
                if (successToast) {
                    setTimeout(() => {
                        successToast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                        setTimeout(() => successToast.remove(), 500);
                    }, 3000);
                }
            });
        </script>
    @endpush
</x-layout>
