<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Absensi - {{ $agenda->title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .info-label { width: 120px; font-weight: bold; }
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .main-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .signature-img { max-height: 40px; display: block; margin: 0 auto; }
        .footer { margin-top: 30px; text-align: right; }
        .footer-space { height: 80px; }
        .page-break { page-break-after: always; }
        .text-center { text-align: center !important; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DAFTAR HADIR DIGITAL</h1>
        <p>{{ $agenda->opdMaster->name }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Judul Agenda</td>
            <td>: {{ $agenda->title }}</td>
        </tr>
        <tr>
            <td class="info-label">Jenis Agenda</td>
            <td>: {{ $agenda->jenis_agenda }}</td>
        </tr>
        <tr>
            <td class="info-label">Hari / Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td class="info-label">Waktu</td>
            <td>: {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="info-label">Lokasi</td>
            <td>: {{ $agenda->location ?? 'Online' }}</td>
        </tr>
    </table>

    @foreach($agenda->sessions as $session)
        <div style="margin-top: 20px;">
            <h3 style="background: #eee; padding: 5px;">Sesi: {{ $session->session_name }}</h3>
            <table class="main-table">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Nama / NIP</th>
                        <th>Instansi / Jabatan</th>
                        <th width="80">Waktu Hadir</th>
                        <th width="100">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($session->absensis as $index => $absensi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $absensi->name }}</strong><br>
                                <small>{{ $absensi->nip_nik ?? '-' }}</small>
                            </td>
                            <td>
                                {{ $absensi->asal_instansi }}<br>
                                <small>{{ $absensi->jabatan_pekerjaan }}</small>
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($absensi->checkin_time)->format('H:i:s') }}</td>
                            <td class="text-center">
                                @if($absensi->ttd_path)
                                    <img src="{{ $absensi->ttd_path }}" class="signature-img">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada peserta yang hadir pada sesi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}</p>
        <div class="footer-space"></div>
        <p><strong>( __________________________ )</strong></p>
        <p>Panitia Penyelenggara</p>
    </div>
</body>
</html>
