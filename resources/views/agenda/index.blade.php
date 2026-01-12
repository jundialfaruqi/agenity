<x-layout title="Agenda Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Agenda Management</h1>
            <p class="text-sm text-base-content/60 mt-1">Manajemen agenda dan sesi absensi digital</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Apps</li>
                <li><a href="{{ route('agenda.index') }}"><span class="text-base-content">Agenda Management</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Agenda</div>
                    <div class="text-sm text-white opacity-80">Monitoring agenda kegiatan dan status absensi</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Agenda</div>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Total Agenda</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</span>
                                <span class="text-xs text-base-content/50">Kegiatan terdaftar</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Agenda Aktif</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['active'] ?? 0 }}</span>
                                <span class="text-xs text-success">Berlangsung</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Draft Agenda</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['draft'] ?? 0 }}</span>
                                <span class="text-xs text-warning">Belum dipublikasi</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-sm text-base-content/60 font-medium">Selesai</h2>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-2xl font-bold">{{ $stats['finished'] ?? 0 }}</span>
                                <span class="text-xs text-info">Riwayat kegiatan</span>
                            </div>
                        </div>
                        <div class="p-2 bg-base-200 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.125 2.25h3.75a.75.75 0 0 1 .75.75v1.125c0 .414.336.75.75.75h4.5a2.25 2.25 0 0 1 2.25 2.25v12.75a2.25 2.25 0 0 1-2.25 2.25H4.125a2.25 2.25 0 0 1-2.25-2.25V7.125a2.25 2.25 0 0 1 2.25-2.25h4.5c.414 0 .75-.336.75-.75V3a.75.75 0 0 1 .75-.75ZM9 10.125a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Zm0 3.75a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Z" />
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
                <form method="GET" action="{{ route('agenda.index') }}" class="flex items-center gap-2">
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
                    <input id="agenda-search-input" type="text" placeholder="Cari Agenda..."
                        value="{{ request('q') }}"
                        class="input input-bordered w-full sm:max-w-xs pl-10 pr-10 bg-base-100" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button id="agenda-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 {{ request('q') ? '' : 'hidden' }}">
                        <svg class="w-5 h-5 text-base-content/50 hover:text-error cursor-pointer" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <div id="agenda-search-suggestions"
                        class="absolute mt-1 w-full bg-base-100 rounded-md shadow-xl z-50 hidden border border-base-200">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('agenda.create') }}" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Agenda
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

    <!-- Agendas Table Card -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="card overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Agenda</th>
                            <th>Jenis / Mode</th>
                            <th>Waktu & Lokasi</th>
                            <th>OPD Penyelenggara</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendas as $agenda)
                            <tr>
                                <td class="text-center font-bold">
                                    {{ ($agendas->currentPage() - 1) * $agendas->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="font-bold text-sm">{{ $agenda->title }}</div>
                                    <div class="text-xs opacity-50">By: {{ $agenda->user->name }}</div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="badge badge-sm badge-outline whitespace-nowrap">{{ $agenda->jenis_agenda }}</span>
                                        <span
                                            class="badge badge-sm badge-ghost text-xs uppercase">{{ $agenda->mode }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm font-medium">
                                        {{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs opacity-70">{{ $agenda->start_time }} -
                                        {{ $agenda->end_time }}</div>
                                    <div class="text-xs italic mt-1">{{ $agenda->location ?? 'Online' }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if ($agenda->opdMaster->logo_url)
                                            <img src="{{ $agenda->opdMaster->logo_url }}"
                                                class="w-6 h-6 object-contain">
                                        @endif
                                        <div class="text-xs font-semibold">{{ $agenda->opdMaster->singkatan }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match ($agenda->status) {
                                            'active' => 'badge-success',
                                            'draft' => 'badge-warning',
                                            'finished' => 'badge-neutral',
                                            default => 'badge-ghost',
                                        };
                                    @endphp
                                    <span
                                        class="badge badge-sm {{ $statusClass }} uppercase font-bold text-[10px]">{{ $agenda->status }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        @if ($agenda->sessions->count() > 0)
                                            <button type="button"
                                                class="btn btn-square btn-ghost btn-xs text-warning" title="View QR"
                                                onclick="showQrModal('{{ $agenda->title }}', '{{ asset('storage/' . $agenda->sessions->first()->qr_code_path) }}', '{{ route('absensi.show', $agenda->sessions->first()->token) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75ZM13.5 16.5h.75v.75h-.75v-.75ZM16.5 13.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 19.5h.75v.75h-.75v-.75Z" />
                                                </svg>
                                            </button>
                                        @endif
                                        <a href="{{ route('agenda.absensi', $agenda->id) }}"
                                            class="btn btn-square btn-ghost btn-xs text-primary"
                                            title="View Attendance">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('agenda.export', $agenda->id) }}"
                                            class="btn btn-square btn-ghost btn-xs text-secondary" title="Export PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('agenda.edit', $agenda->id) }}"
                                            class="btn btn-square btn-ghost btn-xs" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <button type="button" class="btn btn-square btn-ghost btn-xs text-error"
                                            title="Delete" data-delete-id="{{ $agenda->id }}"
                                            data-delete-title="{{ $agenda->title }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center text-base-content/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-12 h-12 mb-2 opacity-20">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        <p>No agendas found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($agendas->hasPages())
            <div class="p-4 border-t border-base-200">
                {{ $agendas->links() }}
            </div>
        @endif
    </div>

    <!-- QR Modal -->
    <dialog id="qr_modal" class="modal">
        <div class="modal-box text-center">
            <h3 class="font-bold text-lg mb-4" id="qr_modal_title">QR Code Absensi</h3>
            <div class="flex flex-col items-center gap-4">
                <img id="qr_modal_img" src="" class="w-64 h-64 border-8 border-white shadow-lg rounded-xl">
                <div class="flex flex-col gap-2 w-full">
                    <div class="text-xs opacity-50 uppercase font-bold">Public Link:</div>
                    <div class="flex gap-2">
                        <input type="text" id="qr_modal_link" readonly
                            class="input input-bordered input-sm flex-1 text-xs">
                        <button onclick="copyQrLink()" class="btn btn-sm btn-neutral">Copy</button>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Delete Modal -->
    <dialog id="delete-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-base-content/70">Apakah Anda yakin ingin menghapus agenda <span
                    id="delete-agenda-title" class="font-semibold text-error"></span>? Semua data sesi dan absensi
                terkait akan ikut terhapus secara permanen.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Batal</button>
                </form>
                <form id="delete-agenda-form" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-white">Hapus Agenda</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            (function() {
                const input = document.getElementById('agenda-search-input');
                const box = document.getElementById('agenda-search-suggestions');
                const clearBtn = document.getElementById('agenda-search-clear');
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
                    fetch(`{{ route('agenda.suggest') }}?q=` + encodeURIComponent(q), {
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

            (function() {
                const deleteModal = document.getElementById('delete-modal');
                const deleteForm = document.getElementById('delete-agenda-form');
                const deleteTitleEl = document.getElementById('delete-agenda-title');

                document.querySelectorAll('button[data-delete-id]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-delete-id');
                        const title = this.getAttribute('data-delete-title') || '';
                        deleteForm.setAttribute('action', `{{ url('/agenda') }}/${id}`);
                        deleteTitleEl.textContent = title;
                        if (deleteModal?.showModal) deleteModal.showModal();
                    });
                });
            })();

            function showQrModal(title, qrImage, link) {
                document.getElementById('qr_modal_title').innerText = 'QR Code: ' + title;
                document.getElementById('qr_modal_img').src = qrImage;
                document.getElementById('qr_modal_link').value = link;
                document.getElementById('qr_modal').showModal();
            }

            function copyQrLink() {
                const linkInput = document.getElementById('qr_modal_link');
                linkInput.select();
                document.execCommand('copy');
                alert('Link berhasil disalin!');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('agenda-search-input');
                // Removed redundant searchInput logic as it's now handled by the IIFE search function

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
