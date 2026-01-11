# 🚀 Monetra: Gerbang Manajemen User & Role Anda

Selamat datang di **Monetra**, sebuah aplikasi manajemen hak akses yang dirancang dengan presisi untuk memberikan kendali penuh atas sistem Anda. Monetra dibangun dengan pondasi teknologi modern yang menjamin kecepatan, keamanan, dan pengalaman pengguna yang luar biasa.

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

-   **Manajemen User & Role:** Kontrol penuh menggunakan Spatie Laravel Permission dengan UI yang intuitif.
-   **Profil Dinamis:** Halaman profil modern dengan fitur upload foto profil dan banner secara real-time.
-   **Pengaturan Aplikasi (App Settings):** Kustomisasi nama aplikasi, logo, serta judul dan deskripsi halaman login langsung dari dashboard (Tab Settings di Profil).
-   **UI Modern & Responsif:** Dibangun dengan Tailwind CSS dan DaisyUI untuk pengalaman pengguna yang maksimal di berbagai perangkat.
-   **Sistem Notifikasi Toast:** Feedback instan yang elegan untuk setiap aksi pengguna.
-   **Automated Maintenance:** Pembersihan otomatis file storage lama dan pengecekan storage link yang terintegrasi dalam sistem seeder.

---

## 🏗 Panduan Setup (Langkah demi Langkah)

Ikuti perjalanan singkat ini untuk menghidupkan Monetra di mesin lokal Anda:

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

Langkah krusial! Kita akan membangun tabel database dan mengisi data awal (Permissions, Roles, & Users) yang sudah kita rancang dengan apik:

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
✔ logo directory is already clean.

Step 1: Creating Permissions...
✔ Permissions created successfully.

Step 2: Creating Roles...
✔ Roles created successfully.

Step 3: Syncing Permissions...
✔ All permissions synced to Super Admin.
✔ Example permissions synced to User Example Role.

Step 4: Creating Users & Assigning Roles...
+--------------+---------------------+----------+--------------+--------+
| Name         | Email               | Password | Role         | Status |
+--------------+---------------------+----------+--------------+--------+
| Super Admin  | superadmin@mail.com | password | super-admin  | active |
| Admin        | admin@mail.com      | password | admin        | active |
| Regular User | user@mail.com       | password | user         | active |
| User Example | user@example.com    | string   | user-example | active |
+--------------+---------------------+----------+--------------+--------+

✨ Database Seeding Completed Successfully! ✨

Step 5: Initializing App Settings...
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

Setelah mesin menyala, Monetra siap dijelajahi:

-   **URL Utama:** [http://localhost:8000/](http://localhost:8000/)
-   **Pintu Masuk (Login):** [http://localhost:8000/login](http://localhost:8000/login)

---

## 🔐 API Documentation (Sanctum)

Monetra juga dilengkapi dengan API Auth yang siap digunakan untuk integrasi aplikasi pihak ketiga atau mobile:

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
