<x-welcome-layout :title="$event->title">
    <main class="grow py-8 lg:py-12">
        <div class="container mx-auto px-4 lg:px-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden">
                        <div class="h-4 bg-secondary"></div>
                        <div class="card-body p-6 lg:p-10">
                            <div class="flex flex-wrap gap-2 mb-6">
                                <div class="badge badge-success font-bold uppercase text-[10px] p-3">
                                    {{ $event->status }}</div>
                                <div class="badge badge-outline font-bold uppercase text-[10px] p-3">
                                    {{ $event->jenis_event }}</div>
                                <div class="badge badge-ghost font-bold uppercase text-[10px] p-3">{{ $event->mode }}
                                </div>
                            </div>

                            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight mb-4 text-base-content">
                                {{ $event->title }}</h1>

                            <div class="flex items-center gap-4 p-4 bg-base-200 rounded-2xl">
                                <div class="avatar placeholder">
                                    <div class="bg-base text-primary-content rounded-lg w-12">
                                        @if ($event->opdMaster->logo_url)
                                            <img src="{{ $event->opdMaster->logo_url }}"
                                                alt="{{ $event->opdMaster->name }}" />
                                        @else
                                            <span
                                                class="text-xl font-bold">{{ substr($event->opdMaster->singkatan, 0, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-base-content">{{ $event->opdMaster->name }}
                                    </div>
                                    <div class="text-xs text-base-content/60">Penyelenggara Event</div>
                                </div>
                            </div>

                            <div class="max-w-none text-base-content/80 leading-relaxed mb-8 mt-8">
                                @if ($event->content)
                                    <div class="event-content mb-12">
                                        <div class="event-detail-body">
                                            {!! $event->content !!}
                                        </div>
                                    </div>
                                    <div class="border-t-2 border-dotted border-base-300"></div>
                                @endif

                                <h3 class="text-xl font-bold text-base-content mt-8 mb-3">Catatan Event</h3>
                                {!! nl2br(e($event->catatan ?? 'Tidak ada catatan tambahan untuk event ini.')) !!}

                                @if ($event->link_streaming_youtube || $event->link_lainnya)
                                    <div class="mt-8 space-y-4">
                                        @if ($event->link_streaming_youtube)
                                            <div
                                                class="p-4 bg-red-50 border border-red-100 rounded-xl flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="text-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            viewBox="0 0 24 24" class="w-6 h-6">
                                                            <path
                                                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 4-8 4z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-[10px] font-bold text-red-600 uppercase tracking-wider">
                                                            Live Streaming</div>
                                                        <div
                                                            class="text-sm font-bold text-base-content truncate max-w-50 md:max-w-xs">
                                                            YouTube</div>
                                                    </div>
                                                </div>
                                                <a href="{{ $event->link_streaming_youtube }}" target="_blank"
                                                    class="btn btn-sm btn-error text-white">Tonton</a>
                                            </div>
                                        @endif

                                        @if ($event->link_lainnya)
                                            <div
                                                class="p-4 bg-base-200 rounded-xl flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-[10px] font-bold text-base-content/60 uppercase tracking-wider">
                                                            {{ $event->ket_link_lainnya ?? 'Link Tambahan' }}</div>
                                                        <div
                                                            class="text-sm font-bold text-base-content truncate max-w-50 md:max-w-xs">
                                                            {{ $event->link_lainnya }}</div>
                                                    </div>
                                                </div>
                                                <a href="{{ $event->link_lainnya }}" target="_blank"
                                                    class="btn btn-sm btn-ghost border-base-300">Buka</a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="border-t-2 border-dotted border-base-300 mb-8"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Tanggal</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ \Carbon\Carbon::parse($event->date)->locale('id')->translatedFormat('l, d F Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Waktu</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Lokasi</div>
                                        <div class="text-base font-bold text-base-content">
                                            {{ $event->location ?? 'Online / TBD' }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="p-3 bg-primary/10 text-primary rounded-xl h-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div
                                            class="text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">
                                            Admin / PIC</div>
                                        <div class="text-base font-bold text-base-content">{{ $event->user->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Upcoming Events -->
                <div class="space-y-6">
                    <div class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden sticky top-24">
                        <div class="bg-secondary p-4 text-center">
                            <h3 class="text-secondary-content font-bold">Event Mendatang</h3>
                            <p class="text-secondary-content/70 text-xs mt-1">Event lain yang akan segera hadir</p>
                        </div>
                        <div class="card-body p-4 space-y-4">
                            @forelse($upcomingEvents as $upcoming)
                                <a href="{{ route('event.public_detail', $upcoming->slug) }}"
                                    class="group block p-3 rounded-xl hover:bg-base-200 transition-all border border-transparent hover:border-base-300">
                                    <div class="flex gap-3">
                                        <div
                                            class="flex-none w-12 h-12 bg-primary/10 rounded-lg flex flex-col items-center justify-center text-primary group-hover:bg-primary group-hover:text-primary-content transition-colors">
                                            <span
                                                class="text-xs font-bold leading-none">{{ \Carbon\Carbon::parse($upcoming->date)->translatedFormat('d') }}</span>
                                            <span
                                                class="text-[10px] uppercase font-bold leading-none mt-1">{{ \Carbon\Carbon::parse($upcoming->date)->translatedFormat('M') }}</span>
                                        </div>
                                        <div class="grow min-w-0">
                                            <h4
                                                class="text-sm font-bold text-base-content truncate group-hover:text-primary transition-colors">
                                                {{ $upcoming->title }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="text-[10px] text-base-content/50 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($upcoming->start_time)->format('H:i') }}
                                                </div>
                                                <div class="badge badge-ghost badge-xs text-[9px] uppercase font-bold">
                                                    {{ $upcoming->opdMaster->singkatan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <div class="p-3 bg-base-200 rounded-full w-fit mx-auto mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 text-base-content/30">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                    </div>
                                    <p class="text-xs text-base-content/50">Tidak ada event mendatang lainnya</p>
                                </div>
                            @endforelse

                            <div class="pt-2 border-t border-base-200">
                                <a href="{{ url('/') }}#events"
                                    class="btn btn-sm btn-block btn-ghost text-xs">Lihat Semua Event</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-welcome-layout>
