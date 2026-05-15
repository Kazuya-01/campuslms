<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="280" alt="Laravel Logo">
</p>

<h1 align="center">🎓 CampusLMS</h1>

<p align="center">
  <strong>Sistem Manajemen Pembelajaran Kampus berbasis Laravel 13</strong>
  <br>
  Platform e-learning multi-role dengan fitur lengkap untuk Admin, Dosen, dan Mahasiswa.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3-%23777BB4?logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Laravel-13-%23FF2D20?logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white" alt="SQLite">
  <img src="https://img.shields.io/badge/Vite-8-%23646CFF?logo=vite&logoColor=white" alt="Vite 8">
  <img src="https://img.shields.io/badge/Tailwind-3-%2306B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3">
  <img src="https://img.shields.io/badge/Alpine-3-%238BC0D0?logo=alpinedotjs&logoColor=white" alt="Alpine.js 3">
  <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
  <img src="https://img.shields.io/badge/status-active-success" alt="Status">
</p>

---

## ✨ Fitur Unggulan

### 🎯 Untuk Mahasiswa
| Fitur | Detail |
|-------|--------|
| **📚 Kelas Virtual** | Akses materi, tugas, quiz, dan forum diskusi per kelas |
| **📖 Materi Belajar** | File, video, link — lengkap dengan tracking progress |
| **📝 Tugas Online** | Upload tugas, lihat nilai & feedback dari dosen |
| **📋 Quiz Interaktif** | Quiz dengan timer, review jawaban, dan **anti-cheat** |
| **💬 Forum Diskusi** | Tanya jawab, thread & reply, fitur like |
| **📌 Absensi** | Absensi via QR Code dengan status Hadir/Izin/Sakit |
| **📊 Nilai & Rapor** | Rekap nilai tugas, quiz, dan nilai akhir per kelas |
| **🎓 Sertifikat** | Download sertifikat PDF dengan QR Code |

### 👨‍🏫 Untuk Dosen
| Fitur | Detail |
|-------|--------|
| **📖 Kelola Kelas** | Buat & kelola kelas, enroll mahasiswa |
| **📝 Buat Tugas** | Upload soal, tentukan deadline, beri nilai & feedback |
| **📋 Buat Quiz** | Quiz pilihan ganda dengan timer & scoring otomatis |
| **📌 Absensi** | Generate QR Code absensi, rekap kehadiran |
| **🎓 Sertifikat** | Terbitkan sertifikat untuk mahasiswa |
| **📊 Penilaian** | Rekap nilai & grafik performa kelas |

### 🛡️ Untuk Admin
| Fitur | Detail |
|-------|--------|
| **👥 Manajemen User** | CRUD user, atur role & permission |
| **📚 Manajemen Kelas** | Overview seluruh kelas & enrollment |
| **📢 Pengumuman Global** | Kirim pengumuman ke seluruh pengguna |
| **🔐 Role & Permission** | Atur hak akses via Spatie Permission |
| **📜 Audit Log** | Monitoring aktivitas seluruh pengguna |

---

## 🛠 Tech Stack

### Backend
| Teknologi | Kegunaan |
|-----------|----------|
| **PHP 8.3** + **Laravel 13.x** | Framework utama |
| **SQLite** | Database — tanpa setup server terpisah |
| **Spatie Laravel Permission** | Role & permission management |
| **Laravel Sanctum** | API authentication (SPA / token) |
| **Laravel Queue** | Job processing (database driver) |
| **Laravel Breeze** | Auth scaffolding (Blade + Alpine stack) |
| **Barryvdh DomPDF** | Generate sertifikat PDF |
| **Simple QR Code** | Generate QR Code untuk sertifikat & absensi |

### Frontend
| Teknologi | Kegunaan |
|-----------|----------|
| **Blade** + **Alpine.js 3** | Template engine & interaktivitas |
| **Tailwind CSS 3** + **PostCSS** | Styling utility-first |
| **Vite 8** | Build tool & Hot Module Replacement |
| **Collapsible Sidebar** | Navigasi responsif per role |
| **Notification Dropdown** | Notifikasi real-time |

---

## 🔒 Anti-Cheat Quiz

Sistem quiz dilengkapi proteksi untuk menjaga integritas ujian:

| Proteksi | Cara Kerja |
|----------|------------|
| **🚫 Right-click** | Dinonaktifkan + toast peringatan |
| **📋 Copy/Paste/Cut** | Diblokir total selama quiz |
| **🔧 DevTools** | F12, Ctrl+Shift+I/J/C, Ctrl+U/S diblokir |
| **🔄 Tab Switch** | Deteksi otomatis → modal warning 10 detik → auto-submit |
| **🚪 Keluar Halaman** | `sendBeacon()` — jawaban tetap tersubmit meskipun tab ditutup |
| **⏪ Back Button** | Dinonaktifkan dengan history.pushState |
| **⏱ Timer** | Auto-submit saat waktu habis |
| **✅ Validasi** | Validasi kustom dengan animasi & highlight merah per soal |

---

## 🧪 Data Seeder

Jalankan `php artisan db:seed` untuk mendapatkan data demo:

```
👤 Users:     4 (1 SA, 1 Dosen, 2 Mahasiswa)
📚 Kelas:     3 (Pemrograman Web, Basis Data Terdistribusi, AI)
📖 Materi:    10 materi dengan link & video
📝 Tugas:     5 tugas dengan deadline
❓ Quiz:      3 quiz (14 soal pilihan ganda)
💬 Forum:     5 thread, 6 reply, 6 like
📢 Pengumuman: 6 pengumuman
✅ Absensi:    9 sesi (18 record)
📊 Nilai:     22 (tugas, quiz, final)
🎓 Sertifikat: 4 sertifikat
🔔 Notifikasi: 12 notifikasi
```

---

## ⚡ Quick Start

```bash
git clone https://github.com/Kazuya-01/campuslms.git
cd campuslms
composer setup
composer dev
```

> **Note:** `.npmrc` memiliki `ignore-scripts=true` — `composer setup` sudah menanganinya.

### Setup Manual

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install --ignore-scripts
npm run build
```

---

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| 🛡️ **Super Admin** | `admin@campuslms.test` | `password` |
| 👨‍🏫 **Dosen** | `dosen@campuslms.test` | `password` |
| 👨‍🎓 **Mahasiswa** | `mahasiswa@campuslms.test` | `password` |

Login menggunakan **email**, **username**, atau **NIM**.

---

## 🧪 Testing

```bash
composer test
# atau
php artisan test --filter=NamaTest
```

PHPUnit menggunakan **in-memory SQLite**.

---

## 📁 Route Structure

| Prefix | Role | Deskripsi |
|--------|------|-----------|
| `/admin/*` | Admin / Super Admin | Manajemen sistem & pengguna |
| `/dosen/*` | Dosen | Kelola kelas, materi, tugas, quiz |
| `/mahasiswa/*` | Mahasiswa | Belajar, tugas, quiz, forum, nilai |
| `/api/*` | Semua (Sanctum) | REST API |

---

## 🧑‍💻 Development Commands

```bash
./vendor/bin/pint          # PHP linting
npm run build              # Vite production build
npm run dev                # Vite dev server
php artisan queue:listen   # Process job queue
```

---

## 📄 Lisensi

CampusLMS adalah open-source software di bawah [MIT License](LICENSE).

---

<p align="center">
  ❤️ Dibangun dengan Laravel, Tailwind CSS, dan Alpine.js
  <br>
  <sub>by Kazuya-01</sub>
</p>
