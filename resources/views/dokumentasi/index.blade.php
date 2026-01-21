<x-layout title="Dokumentasi Management">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Dokumentasi</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data dokumentasi pakaian dan kegiatan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Apps</li>
                <li><a href="{{ route('dokumentasi.index') }}"><span class="text-base-content">Dokumentasi</span></a></li>
            </ul>
        </div>
    </div>

    <div class="mb-6">
        <div class="card bg-linear-to-r from-secondary to-neutral text-base-100 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-lg text-white font-bold">Data Dokumentasi</div>
                    <div class="text-sm text-white opacity-80">Monitoring data dokumentasi dan pakaian</div>
                </div>
                <div class="flex flex-wrap gap-4 md:gap-0 mt-1 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl text-white font-bold">{{ $stats['total'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Dokumentasi</div>
                    </div>
                    <div class="text-center md:pl-6 md:ml-6 md:border-l md:border-dotted md:border-white/40">
                        <div class="text-2xl text-white font-bold">{{ $stats['total_pakaian'] ?? 0 }}</div>
                        <div class="text-xs text-white opacity-80">Total Pakaian</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <form method="GET" action="{{ route('dokumentasi.index') }}" class="flex items-center gap-2">
                <div class="join">
                    <span
                        class="btn btn-disabled join-item text-base-content pointer-events-none rounded-left-md">Show</span>
                    <select name="per_page" class="select join-item w-20 rounded-end-md" onchange="this.form.submit()">
                        @php $pp = (int) request('per_page', 10); @endphp
                        <option value="10" @selected($pp === 10)>10</option>
                        <option value="20" @selected($pp === 20)>20</option>
                        <option value="50" @selected($pp === 50)>50</option>
                        <option value="100" @selected($pp === 100)>100</option>
                    </select>
                </div>
                @foreach (request()->except(['per_page', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>

            <div class="relative w-full md:w-64 lg:w-70">
                <form method="GET" action="{{ route('dokumentasi.index') }}">
                    @foreach (request()->except(['q', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <input id="dokumentasi-search-input" type="text" name="q"
                        placeholder="Cari judul atau keterangan..." value="{{ request('q') }}"
                        class="input input-bordered w-full pl-8 pr-8" autocomplete="off" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                        <svg class="w-4 h-4 text-base-content/50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <button type="button" id="dokumentasi-search-clear"
                        class="absolute inset-y-0 right-0 flex items-center pr-2 text-base-content/50 {{ !request('q') ? 'hidden' : '' }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
                <div id="dokumentasi-search-suggestions"
                    class="absolute mt-1 w-full bg-base-100 rounded-md shadow-lg z-50 hidden">
                </div>
            </div>
        </div>

        <div class="flex gap-2 w-full md:w-auto justify-end">
            <button onclick="add_modal.showModal()" class="btn btn-neutral gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Dokumentasi
            </button>
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

    <!-- Dokumentasi Table Card -->
    <div class="card bg-base-100 shadow-sm mb-6">
        <!-- Table Filters -->
        <div class="mb-1 px-6 pt-4 pb-6 border-b border-base-200">
            <form id="filter-form" method="GET" action="{{ route('dokumentasi.index') }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                @if (request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if (request('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif

                <div class="form-control">
                    <label class="label py-0.5"><span
                            class="label-text text-[10px] font-bold uppercase opacity-60">Tanggal</span></label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="input input-sm input-bordered w-full" onchange="this.form.submit()" />
                </div>

                <div class="form-control">
                    <label class="label py-0.5"><span
                            class="label-text text-[10px] font-bold uppercase opacity-60">Bulan</span></label>
                    <select name="month" class="select select-sm select-bordered w-full"
                        onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @selected(request('month') == $i)>
                                {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-0.5"><span
                            class="label-text text-[10px] font-bold uppercase opacity-60">Tahun</span></label>
                    <select name="year" class="select select-sm select-bordered w-full"
                        onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = $currentYear - 5;
                            $endYear = $currentYear + 1;
                        @endphp
                        @for ($y = $endYear; $y >= $startYear; $y--)
                            <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-0.5"><span
                            class="label-text text-[10px] font-bold uppercase opacity-60">Hari</span></label>
                    <select name="day" class="select select-sm select-bordered w-full"
                        onchange="this.form.submit()">
                        <option value="">Semua Hari</option>
                        @php
                            $days = [
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                                'Sunday' => 'Minggu',
                            ];
                        @endphp
                        @foreach ($days as $value => $label)
                            <option value="{{ $value }}" @selected(request('day') == $value)>{{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-0.5"><span
                            class="label-text text-[10px] font-bold uppercase opacity-60">Pakaian</span></label>
                    <select name="pakaian_id" class="select select-sm select-bordered w-full"
                        onchange="this.form.submit()">
                        <option value="">Semua Pakaian</option>
                        @foreach ($pakaians as $p)
                            <option value="{{ $p->id }}" @selected(request('pakaian_id') == $p->id)>
                                {{ $p->contoh_pakaian }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if (request()->anyFilled(['date', 'month', 'year', 'day', 'pakaian_id']))
                    <div class="flex justify-start pb-1">
                        <a href="{{ route('dokumentasi.index', request()->only(['q', 'per_page'])) }}"
                            class="btn btn-link btn-sm text-error no-underline hover:underline p-0 h-auto min-h-0 gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-center w-12">#</th>
                        <th class="w-24">Tanggal</th>
                        <th>Judul Acara</th>
                        <th>Pakaian</th>
                        <th>Agenda/Event</th>
                        <th>Keterangan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumentasis as $dokumentasi)
                        <tr>
                            <td class="text-center font-bold">
                                {{ ($dokumentasis->currentPage() - 1) * $dokumentasis->perPage() + $loop->iteration }}
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="text-xs">{{ \Carbon\Carbon::parse($dokumentasi->date)->translatedFormat('l, d F Y') }}</span>
                                    @if ($dokumentasi->link_dokumentasi)
                                        <a href="{{ $dokumentasi->link_dokumentasi }}" target="_blank"
                                            class="btn btn-xs btn-secondary w-fit h-6 min-h-0 text-[10px] gap-1 px-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                            Lihat Foto
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="font-bold">{{ $dokumentasi->judul }}</td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $dokumentasi->pakaian->contoh_pakaian }}</span>
                                    <span
                                        class="text-[10px] opacity-60">{{ $dokumentasi->pakaian->kategoriPakaian->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                @if ($dokumentasi->agenda)
                                    <div
                                        class="badge badge-info badge-outline text-[9px] gap-1 px-1 h-5 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-2.5 h-2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12V12.75zm3 0h.008v.008H15V12.75zm0 3h.008v.008H15v-.008zm-3 0h.008v.008H12v-.008zm-3 0h.008v.008H9v-.008zm0-3h.008v.008H9V12.75z" />
                                        </svg>
                                        {{ Str::limit($dokumentasi->agenda->title, 20) }}
                                    </div>
                                @elseif($dokumentasi->event)
                                    <div class="badge badge-secondary badge-outline text-[9px] gap-1 px-1 h-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-2.5 h-2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        {{ Str::limit($dokumentasi->event->title, 20) }}
                                    </div>
                                @else
                                    <span class="text-[10px] opacity-50">-</span>
                                @endif
                            </td>
                            <td class="max-w-37.5 truncate text-[10px] opacity-70">
                                {{ $dokumentasi->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-1">
                                    <button type="button" onclick="openEditModal({{ json_encode($dokumentasi) }})"
                                        class="btn btn-square btn-xs btn-ghost text-warning tooltip" data-tip="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal('{{ $dokumentasi->uuid }}', '{{ $dokumentasi->judul }}')"
                                        class="btn btn-square btn-xs btn-ghost text-error tooltip" data-tip="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-sm text-base-content/60 py-10">Tidak ada
                                data dokumentasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-actions p-4 justify-between items-center border-t border-base-200">
            <div class="w-full">
                {!! $dokumentasis->appends(request()->query())->onEachSide(1)->links() !!}
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <dialog id="add_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-6 text-neutral">Tambah Dokumentasi Baru</h3>
            <form action="{{ route('dokumentasi.store') }}" method="POST" data-loading
                data-loading-text="Menyimpan..." class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label mb-2"><span class="label-text font-semibold">Tanggal</span></label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}"
                            class="input input-bordered w-full" required />
                    </div>
                    <div class="form-control">
                        <label class="label mb-2"><span class="label-text font-semibold">Pakaian</span></label>
                        <select name="pakaian_id" class="select select-bordered w-full" required>
                            <option value="" disabled selected>Pilih Pakaian</option>
                            @foreach ($pakaians as $pakaian)
                                <option value="{{ $pakaian->id }}">{{ $pakaian->contoh_pakaian }}
                                    ({{ $pakaian->kategoriPakaian->name ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label mb-2"><span class="label-text font-semibold">Agenda</span></label>
                        <select id="add_agenda_id" name="agenda_id" class="select select-bordered w-full">
                            <option value="">Pilih Agenda (Opsional)</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}" data-title="{{ $agenda->title }}">
                                    {{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label mb-2"><span class="label-text font-semibold">Event</span></label>
                        <select id="add_event_id" name="event_id" class="select select-bordered w-full">
                            <option value="">Pilih Event (Opsional)</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" data-title="{{ $event->title }}">
                                    {{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label mb-2"><span class="label-text font-semibold">Judul</span></label>
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-wrap gap-1 mb-2">
                            <button type="button" id="add_btn_title_agenda"
                                class="btn btn-xs btn-outline btn-info hidden">Pakai Judul Agenda</button>
                            <button type="button" id="add_btn_title_event"
                                class="btn btn-xs btn-outline btn-secondary hidden">Pakai Judul Event</button>
                            <button type="button" id="add_btn_title_manual"
                                class="btn btn-xs btn-outline btn-neutral">Ketik Manual</button>
                        </div>
                        <input type="text" id="add_judul" name="judul" placeholder="Masukkan judul dokumentasi"
                            class="input input-bordered w-full" required />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label mb-2"><span class="label-text font-semibold">Link Dokumentasi</span></label>
                    <input type="url" name="link_dokumentasi" placeholder="https://..."
                        class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label mb-2"><span class="label-text font-semibold">Keterangan</span></label>
                    <textarea name="keterangan" placeholder="Keterangan..." class="textarea textarea-bordered h-20 w-full"></textarea>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="add_modal.close()" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-neutral px-8">
                        <span class="loading loading-spinner hidden"></span>
                        <span class="btn-text">Simpan Dokumentasi</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Edit Modal -->
    <dialog id="edit_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-6 text-warning">Edit Dokumentasi</h3>
            <form id="edit_form" method="POST" data-loading data-loading-text="Memperbarui..." class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Tanggal</span></label>
                        <input type="date" id="edit_date" name="date" class="input input-bordered w-full"
                            required />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Pakaian</span></label>
                        <select id="edit_pakaian_id" name="pakaian_id" class="select select-bordered w-full"
                            required>
                            @foreach ($pakaians as $pakaian)
                                <option value="{{ $pakaian->id }}">{{ $pakaian->contoh_pakaian }}
                                    ({{ $pakaian->kategoriPakaian->name ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Agenda</span></label>
                        <select id="edit_agenda_id" name="agenda_id" class="select select-bordered w-full">
                            <option value="">Pilih Agenda (Opsional)</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}" data-title="{{ $agenda->title }}">
                                    {{ $agenda->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Event</span></label>
                        <select id="edit_event_id" name="event_id" class="select select-bordered w-full">
                            <option value="">Pilih Event (Opsional)</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" data-title="{{ $event->title }}">
                                    {{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Judul</span></label>
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-wrap gap-1">
                            <button type="button" id="edit_btn_title_agenda"
                                class="btn btn-xs btn-outline btn-info hidden">Pakai Judul Agenda</button>
                            <button type="button" id="edit_btn_title_event"
                                class="btn btn-xs btn-outline btn-secondary hidden">Pakai Judul Event</button>
                            <button type="button" id="edit_btn_title_manual"
                                class="btn btn-xs btn-outline btn-neutral">Ketik Manual</button>
                        </div>
                        <input type="text" id="edit_judul" name="judul" class="input input-bordered w-full"
                            required />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Link Dokumentasi</span></label>
                    <input type="url" id="edit_link_dokumentasi" name="link_dokumentasi"
                        class="input input-bordered w-full" />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Keterangan</span></label>
                    <textarea id="edit_keterangan" name="keterangan" class="textarea textarea-bordered h-20 w-full"></textarea>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="edit_modal.close()" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-neutral px-8">
                        <span class="loading loading-spinner hidden"></span>
                        <span class="btn-text">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Konfirmasi Hapus</h3>
            <p class="py-4">Apakah Anda yakin ingin menghapus dokumentasi <strong id="delete_item_title"></strong>?
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Batal</button>
                </form>
                <form id="delete_form" method="POST" data-loading data-loading-text="Menghapus...">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-white">
                        <span class="loading loading-spinner hidden"></span>
                        <span class="btn-text">Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script src="{{ asset('js/global-loading.js') }}"></script>
    <script>
        // Modal Logic
        function openEditModal(data) {
            const form = document.getElementById('edit_form');
            form.action = `/dokumentasi/${data.uuid}`;

            document.getElementById('edit_date').value = data.date;
            document.getElementById('edit_pakaian_id').value = data.pakaian_id;
            document.getElementById('edit_agenda_id').value = data.agenda_id || '';
            document.getElementById('edit_event_id').value = data.event_id || '';
            document.getElementById('edit_judul').value = data.judul;
            document.getElementById('edit_link_dokumentasi').value = data.link_dokumentasi || '';
            document.getElementById('edit_keterangan').value = data.keterangan || '';

            updateTitleButtons('edit');
            edit_modal.showModal();
        }

        function openDeleteModal(uuid, title) {
            const form = document.getElementById('delete_form');
            form.action = `/dokumentasi/${uuid}`;
            document.getElementById('delete_item_title').innerText = title;
            delete_modal.showModal();
        }

        // Title Logic
        function updateTitleButtons(prefix) {
            const agendaSelect = document.getElementById(`${prefix}_agenda_id`);
            const eventSelect = document.getElementById(`${prefix}_event_id`);
            const btnAgenda = document.getElementById(`${prefix}_btn_title_agenda`);
            const btnEvent = document.getElementById(`${prefix}_btn_title_event`);

            if (agendaSelect.value) btnAgenda.classList.remove('hidden');
            else btnAgenda.classList.add('hidden');

            if (eventSelect.value) btnEvent.classList.remove('hidden');
            else btnEvent.classList.add('hidden');
        }

        ['add', 'edit'].forEach(prefix => {
            const agendaSelect = document.getElementById(`${prefix}_agenda_id`);
            const eventSelect = document.getElementById(`${prefix}_event_id`);
            const judulInput = document.getElementById(`${prefix}_judul`);
            const btnAgenda = document.getElementById(`${prefix}_btn_title_agenda`);
            const btnEvent = document.getElementById(`${prefix}_btn_title_event`);
            const btnManual = document.getElementById(`${prefix}_btn_title_manual`);

            agendaSelect.addEventListener('change', () => updateTitleButtons(prefix));
            eventSelect.addEventListener('change', () => updateTitleButtons(prefix));

            btnAgenda.addEventListener('click', () => {
                const opt = agendaSelect.options[agendaSelect.selectedIndex];
                if (opt.value) judulInput.value = opt.getAttribute('data-title');
            });

            btnEvent.addEventListener('click', () => {
                const opt = eventSelect.options[eventSelect.selectedIndex];
                if (opt.value) judulInput.value = opt.getAttribute('data-title');
            });

            btnManual.addEventListener('click', () => {
                judulInput.value = '';
                judulInput.focus();
            });
        });

        // Search Logic
        (function() {
            const input = document.getElementById('dokumentasi-search-input');
            const box = document.getElementById('dokumentasi-search-suggestions');
            const clearBtn = document.getElementById('dokumentasi-search-clear');
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
                    html = '<div class="p-3 text-sm text-base-content/50 italic">No dokumentasi found</div>';
                } else {
                    html = '<ul class="menu p-2">';
                    const currentUrl = new URL(window.location.href);
                    items.forEach(item => {
                        const url = new URL('{{ route('dokumentasi.index') }}', window.location.origin);
                        // Copy current search params except q and page
                        currentUrl.searchParams.forEach((value, key) => {
                            if (key !== 'q' && key !== 'page') url.searchParams.set(key, value);
                        });
                        url.searchParams.set('q', item.name);
                        html += `
                            <li>
                                <a href="${url.toString()}" class="flex flex-col items-start gap-0 py-2">
                                    <span class="font-bold text-sm">${item.name}</span>
                                    <div class="flex items-center gap-2 text-[10px] opacity-60">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            ${item.date}
                                        </span>
                                        <span class="opacity-30">|</span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 01-1.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                            </svg>
                                            ${item.pakaian}
                                        </span>
                                    </div>
                                </a>
                            </li>`;
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
                    fetch(`{{ route('dokumentasi.suggest') }}?q=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(res => show(res.data || []))
                        .catch(hide);
                }, 300);
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    input.closest('form').submit();
                }
            });

            clearBtn.addEventListener('click', () => {
                input.value = '';
                updateClear();
                hide();
                input.closest('form').submit();
            });

            document.addEventListener('click', (e) => {
                if (!input.contains(e.target) && !box.contains(e.target)) hide();
            });

            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if (toast) toast.remove();
            }, 3000);
        })();
    </script>
</x-layout>
