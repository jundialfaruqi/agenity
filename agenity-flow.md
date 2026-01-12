# 📅 Sistem Agenda & Absensi Digital

Sistem ini adalah aplikasi manajemen agenda dan absensi digital berbasis QR Code yang mendukung:

-   Agenda public & private
-   Event online, offline, dan hybrid
-   Absensi berbasis waktu & QR
-   Tanda tangan digital
-   Link materi, Zoom, YouTube, dll setelah absen
-   Export PDF laporan
-   Style card, button, table, statistic, search, pagination, untuk halaman agenda wajib 100% sama dengan halaman /users
-   Halaman public absensi yg dihasilkan dari agenda, buat menggunakan halaman baru (file html penuh) atau layuout sendiri tapi tetap pakai style daisy ui dan tailwind css yg seragam.

Dirancang untuk kebutuhan instansi, OPD, seminar, dan event formal.

---

## 🚀 Fitur Utama

-   Manajemen agenda (rapat, sosialisasi, seminar, dll)
-   QR Code absensi otomatis
-   Link absensi berbasis token & waktu
-   Absensi hanya aktif di jam yang ditentukan
-   Tanda tangan digital
-   Halaman sukses dengan link:
    -   Paparan
    -   Zoom / Google Meet
    -   YouTube Live
    -   Link tambahan
-   Laporan absensi (PDF)

---

## 🧠 Konsep Sistem

Sistem ini memisahkan:

-   **Agenda** → data acara & link
-   **Session** → kontrol QR & waktu
-   **Absensi** → data kehadiran

---

## 🗂️ Struktur Database

### 🗓️ `agendas`

Menyimpan informasi event & link kegiatan.

| Field                  | Keterangan                |
| ---------------------- | ------------------------- |
| id                     | Primary key               |
| master_opd_id          | OPD penyelenggara         |
| user_id                | Admin pembuat agenda      |
| title                  | Judul acara               |
| jenis_agenda           | rapat, seminar, dll       |
| visibility             | public / private          |
| mode                   | online / offline / hybrid |
| date                   | Tanggal                   |
| start_time             | Jam mulai                 |
| end_time               | Jam selesai               |
| location               | Lokasi                    |
| link_paparan           | Link materi               |
| link_zoom              | Link Zoom / Meet          |
| link_streaming_youtube | YouTube Live              |
| link_lainnya           | Link tambahan             |
| ket_link_lainnya       | Keterangan link           |
| catatan                | Catatan internal          |
| status                 | draft, active, finished   |
| timestamps             | created_at, updated_at    |

---

### 🔗 `agenda_sessions`

Mengontrol QR Code & waktu absensi.

| Field        | Keterangan             |
| ------------ | ---------------------- |
| id           | Primary key            |
| agenda_id    | Relasi ke agenda       |
| session_name | Nama sesi              |
| session_type | online / offline       |
| token        | Token unik             |
| qr_code_path | Path QR                |
| start_at     | Waktu buka             |
| end_at       | Waktu tutup            |
| is_active    | Aktif / nonaktif       |
| timestamps   | created_at, updated_at |

---

### 🧾 `absensis`

Data kehadiran peserta.

| Field             | Keterangan             |
| ----------------- | ---------------------- |
| id                | Primary key            |
| agenda_session_id | Relasi ke session      |
| name              | Nama                   |
| nip_nik           | NIP / NIK (opsional)   |
| handphone         | Nomor HP               |
| asal_daerah       | dalam_kota / luar_kota |
| master_opd_id     | OPD (opsional)         |
| asal_instansi     | Instansi               |
| jabatan_pekerjaan | Jabatan                |
| ttd_path          | Tanda tangan           |
| checkin_time      | Waktu absen            |
| ip_address        | IP                     |
| user_agent        | Perangkat              |
| timestamps        | created_at, updated_at |

---

## 🔄 Alur Sistem

### 1. Admin Membuat Agenda

-   Admin mengisi data agenda & link
-   Sistem otomatis membuat:
    -   1 `agenda_session`
    -   Token
    -   QR Code
    -   URL absensi

---

### 2. Peserta Absen

Peserta membuka:

Sistem memvalidasi:

-   Token valid
-   Session aktif
-   Waktu sesuai

---

### 3. Submit Absensi

Data disimpan ke tabel `absensis`

---

### 4. Halaman Sukses

Setelah submit, sistem menampilkan:

-   Status sukses
-   Judul agenda
-   Link:
    -   Paparan
    -   Zoom
    -   YouTube
    -   Link lainnya

(Link ditarik dari tabel `agendas`)

---

## 📄 Laporan

Admin dapat mengunduh:

-   PDF per agenda
-   PDF per sesi absensi
-   Rekap per OPD / instansi

---

## 🛡️ Keamanan

-   Token QR unik
-   Absensi berbasis waktu
-   IP & device tracking
-   Sesi bisa ditutup manual

---

## 🧩 Cocok Untuk

-   OPD & Instansi
-   Seminar & Sosialisasi
-   Pelatihan
-   Rapat Hybrid
-   Event skala besar

---

## 🏷️ Nama Aplikasi

Contoh branding:

-   **AGENITY**
