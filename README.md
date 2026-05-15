<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">🎓 CampusLMS</h1>

<p align="center">
  <strong>Sistem Manajemen Pembelajaran Kampus berbasis Laravel 13</strong>
  <br>
  Platform e-learning multilevel dengan fitur lengkap untuk Dosen, Mahasiswa, dan Admin.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3-%23777BB4?logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Laravel-13-%23FF2D20?logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white" alt="SQLite">
  <img src="https://img.shields.io/badge/Vite-8-%23646CFF?logo=vite&logoColor=white" alt="Vite 8">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-%2306B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3">
  <img src="https://img.shields.io/badge/Alpine.js-3-%238BC0D0?logo=alpinedotjs&logoColor=white" alt="Alpine.js 3">
  <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
</p>

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| **👥 Multi Role** | Super Admin, Admin, Dosen, Mahasiswa — masing-masing dengan dashboard & akses berbeda |
| **📚 Kelas & Mata Kuliah** | Manajemen kelas, enroll mahasiswa, dan jadwal perkuliahan |
| **📖 Materi** | Upload & manage materi pembelajaran, lengkap dengan tracking progress |
| **📝 Tugas** | Buat tugas, kumpulkan, nilai, dan feedback langsung dari sistem |
| **📋 Quiz** | Quiz online dengan soal pilihan ganda, scoring otomatis, dan riwayat percobaan |
| **💬 Forum Diskusi** | Diskusi per kelas, thread & reply, lengkap dengan fitur like |
| **📌 Absensi** | Rekap kehadiran dengan status Hadir/Sakit/Izin/Alpa |
| **📢 Pengumuman** | Announcement terpusat untuk setiap kelas |
| **🎓 Sertifikat** | Generate sertifikat PDF + QR Code otomatis |
| **📊 Nilai** | Rekap nilai akhir, export rapor, dan grafik performa |
| **🔔 Notifikasi** | Notifikasi real-time untuk tugas baru, quiz, pengumuman, dll. |
| **📜 Audit Log** | Catatan aktivitas pengguna untuk keperluan monitoring |
| **🔐 Role & Permission** | Manajemen hak akses via Spatie Permission |

## 🛠 Tech Stack

### Backend
- **PHP 8.3** + **Laravel 13.x**
- **SQLite** — database ringan tanpa setup server terpisah
- **Spatie Laravel Permission** — role & permission management
- **Laravel Sanctum** — API authentication
- **Laravel Queue** (database driver) — job processing
- **Laravel Breeze** (Blade + Alpine stack) — auth scaffolding
- **Barryvdh DomPDF** — generate dokumen PDF
- **Simple QR Code** — generate QR code

### Frontend
- **Blade** + **Alpine.js 3**
- **Tailwind CSS 3** + **PostCSS**
- **Vite 8** — build tool & HMR
- **Collapsible Sidebar** — navigasi responsif
- **Dark Mode** — toggle tema gelap/terang
- **Notification Dropdown** — notifikasi interaktif

## ⚡ Quick Start

```bash
# Clone repository
git clone https://github.com/Kazuya-01/campuslms.git
cd campuslms

# Setup lengkap (install dependencies, .env, migrate, build)
composer setup

# Jalankan development server (4-in-1: artisan serve + queue + logs + vite)
composer dev
```

> **Note:** `.npmrc` memiliki `ignore-scripts=true`. `composer setup` sudah menanganinya.

### Setup Manual

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install --ignore-scripts
npm run build
```

## 🔑 Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| 🛡️ Super Admin | `admin@campuslms.test` | `password` |
| 👨‍🏫 Dosen | `dosen@campuslms.test` | `password` |
| 👨‍🎓 Mahasiswa | `mahasiswa@campuslms.test` | `password` |

Login bisa menggunakan **email**, **username**, atau **NIM**.

## 🧪 Testing

```bash
composer test
# atau
php artisan test --filter=NamaTest
```

PHPUnit dikonfigurasi dengan **in-memory SQLite** — tidak perlu database eksternar.

## 📁 Struktur Route

| Route | Deskripsi |
|-------|-----------|
| `/admin/*` | Dashboard & manajemen admin |
| `/dosen/*` | Dashboard & fitur dosen |
| `/mahasiswa/*` | Dashboard & fitur mahasiswa |
| `/api/*` | REST API (Sanctum) |

## 🧑‍💻 Development

```bash
# PHP linting
./vendor/bin/pint

# Vite build production
npm run build

# Vite dev server saja
npm run dev
```

## 📄 Lisensi

CampusLMS adalah open-source software under the [MIT License](LICENSE).

---

<p align="center">
  ❤️ Dibangun dengan Laravel, Tailwind CSS, dan Alpine.js
</p>
