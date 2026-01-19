<x-layout title="Hasil Survei">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Hasil Survei: {{ $survey->title }}</h1>
            <p class="text-sm text-base-content/60 mt-1">Rekapitulasi jawaban responden</p>
        </div>
        <div class="flex items-center gap-2">
            @if ($survey->visibility === 'private' && $survey->tokens->count() > 0)
                <button class="btn btn-secondary btn-sm gap-2"
                    onclick="copyResultLink('{{ route('survey.private_access', $survey->tokens->first()->token) }}', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0-10.628a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm0 10.628a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    </svg>
                    Salin Link
                </button>
            @elseif($survey->visibility === 'public')
                <button class="btn btn-secondary btn-sm gap-2"
                    onclick="copyResultLink('{{ route('survey.public_detail', $survey->slug) }}', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0-10.628a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm0 10.628a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    </svg>
                    Salin Link
                </button>
            @endif
            <a href="{{ route('survey.export_pdf', $survey) }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Unduh PDF
            </a>
            <a href="{{ route('survey.edit', $survey) }}" class="btn btn-outline btn-sm">Edit Survei</a>
            <a href="{{ route('survey.index') }}" class="btn btn-ghost btn-sm">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div class="text-xs uppercase tracking-widest opacity-50 font-bold">Total Responden</div>
                    @if ($survey->max_respondents)
                        <div class="badge badge-primary badge-outline badge-xs">
                            {{ round(($survey->respondents->count() / $survey->max_respondents) * 100) }}%
                        </div>
                    @endif
                </div>
                <div class="flex items-baseline gap-1 mt-1">
                    <div class="text-3xl font-black">{{ $survey->respondents->count() }}</div>
                    @if ($survey->max_respondents)
                        <div class="text-sm opacity-40">/ {{ $survey->max_respondents }}</div>
                    @endif
                </div>
                @if ($survey->max_respondents)
                    <progress class="progress progress-primary w-full h-1.5 mt-2"
                        value="{{ $survey->respondents->count() }}" max="{{ $survey->max_respondents }}"></progress>
                @endif
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-5">
                <div class="text-xs uppercase tracking-widest opacity-50 font-bold">Status</div>
                <div class="mt-2">
                    @if ($survey->is_active)
                        <span class="badge badge-success text-white">Aktif</span>
                    @else
                        <span class="badge badge-ghost">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-5">
                <div class="text-xs uppercase tracking-widest opacity-50 font-bold">Periode</div>
                <div class="text-sm font-bold mt-2">
                    {{ $survey->start_date->format('d/m/y') }} - {{ $survey->end_date->format('d/m/y') }}
                </div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-5">
                <div class="text-xs uppercase tracking-widest opacity-50 font-bold">OPD</div>
                <div class="text-sm font-bold mt-2">{{ $survey->opd->singkatan }}</div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        @foreach ($results as $result)
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge badge-neutral badge-sm">{{ $loop->iteration }}</span>
                                <span
                                    class="badge badge-ghost badge-sm uppercase text-[10px] font-bold">{{ str_replace('_', ' ', $result['type']) }}</span>
                            </div>
                            <h3 class="text-lg font-bold">{{ $result['text'] }}</h3>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-black">{{ $result['total_responses'] }}</div>
                            <div class="text-[10px] uppercase opacity-50 font-bold">Jawaban</div>
                        </div>
                    </div>

                    @if (in_array($result['type'], ['single_choice', 'multiple_choice', 'rating']))
                        <div class="space-y-4">
                            @foreach ($result['data'] as $data)
                                <div class="space-y-1">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium">{{ $data['label'] }}</span>
                                        <span class="font-bold">{{ $data['count'] }}
                                            ({{ $data['percentage'] }}%)
                                        </span>
                                    </div>
                                    <div class="w-full bg-base-200 rounded-full h-2.5">
                                        <div class="bg-primary h-2.5 rounded-full transition-all duration-500"
                                            style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach

                            @if ($result['type'] === 'rating' && isset($result['average_rating']))
                                <div class="mt-6 pt-6 border-t border-base-200 flex items-center gap-4">
                                    <div class="text-4xl font-black text-warning">{{ $result['average_rating'] }}</div>
                                    <div>
                                        <div class="rating rating-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div
                                                    class="mask mask-star-2 {{ $i <= round($result['average_rating']) ? 'bg-warning' : 'bg-base-300' }} w-4 h-4">
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="text-xs opacity-50 uppercase font-bold tracking-widest">Rata-rata
                                            Rating</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        {{-- Text Answers --}}
                        <div class="bg-base-200/50 rounded-xl p-4">
                            <h4 class="text-xs uppercase font-bold opacity-50 mb-3 tracking-widest">10 Jawaban Terbaru
                            </h4>
                            <div class="space-y-3">
                                @forelse($result['data'] as $text)
                                    <div class="p-3 bg-base-100 rounded-lg border border-base-300 text-sm">
                                        {{ $text }}
                                    </div>
                                @empty
                                    <div class="text-sm italic opacity-50 text-center py-4">Belum ada jawaban teks.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script>
            function copyResultLink(text, btn) {
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Tersalin!
                `;
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-success', 'text-white');

                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-secondary');
                }, 2000);
            }
        </script>
    @endpush
</x-layout>
