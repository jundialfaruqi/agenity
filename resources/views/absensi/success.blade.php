<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil - {{ $session->agenda->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="card bg-base-100 shadow-2xl overflow-hidden">
            <div class="bg-success p-8 flex justify-center">
                <div class="rounded-full bg-white/20 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="card-body items-center text-center py-10">
                <h2 class="card-title text-2xl font-bold text-success mb-2">Absensi Berhasil!</h2>
                <p class="text-base-content/70 mb-6">Terima kasih, data kehadiran Anda telah berhasil direkam dalam
                    sistem.</p>

                <div class="bg-base-200 rounded-xl p-4 w-full mb-6 text-left">
                    <div class="text-xs opacity-50 uppercase font-bold mb-1">Nama Peserta</div>
                    <div class="font-bold text-lg mb-3">{{ $absensi->name }}</div>

                    <div class="text-xs opacity-50 uppercase font-bold mb-1">Kegiatan</div>
                    <div class="font-medium text-sm">{{ $session->agenda->title }}</div>
                    <div class="text-xs opacity-70 italic mt-1">{{ $session->session_name }}</div>

                    @if (
                        $session->agenda->link_paparan ||
                            $session->agenda->link_zoom ||
                            $session->agenda->link_streaming_youtube ||
                            $session->agenda->link_lainnya ||
                            $session->agenda->catatan)
                        <div class="divider my-2 opacity-20"></div>

                        <div class="space-y-4">
                            @if ($session->agenda->link_paparan)
                                <div class="flex flex-col">
                                    <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Link Paparan / Materi
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ $session->agenda->link_paparan }}" target="_blank"
                                            class="btn btn-xs btn-primary normal-case flex-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Visit
                                        </a>
                                        <button onclick="copyToClipboard('{{ $session->agenda->link_paparan }}', this)"
                                            class="btn btn-xs btn-outline btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if ($session->agenda->link_zoom)
                                <div class="flex flex-col">
                                    <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Link Zoom / Meeting
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ $session->agenda->link_zoom }}" target="_blank"
                                            class="btn btn-xs btn-info normal-case flex-1 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Visit
                                        </a>
                                        <button onclick="copyToClipboard('{{ $session->agenda->link_zoom }}', this)"
                                            class="btn btn-xs btn-outline btn-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if ($session->agenda->link_streaming_youtube)
                                <div class="flex flex-col">
                                    <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Link Streaming YouTube
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ $session->agenda->link_streaming_youtube }}" target="_blank"
                                            class="btn btn-xs btn-error normal-case flex-1 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Visit
                                        </a>
                                        <button
                                            onclick="copyToClipboard('{{ $session->agenda->link_streaming_youtube }}', this)"
                                            class="btn btn-xs btn-outline btn-error">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if ($session->agenda->link_lainnya)
                                <div class="flex flex-col">
                                    <div class="text-[10px] opacity-50 uppercase font-bold mb-1">
                                        {{ $session->agenda->ket_link_lainnya ?? 'Link Lainnya' }}</div>
                                    <div class="flex gap-2">
                                        <a href="{{ $session->agenda->link_lainnya }}" target="_blank"
                                            class="btn btn-xs btn-neutral normal-case flex-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                            Visit
                                        </a>
                                        <button
                                            onclick="copyToClipboard('{{ $session->agenda->link_lainnya }}', this)"
                                            class="btn btn-xs btn-outline btn-neutral">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if ($session->agenda->catatan)
                                <div class="pt-2">
                                    <div class="text-[10px] opacity-50 uppercase font-bold mb-1">Catatan Tambahan</div>
                                    <p
                                        class="text-xs italic opacity-70 bg-base-300 p-2 rounded border-l-2 border-primary">
                                        {{ $session->agenda->catatan }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-2 w-full">
                    <div class="text-xs opacity-50 mb-2 italic">Halaman ini dapat Anda tutup sekarang.</div>
                    <a href="{{ route('welcome') }}" class="btn btn-neutral btn-block">Tutup Halaman</a>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-sm opacity-50">
            &copy; {{ date('Y') }} {{ $appSetting->app_name ?? config('app.name') }}
        </div>
    </div>
    <script>
        function copyToClipboard(text, btn) {
            const originalContent = btn.innerHTML;

            function showSuccess() {
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Copied
                `;
                btn.classList.add('btn-success', 'text-white');
                btn.classList.remove('btn-outline');

                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-outline');
                }, 2000);
            }

            // Try modern Clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showSuccess();
                }).catch(err => {
                    console.error('Modern Clipboard API failed: ', err);
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                // Fallback to execCommand for mobile/non-secure
                fallbackCopyTextToClipboard(text);
            }

            function fallbackCopyTextToClipboard(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                
                // Ensure it's not visible and doesn't scroll the page
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                
                textArea.focus();
                textArea.select();

                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        showSuccess();
                    } else {
                        console.error('Fallback copy failed');
                        alert('Gagal menyalin link');
                    }
                } catch (err) {
                    console.error('Fallback error: ', err);
                    alert('Gagal menyalin link');
                }

                document.body.removeChild(textArea);
            }
        }
    </script>
</body>

</html>
