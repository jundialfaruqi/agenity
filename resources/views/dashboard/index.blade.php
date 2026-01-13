<x-layout title="Dashboard">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <h1 class="text-xl font-bold">Agenity Overview</h1>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a>{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('dashboard.index') }}">Dashboards</a></li>
            </ul>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Agenda -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Total Agenda</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">{{ $stats['total_agenda'] }}</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $stats['active_agenda'] }} Aktif
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">Seluruh agenda terdaftar</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M12 3v2.25m5.25-2.25V5.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Absensi -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Total Kehadiran</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">{{ $stats['total_absensi'] }}</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                        clip-rule="evenodd" />
                                </svg>
                                Real-time
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">Peserta yang telah absen</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total OPD -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Total OPD</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">{{ $stats['total_opd'] }}</span>
                            <div class="badge badge-info badge-sm gap-1 bg-blue-100 text-blue-700 border-none">
                                Instansi
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">Organisasi Perangkat Daerah</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Total Pengguna</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">{{ $stats['total_users'] }}</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                Aktif
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">Pengguna sistem terdaftar</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Agendas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Upcoming Agendas -->
        <div class="card bg-base-100 shadow-sm col-span-1 lg:col-span-2">
            <div class="card-body p-0">
                <div class="p-6 flex justify-between items-center border-b border-base-200">
                    <h3 class="font-bold text-lg">Agenda Aktif Mendatang</h3>
                    <div class="tabs tabs-boxed bg-transparent p-0">
                        <a href="{{ route('dashboard.index', array_merge(request()->query(), ['agenda_filter' => '7_days'])) }}"
                            class="tab btn-sm rounded-lg {{ $agendaFilter === '7_days' ? 'tab-active bg-base-300 text-base-content rounded-btn' : '' }}">7
                            Hari Ke Depan</a>
                        <a href="{{ route('dashboard.index', array_merge(request()->query(), ['agenda_filter' => 'this_month'])) }}"
                            class="tab btn-sm rounded-lg {{ $agendaFilter === 'this_month' ? 'tab-active bg-base-300 text-base-content rounded-btn' : '' }}">Bulan
                            Ini</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <!-- head -->
                        <thead class="bg-base-200/50">
                            <tr>
                                <th>Agenda</th>
                                <th>OPD Penyelenggara</th>
                                <th>Tanggal & Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingAgendas as $agenda)
                                <tr class="hover:bg-base-200 cursor-pointer transition-colors"
                                    onclick="window.location='{{ route('agenda.public_detail', $agenda->id) }}'">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-10 h-10 bg-base-200">
                                                    @if ($agenda->opdMaster && $agenda->opdMaster->logo_url)
                                                        <img src="{{ $agenda->opdMaster->logo_url }}"
                                                            alt="{{ $agenda->opdMaster->name }}" />
                                                    @else
                                                        <div
                                                            class="bg-primary text-primary-content flex items-center justify-center w-full h-full font-bold">
                                                            {{ substr($agenda->opdMaster->name ?? 'A', 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">
                                                    {{ \Illuminate\Support\Str::words($agenda->title, 4) }}</div>
                                                <div class="text-[10px] opacity-50">
                                                    {{ $agenda->user->name ?? 'System' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-xs font-medium">{{ $agenda->opdMaster->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="text-xs font-semibold">
                                            {{ \Carbon\Carbon::parse($agenda->date)->format('d M Y') }}</div>
                                        <div class="text-[10px] opacity-60">{{ substr($agenda->start_time, 0, 5) }} -
                                            {{ substr($agenda->end_time, 0, 5) }}</div>
                                    </td>
                                    <td>
                                        <span
                                            class="text-xs truncate max-w-37.5 inline-block">{{ $agenda->location }}</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="badge {{ $agenda->status_badge_class }} badge-xs py-2 px-2 uppercase font-bold text-[9px]">{{ $agenda->status }}</span>
                                            <span
                                                class="badge {{ $agenda->time_status['class'] }} badge-xs py-2 px-2 font-medium text-[9px] whitespace-nowrap">{{ $agenda->time_status['label'] }}</span>
                                            <span
                                                class="badge {{ $agenda->visibility_status['class'] }} badge-xs py-2 px-2 uppercase font-bold text-[9px] gap-1">
                                                @if ($agenda->visibility === 'public')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-2.5 h-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-2.5 h-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                @endif
                                                {{ $agenda->visibility_status['label'] }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 opacity-50 italic">
                                        Tidak ada agenda aktif ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="p-4 border-t mt-auto border-base-200">
                    {{ $upcomingAgendas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <!-- Quick Chat -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-0 flex flex-col h-full">
                <div class="p-6 border-b border-base-200 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Quick Chat</h3>
                    <button class="btn btn-xs btn-ghost">•••</button>
                </div>
                <!-- Chat Content -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 max-h-80">
                    <div class="chat chat-end">
                        <div class="chat-image avatar">
                            <div class="w-8 rounded-full">
                                <img
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <div class="chat-bubble chat-bubble-primary text-sm">Halo, bagaimana cara membuat dan melihat
                            daftar agenda di sistem ini?</div>
                    </div>
                    <div class="chat chat-start">
                        <div class="chat-image avatar">
                            <div class="w-8 rounded-full">
                                <img src="https://ui-avatars.com/api/?name=Admin&background=641ae3&color=fff" />
                            </div>
                        </div>
                        <div class="chat-bubble chat-bubble-secondary text-sm">
                            Halo! Untuk membuat agenda baru, klik
                            <a href="{{ route('agenda.create') }}"
                                class="underline font-bold hover:text-white transition-colors">Add Agenda</a>.
                            Sedangkan untuk melihat daftar semua agenda, kamu bisa buka menu
                            <a href="{{ route('agenda.index') }}"
                                class="underline font-bold hover:text-white transition-colors">Agenda</a>.
                        </div>
                    </div>
                    <div class="chat chat-end">
                        <div class="chat-image avatar">
                            <div class="w-8 rounded-full">
                                <img
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <div class="chat-bubble chat-bubble-primary text-sm">Siap, terima kasih informasinya sangat
                            membantu!</div>
                    </div>
                </div>
                <!-- Input -->
                <div class="p-4 border-t mt-auto border-base-200">
                    <div class="join w-full">
                        <input class="input input-bordered input-sm join-item w-full" placeholder="Tulis pesan..." />
                        <button class="btn btn-primary btn-sm join-item">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <!-- OPD Statistics (Top 10 OPD) -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <div class="mb-6">
                    <h3 class="font-bold text-lg">Top 10 OPD (Agenda Terbanyak)</h3>
                    <p class="text-xs text-base-content/50 mt-1">Berdasarkan total agenda yang diselenggarakan</p>
                </div>

                <!-- Horizontal Bar Chart -->
                <div class="flex flex-col gap-4 h-64 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($opdLabels as $index => $label)
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-between items-center text-[10px] sm:text-xs">
                                <span class="font-medium truncate max-w-[70%]"
                                    title="{{ $label }}">{{ $label }}</span>
                                <span class="font-bold">{{ $opdChartData[$index] }} Agenda</span>
                            </div>
                            <div class="w-full bg-base-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-primary h-full rounded-full transition-all duration-500"
                                    style="width: {{ $opdChartDataScaled[$index] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Agenda Statistics (Bar Chart) -->
        <div class="card bg-base-100 shadow-sm col-span-1 lg:col-span-2">
            <div class="card-body p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $title }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-3xl font-bold">{{ array_sum($chartData) }}</span>
                            @if ($trend != 0)
                                <div
                                    class="badge {{ $trend >= 0 ? 'badge-success bg-green-100 text-green-700' : 'badge-error bg-red-100 text-red-700' }} badge-sm border-none">
                                    {{ $trend >= 0 ? '+' : '' }}{{ number_format($trend, 2) }}%
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-base-content/50">Berdasarkan filter yang dipilih</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <div class="join">
                            <a href="{{ route('dashboard.index', ['type' => 'month']) }}"
                                class="join-item btn btn-xs sm:btn-sm {{ $type === 'month' ? 'btn-active' : '' }}">Bulan</a>
                            <a href="{{ route('dashboard.index', ['type' => '10_months']) }}"
                                class="join-item btn btn-xs sm:btn-sm {{ $type === '10_months' ? 'btn-active' : '' }}">10
                                Bulan</a>
                            <a href="{{ route('dashboard.index', ['type' => 'year']) }}"
                                class="join-item btn btn-xs sm:btn-sm {{ $type === 'year' ? 'btn-active' : '' }}">Tahun</a>
                            <button onclick="document.getElementById('range_modal').showModal()"
                                class="join-item btn btn-xs sm:btn-sm {{ $type === 'range' ? 'btn-active' : '' }}">Range</button>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="h-64 flex items-end justify-between gap-1 sm:gap-2 px-1">
                    @foreach ($chartDataScaled as $index => $scaledHeight)
                        <div class="w-full flex flex-col gap-1 items-center group relative"
                            style="height: {{ max($scaledHeight, 5) }}%">
                            <div
                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-neutral text-neutral-content text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                {{ $labels[$index] }}: {{ $chartData[$index] }}
                            </div>
                            <div class="w-full bg-secondary rounded-t-sm" style="height: 100%"></div>
                        </div>
                    @endforeach
                </div>
                <!-- X Axis Labels -->
                <div
                    class="flex justify-between text-[8px] sm:text-[10px] text-base-content/50 mt-2 px-1 overflow-x-auto pb-2">
                    @php
                        $step = count($labels) > 15 ? ceil(count($labels) / 10) : 1;
                    @endphp
                    @foreach ($labels as $index => $label)
                        @if ($index % $step == 0)
                            <span class="whitespace-nowrap">{{ $label }}</span>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-center gap-4 mt-4 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-secondary"></span> Jumlah Agenda
                    </div>
                </div>
            </div>
        </div>

        <!-- Range Selection Modal -->
        <dialog id="range_modal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Pilih Rentang Tahun</h3>
                <form action="{{ route('dashboard.index') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="type" value="range">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Dari Tahun</span></label>
                            <select name="start_year" class="select select-bordered w-full">
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" @selected($startYear == $y)>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Sampai Tahun</span></label>
                            <select name="end_year" class="select select-bordered w-full">
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" @selected($endYear == $y)>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-action">
                        <button type="button" class="btn"
                            onclick="document.getElementById('range_modal').close()">Batal</button>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Agenda --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Agenda</h3>
                    <div class="badge badge-ghost badge-sm">7 Hari Terakhir</div>
                </div>

                <div class="flex gap-6 mb-6">
                    <div>
                        <p class="text-xs text-base-content/60">Total Agenda</p>
                        <p class="font-bold text-lg">{{ $totalAgendaLast7Days }}</p>
                        <span class="text-[10px] flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-primary"></span> Agenda
                        </span>
                    </div>
                </div>

                <!-- Line Chart SVG -->
                <div class="h-40 relative flex items-end">
                    <svg viewBox="0 0 300 100" class="w-full h-full overflow-visible">
                        <!-- Background Grid -->
                        <line x1="0" y1="20" x2="300" y2="20" stroke="currentColor"
                            class="text-base-content/5" stroke-width="1" />
                        <line x1="0" y1="50" x2="300" y2="50" stroke="currentColor"
                            class="text-base-content/5" stroke-width="1" />
                        <line x1="0" y1="80" x2="300" y2="80" stroke="currentColor"
                            class="text-base-content/5" stroke-width="1" />

                        <!-- Agenda Path (Primary) -->
                        <path d="{{ $agendaPoints }}" fill="none" stroke="currentColor" class="text-primary"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @can('add-agenda')
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
            <a wire:navigate href="{{ route('agenda.create') }}" class="tooltip btn btn-circle btn-lg btn-primary"
                id="fab-add-agenda" data-tip="Add Agenda">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
    @endcan
</x-layout>
