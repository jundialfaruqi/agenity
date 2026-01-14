# 📝 Survey Management System

Aplikasi ini digunakan untuk membuat, menyebarkan, dan mengelola survei yang dilakukan oleh OPD kepada masyarakat guna mengukur kepuasan, kebutuhan layanan, dan evaluasi program pemerintah.

---

## 🎯 Tujuan Sistem

-   **Mengumpulkan pendapat masyarakat** secara digital.
-   **Menyediakan data survei** yang valid dan terstruktur.
-   **Menjadi dasar evaluasi** dan pengambilan kebijakan Pemerintah Kota.
-   **Menghindari pengisian ganda** dan manipulasi data.

---

## 🧩 Konsep Sistem

Sistem ini berbasis **Survey – Question – Answer** dengan alur sebagai berikut:

1. **OPD** membuat Survei.
2. **OPD** menyusun Pertanyaan.
3. **Sistem** menghasilkan Link Survei.
4. **Masyarakat** mengisi survei melalui link tersebut.
5. **Sistem** menyimpan setiap jawaban secara aman.
6. **Admin/OPD** melihat hasil dalam bentuk rekapitulasi dan grafik.

---

## 🌐 Integrasi Halaman Publik

Konsep tampilan survei mengikuti pola yang sudah ada pada modul Agenda:

-   **Halaman Utama (`/`)**: Menampilkan section khusus untuk daftar survei yang memiliki status **Aktif** dan visibility **Public**. Section ini diletakkan secara harmonis di bawah daftar Agenda Pemko tanpa mengganggu tata letak yang ada.
-   **Halaman Detail (`survey-detail`)**: Setiap survei publik memiliki halaman detail tersendiri yang menampilkan informasi lengkap dan formulir pengisian, serupa dengan konsep halaman `public-detail` pada agenda.

---

## 👥 Peran Pengguna

| Peran           | Fungsi                                                   |
| :-------------- | :------------------------------------------------------- |
| **super-admin** | Mengelola seluruh survei & melihat laporan komprehensif. |
| **admin-opd**   | Membuat dan mengelola survei khusus milik instansinya.   |
| **Masyarakat**  | Mengisi survei melalui link publik tanpa perlu login.    |
| **Sistem**      | Melakukan validasi, penyimpanan, dan pengolahan data.    |

---

## 🗄️ Struktur Database

### 1. `surveys`

Menyimpan data utama survei.

| Field         | Keterangan                       |
| :------------ | :------------------------------- |
| `id`          | Primary Key                      |
| `opd_id`      | Relasi ke OPD pembuat            |
| `title`       | Judul survei                     |
| `description` | Deskripsi atau penjelasan survei |
| `start_date`  | Tanggal mulai survei             |
| `end_date`    | Tanggal selesai survei           |
| `is_active`   | Status aktif/non-aktif           |
| `visibility`  | Visibility (`public`, `private`) |
| `created_by`  | User ID pembuat                  |
| `created_at`  | Timestamp pembuatan              |

### 2. `survey_questions`

Menyimpan daftar pertanyaan untuk setiap survei.

| Field           | Keterangan                                                 |
| :-------------- | :--------------------------------------------------------- |
| `id`            | Primary Key                                                |
| `survey_id`     | Relasi ke tabel `surveys`                                  |
| `question_text` | Isi teks pertanyaan                                        |
| `type`          | Tipe: `single_choice`, `multiple_choice`, `text`, `rating` |
| `is_required`   | Boolean (Wajib diisi atau tidak)                           |
| `order`         | Urutan tampilan pertanyaan                                 |

### 3. `survey_options`

Pilihan jawaban untuk pertanyaan tipe pilihan (ganda/skala).

| Field         | Keterangan                         |
| :------------ | :--------------------------------- |
| `id`          | Primary Key                        |
| `question_id` | Relasi ke tabel `survey_questions` |
| `option_text` | Teks pilihan jawaban               |
| `value`       | Skor atau kode nilai jawaban       |

_Digunakan untuk: Pilihan ganda, Ya/Tidak, dan Skala Kepuasan._

### 4. `survey_respondents`

Menyimpan data identitas masyarakat yang mengisi survei.

| Field          | Keterangan                           |
| :------------- | :----------------------------------- |
| `id`           | Primary Key                          |
| `survey_id`    | Relasi ke survei yang diikuti        |
| `name`         | Nama responden                       |
| `phone`        | Nomor telepon (Opsional)             |
| `nik`          | NIK (Opsional)                       |
| `ip_address`   | Alamat IP untuk pencegahan duplikasi |
| `submitted_at` | Waktu pengiriman jawaban             |

### 5. `survey_answers`

