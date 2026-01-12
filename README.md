# 🚀 Agenity: Digital Agenda & Attendance Identity System

**Agenity** adalah sistem identitas digital yang dirancang khusus untuk mengelola agenda kerja dan kehadiran secara terintegrasi. Dengan fokus pada manajemen hak akses dan struktur organisasi (OPD), Agenity memberikan solusi modern untuk efisiensi birokrasi dan akuntabilitas data dalam satu platform yang aman dan responsif.

---

## 🛠 Spesifikasi Aplikasi

Aplikasi ini ditenagai oleh kombinasi _tech stack_ mutakhir:

-   **PHP:** ^8.2
-   **Laravel:** ^12.0
-   **Spatie Laravel Permission:** ^6.24
-   **Tailwind CSS:** ^4.0
-   **Daisy UI:** ^5.5.14
-   **Livewire:** ^3.7.3
-   **Sanctum:** ^12.0
-   **Scramble:** ^0.13.10

---

## ✨ Fitur Utama

-   **Manajemen User & Role (RBAC):** Kontrol akses mendalam menggunakan Spatie Laravel Permission dengan proteksi otomatis berdasarkan hierarki organisasi (Admin-OPD vs Super Admin).
-   **Keamanan Data Berbasis OPD:** Filter cerdas yang membatasi Role `admin-opd` agar hanya dapat melihat, mencari, dan mengelola data agenda milik sendiri atau data dalam satu instansi (OPD) yang sama.
-   **Manajemen Agenda & Absensi:** Sistem pengelolaan agenda yang terintegrasi dengan fitur absensi publik, lengkap dengan ekspor data dan validasi kepemilikan.
-   **Optimasi UX & Anti-Duplikasi:** Penanganan submit absensi menggunakan pola _Post-Redirect-Get_ (PRG) untuk mencegah duplikasi data saat reload halaman.
-   **UI Modern & Konsisten:** Antarmuka responsif menggunakan Tailwind CSS & DaisyUI dengan komponen modal konfirmasi yang seragam untuk setiap aksi kritikal.
-   **Autentikasi Pintar:** Sistem deteksi sesi aktif yang secara otomatis mengalihkan user yang sudah login dari halaman login ke dashboard.
-   **Manajemen OPD (Organisasi Perangkat Daerah):** Pengelolaan data master OPD yang terintegrasi erat dengan profil user dan filter data aplikasi.
-   **Profil Dinamis & Pengaturan:** Kustomisasi profil (avatar/banner) dan pengaturan branding aplikasi (nama, logo, tema login) secara real-time dari dashboard.
-   **Automated Maintenance:** Sistem pembersihan otomatis file storage lama dan verifikasi infrastruktur yang terintegrasi dalam proses seeding.

---

## 🏗 Panduan Setup (Langkah demi Langkah)

Ikuti perjalanan singkat ini untuk menghidupkan Agenity di mesin lokal Anda:

### 1. Mempersiapkan Bahan Baku

Langkah pertama adalah mengunduh semua dependensi PHP yang dibutuhkan:

```bash
composer install
```

### 2. Mengatur Napas Aplikasi (Environment)

Salin konfigurasi dasar dan atur koneksi database Anda:

```bash
cp .env.example .env
```

_Jangan lupa buka file `.env` dan sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan lingkungan Anda._

### 3. Memberikan Identitas (App Key)

Hasilkan kunci keamanan unik untuk aplikasi Anda:

```bash
php artisan key:generate
```

### 4. Membangun Struktur & Menanam Data Dasar

Langkah krusial! Kita akan membangun tabel database dan mengisi data awal (Permissions, Roles, OPD, & Users) yang sudah kita rancang dengan apik:

```bash
php artisan migrate --seed
```

**Hasil Seeding yang akan Anda lihat di terminal:**
Saat proses selesai, Anda akan disambut dengan tabel informasi yang terlihat profesional seperti ini:

```text
🚀 Starting Database Seeding...

Step 0: Pre-seeding Cleanup & Checks...
✔ Storage link verified.
✔ Cleaned avatars directory.
✔ Cleaned banners directory.
✔ Cleaned logo directory.
✔ Cleaned opd_logos directory.

Step 1: Creating Permissions...
✔ Permissions created successfully.

Step 2: Creating Roles...
✔ Roles created successfully.

Step 3: Syncing Permissions...
✔ All permissions synced to Super Admin.
✔ Example permissions synced to User Example Role.

Step 4: Creating OPD Masters...
✔ OPD Masters created successfully.

Step 5: Creating Users & Assigning Roles...
+--------------+---------------------+----------+--------------+--------+
| Name         | Email               | Password | Role         | Status |
+--------------+---------------------+----------+--------------+--------+
| Super Admin  | superadmin@mail.com | password | super-admin  | active |
| Admin OPD    | adminopd@mail.com   | password | admin-opd    | active |
| Regular User | user@mail.com       | password | user         | active |
| User Example | user@example.com    | string   | user-example | active |
+--------------+---------------------+----------+--------------+--------+

✨ Database Seeding Completed Successfully! ✨

Step 6: Initializing App Settings...
✔ App settings initialized.
```

### 5. Mempercantik Tampilan (Frontend)

Pasang semua kebutuhan aset visual:

```bash
npm install
```

### 6. Menghidupkan Mesin

Nyalakan server pengembangan Anda:

```bash
php artisan serve
```

---

## 🌐 Akses Aplikasi

Setelah mesin menyala, Agenity siap dijelajahi:

-   **URL Utama:** [http://localhost:8000/](http://localhost:8000/)
-   **Pintu Masuk (Login):** [http://localhost:8000/login](http://localhost:8000/login)

---

## 🔐 API Documentation (Sanctum)

Agenity juga dilengkapi dengan API Auth yang siap digunakan untuk integrasi aplikasi pihak ketiga atau mobile:

### 📖 Dokumentasi Interaktif

Anda dapat mengakses dokumentasi API yang dihasilkan secara otomatis oleh **Scramble** di:

-   **API Docs:** [http://localhost:8000/docs/api](http://localhost:8000/docs/api)

### 🚀 Endpoint Utama

| Method | Endpoint      | Keterangan                     | Proteksi |
| :----- | :------------ | :----------------------------- | :------- |
| `POST` | `/api/login`  | Login & dapatkan Bearer Token  | Public   |
| `GET`  | `/api/me`     | Ambil detail profil user aktif | Sanctum  |
| `POST` | `/api/logout` | Revoke token & logout          | Sanctum  |

### 🔑 Cara Penggunaan (Bearer Token)

Setelah mendapatkan `token` dari endpoint login, sertakan token tersebut pada header setiap request yang membutuhkan proteksi:

```http
Authorization: Bearer {your_token_here}
```

---

Gunakan kredensial dari tabel hasil _seeding_ di atas untuk mulai bereksplorasi. Selamat mencoba! 🚀
