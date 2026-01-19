<x-layout title="Data Absensi">
    <div class="p-6">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                    <a href="{{ route('agenda.index') }}" class="hover:text-primary transition-colors">Agenda</a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <span>Data Absensi</span>
                </div>
                <h1 class="text-2xl font-bold text-base-content">Data Absensi: {{ $agenda->title }}</h1>
                <p class="text-base-content/60">{{ $agenda->opdMaster->name }} |
                    {{ \Carbon\Carbon::parse($agenda->date)->format('d M Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('agenda.export', $agenda->uuid) }}" class="btn btn-primary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>

                    Download PDF
                </a>
                <a href="{{ route('agenda.index') }}" class="btn btn-base-300">Kembali</a>
            </div>
        </div>

        @foreach ($agenda->sessions as $session)
            <div class="card bg-base-100 shadow-sm mb-8">
                <div class="card-body p-0">
                    <div
                        class="p-6 border-b border-base-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold">{{ $session->session_name }}</h2>
                            <p class="text-sm text-base-content/60">Tipe: <span
                                    class="badge badge-sm badge-ghost">{{ $session->session_type }}</span> | Waktu:
                                {{ $session->start_at->format('H:i') }} - {{ $session->end_at->format('H:i') }} WIB</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-2xl font-bold text-primary">{{ $session->absensis->count() }}</div>
                                <div class="text-[10px] uppercase font-bold opacity-50">Peserta Hadir</div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr class="bg-base-200/50">
                                    <th class="w-16 text-center">No</th>
                                    <th>Nama / NIP</th>
                                    <th>Instansi / Jabatan</th>
                                    <th>Kontak</th>
                                    <th class="text-center">Waktu Absen</th>
                                    <th class="text-center">Tanda Tangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($session->absensis as $index => $absensi)
                                    <tr class="hover:bg-base-200/30 transition-colors">
                                        <td class="text-center text-base-content/50 font-medium">{{ $index + 1 }}
                                        </td>
                                        <td>
                                            <div class="font-bold text-sm">{{ $absensi->name }}</div>
                                            <div class="text-[10px] opacity-50">{{ $absensi->nip_nik ?: '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm">{{ $absensi->asal_instansi }}</div>
                                            <div class="text-[10px] opacity-50">{{ $absensi->jabatan_pekerjaan }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm">{{ $absensi->handphone }}</div>
                                            <div class="text-[10px] opacity-50 italic">
                                                {{ str_replace('_', ' ', $absensi->asal_daerah) }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-medium">
                                                {{ $absensi->checkin_time->format('H:i:s') }}
                                            </div>
                                            <div class="text-[10px] opacity-50">
                                                {{ $absensi->checkin_time->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center">
                                                <div
                                                    class="bg-white p-1 rounded border border-base-200 w-24 h-12 flex items-center justify-center overflow-hidden">
                                                    <img src="{{ $absensi->ttd_path }}" alt="TTD"
                                                        class="max-w-full max-h-full object-contain contrast-125">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <div class="flex flex-col items-center justify-center text-base-content/30">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-12 h-12 mb-2 opacity-20">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                </svg>
                                                <p class="text-sm">Belum ada peserta yang mengisi absensi pada sesi ini.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