Menyimpan detail jawaban dari responden.

| Field           | Keterangan                           |
| :-------------- | :----------------------------------- |
| `id`            | Primary Key                          |
| `respondent_id` | Relasi ke tabel `survey_respondents` |
| `question_id`   | Relasi ke tabel `survey_questions`   |
| `option_id`     | ID pilihan (jika tipe pilihan)       |
| `answer_text`   | Teks jawaban (jika tipe isian)       |
| `score`         | Nilai angka (jika tipe rating)       |

### 6. `survey_tokens` (Opsional)

Digunakan untuk link survei unik dan pencegahan spam.

| Field        | Keterangan                     |
| :----------- | :----------------------------- |
| `id`         | Primary Key                    |
| `survey_id`  | Relasi ke tabel `surveys`      |
| `token`      | Kode unik (UUID/Random String) |
| `is_used`    | Status pemakaian token         |
| `expired_at` | Masa berlaku token             |

---

## 🔐 Keamanan & Validasi

Sistem ini mencegah kecurangan dengan mekanisme:

-   **IP Address Tracking**: Memastikan satu koneksi tidak mengisi berulang kali secara tidak wajar.
-   **Token Link Unik**: (Opsional) Membatasi akses hanya bagi pemegang token.
-   **One-time Submission**: Menjamin satu responden hanya bisa melakukan submit satu kali per survei.

---

## 📊 Pengolahan Data

Data yang terkumpul dapat dianalisis dengan:

-   **Distribusi Jawaban**: `GROUP BY option_id` & `COUNT(*)` untuk melihat tren pilihan.
-   **Skor Kepuasan**: `AVG(score)` untuk menghitung indeks kepuasan rata-rata.

---

## 🎨 Standar UI & UX

Seluruh pengembangan modul survei **wajib** mengikuti standar antarmuka (UI) dan pengalaman pengguna (UX) yang sudah ditetapkan dalam aplikasi Agenity. Hal ini bertujuan untuk menjaga konsistensi 100% antara halaman publik dan dashboard admin.

### 🧩 Konsistensi Komponen

-   **Tombol & Icon**: Gunakan komponen tombol DaisyUI yang sudah ada (`btn-primary`, `btn-secondary`, dsb) dan library icon yang konsisten.
-   **Warna & Background**: Wajib menggunakan variabel warna Tailwind yang telah dikonfigurasi. Jangan menggunakan warna _custom_ di luar palet yang ada.
-   **Table & Input**: Gunakan desain tabel yang responsif dan komponen `input` atau `select` yang seragam dengan halaman manajemen user/OPD.
-   **Search & Filter**: Mekanisme pencarian dan filter harus mengikuti pola yang sudah ada (posisi di atas tabel, gaya input field, dsb).
-   **Card Summary**: Statistik atau ringkasan data harus menggunakan gaya _card_ yang sama dengan dashboard utama.

### 🛠️ Integrasi Tanpa Gangguan

Pengembangan fitur baru tidak boleh merusak atau mengganggu komponen yang sudah ada.

-   **Contoh Penempatan**: Jika ingin menambahkan daftar survei pada halaman utama (Welcome Page), section tersebut harus diletakkan **di bawah** section "Agenda Pemko Aktif".
-   **Layering**: Pastikan penggunaan _z-index_ atau posisi elemen tidak menutupi navigasi atau footer aplikasi.

---

## 🚀 Keunggulan Sistem

-   **Multi-OPD Support**: Mendukung penggunaan oleh berbagai instansi secara terisolasi.
-   **Concurrent Surveys**: Menjalankan banyak survei berbeda secara bersamaan.
-   **Versatile Question Types**: Fleksibel dalam menentukan jenis input data.
-   **Anti-Spam Protected**: Aman dari pengisian ganda yang merusak validitas data.
-   **Dashboard Ready**: Struktur data yang optimal untuk visualisasi grafik dan laporan.

---

## 🛠️ Setup & Migrasi

Jalankan perintah berikut untuk menambahkan permission yang diperlukan untuk modul survei ke dalam database:

```bash
php artisan db:seed --class=SurveyPermissionSeeder
```

---

## 🚀 Ketentuan Tambahan

-   **Waktu & Zona Waktu**: Setiap penggunaan waktu, tanggal, dan jam **wajib** menggunakan format timezone `Asia/Jakarta`.
-   **Integritas Data**: Selalu pastikan relasi antar tabel (terutama `survey_id` dan `opd_id`) tervalidasi dengan benar untuk mencegah kebocoran data antar instansi.
-   \*\*jangan pernah jalankan php artisan migrate, tapi jalankan php artisan migrate:fresh --seed.
