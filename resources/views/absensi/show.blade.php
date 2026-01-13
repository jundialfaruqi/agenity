<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - {{ $session->agenda->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        .signature-pad {
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            height: 200px;
            background-color: white;
        }
    </style>
</head>

<body class="bg-base-200 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header Card -->
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body items-center text-center">
                <div class="avatar mb-4">
                    <div class="w-24 rounded-lg">
                        <img
                            src="{{ $session->agenda->opdMaster->logo_url ?? 'https://ui-avatars.com/api/?name=OPD' }}" />
                    </div>
                </div>
                <h2 class="card-title text-2xl font-bold">{{ $session->agenda->title }}</h2>
                <div class="badge badge-primary">{{ $session->session_name }}</div>
                <div class="mt-4 flex flex-col gap-1 text-sm opacity-70 font-medium">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        {{ \Carbon\Carbon::parse($session->agenda->date)->translatedFormat('d F Y') }}
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($session->start_at)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($session->end_at)->format('H:i') }} WIB
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        {{ $session->agenda->location ?? 'Online' }}
                    </div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Formulir Kehadiran</h3>
                <form action="{{ route('absensi.store', $session->token) }}" method="POST" id="absensi-form">
                    @csrf
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold mb-2">Nama Lengkap</span></label>
                            <input name="name" type="text" placeholder="Masukkan nama sesuai KTP/NIP"
                                class="input input-bordered w-full"
                                value="{{ old('name', Auth::user()->name ?? '') }}">
                            @error('name')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold mb-2">NIP / NIK
                                    (Opsional)</span></label>
                            <input name="nip_nik" type="text" placeholder="Masukkan NIP atau NIK"
                                class="input input-bordered w-full" value="{{ old('nip_nik') }}">
                            @error('nip_nik')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold mb-2">No. Handphone /
                                    WhatsApp</span></label>
                            <input name="handphone" type="tel" placeholder="Contoh: 08123456789"
                                class="input input-bordered w-full"
                                value="{{ old('handphone', Auth::user()->phone ?? '') }}">
                            @error('handphone')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control" x-data="{ asal: '{{ old('asal_daerah', 'dalam_kota') }}' }">
                            <label class="label"><span class="label-text font-bold mb-2">Asal Daerah</span></label>
                            <div class="flex gap-4">
                                <label class="label cursor-pointer gap-2">
                                    <input type="radio" name="asal_daerah" value="dalam_kota"
                                        class="radio radio-secondary" x-model="asal">
                                    <span class="label-text">Dalam Kota</span>
                                </label>
                                <label class="label cursor-pointer gap-2">
                                    <input type="radio" name="asal_daerah" value="luar_kota"
                                        class="radio radio-secondary" x-model="asal">
                                    <span class="label-text">Luar Kota</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-control" x-data="{ isOpd: true }">
                            <label class="label"><span class="label-text font-bold mb-2">Instansi / Unit
                                    Kerja</span></label>
                            <div class="flex flex-col gap-2">
                                <select name="master_opd_id" id="master_opd_id" class="select select-bordered w-full"
                                    x-show="isOpd">
                                    <option value="">-- Pilih OPD --</option>
                                    <option value="lainnya">Lainnya / Instansi Luar</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" data-name="{{ $opd->name }}"
                                            @selected(old('master_opd_id', Auth::user()->opd_master_id ?? '') == $opd->id)>
                                            {{ $opd->name }}</option>
                                    @endforeach

                                </select>
                                <label class="label">
                                    <span class="label-text-alt text-primary text-xs">Jika instansi tidak ada di
                                        daftar,
                                        pilih
                                        <strong>Lainnya</strong> dan ketik manual di kolom bawah ini.</span>
                                </label>
                                <input name="asal_instansi" id="asal_instansi" type="text"
                                    placeholder="Ketik nama instansi anda disini..."
                                    class="input input-bordered w-full"
                                    value="{{ old('asal_instansi', Auth::user()->opdMaster->name ?? '') }}">

                            </div>
                            @error('asal_instansi')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold mb-2">Jabatan</span></label>
                            <input name="jabatan_pekerjaan" type="text" placeholder="Masukkan jabatan Anda"
                                class="input input-bordered w-full" value="{{ old('jabatan_pekerjaan') }}">
                            @error('jabatan_pekerjaan')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold mb-2 text-lg">Tanda Tangan
                                    Digital</span></label>
                            <div class="signature-pad-container">
                                <canvas id="signature-pad" class="signature-pad"></canvas>
                                <div class="mt-2 flex justify-between">
                                    <button type="button" id="clear"
                                        class="btn btn-sm btn-ghost text-error">Hapus TTD</button>
                                    <span class="text-xs opacity-50 italic">Silakan tanda tangan di atas kotak
                                        ini</span>
                                </div>
                            </div>
                            <input type="hidden" name="ttd" id="ttd-input">
                            @error('ttd')
                                <span class="text-xs text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary btn-block">Kirim Kehadiran</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center text-sm opacity-50">
            &copy; {{ date('Y') }} {{ $appSetting->app_name ?? config('app.name') }} - Digital Agenda & Attendance
            Identity System
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            document.getElementById('clear').addEventListener('click', function() {
                signaturePad.clear();
            });

            document.getElementById('absensi-form').addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert('Silakan isi tanda tangan terlebih dahulu.');
                } else {
                    document.getElementById('ttd-input').value = signaturePad.toDataURL();
                }
            });

            // Auto-fill asal_instansi when OPD is selected
            const opdSelect = document.getElementById('master_opd_id');
            const asalInstansiInput = document.getElementById('asal_instansi');

            opdSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const opdName = selectedOption.getAttribute('data-name');

                if (this.value === 'lainnya' || this.value === '') {
                    asalInstansiInput.value = '';
                    asalInstansiInput.focus();
                } else if (opdName) {
                    asalInstansiInput.value = opdName;
                }
            });
        });
    </script>
</body>

</html>
