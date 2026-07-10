<div align="center">
  
# 🏥 MedCampus

### Sistem Manajemen Klinik Kesehatan Universitas

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-8-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Midtrans](https://img.shields.io/badge/Midtrans-Payment-008080?style=for-the-badge&logo=midtrans&logoColor=white)](https://midtrans.com)

[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-12-007EC6?style=flat-square&logo=php&logoColor=white)](https://phpunit.de)
[![SQLite](https://img.shields.io/badge/Database-SQLite%20%7C%20MySQL-003B57?style=flat-square&logo=sqlite&logoColor=white)](https://sqlite.org)

---

<p align="center">
  <strong>MedCampus</strong> adalah sistem informasi klinik kesehatan kampus yang dirancang untuk memudahkan mahasiswa, dosen, dan staf dalam mengakses layanan kesehatan di lingkungan universitas.
</p>

[🚀 Fitur](#-fitur) •
[🏗️ Arsitektur](#️-arsitektur) •
[⚙️ Instalasi](#️-instalasi) •
[📖 Panduan](#-panduan)

</div>

---

## 🚀 Fitur

### 👥 Multi-Role System

<table>
<tr>
  <th width="33%">🛡️ Admin</th>
  <th width="33%">🩺 Dokter</th>
  <th width="34%">👤 Pasien</th>
</tr>
<tr>
  <td valign="top">
  
  - Dashboard statistik & analitik
  - Manajemen pengguna (CRUD)
  - Manajemen jadwal dokter
  - Inventaris obat & stok
  - Pengaturan sistem
  - Manajemen poli/departemen
    
  </td>
  <td valign="top">
  
  - Dashboard pasien hari ini
  - Daftar pasien & antrean
  - Rekam medis elektronik
  - Resep obat digital
  - Jadwal praktik pribadi
  - Profil & pengaturan akun
    
  </td>
  <td valign="top">
  
  - Booking janji temu online
  - Tiket antrean digital
  - Tracking antrean real-time
  - Riwayat kunjungan
  - Detail resep & diagnosis
  - Pembayaran via Midtrans
    
  </td>
</tr>
</table>

### 🌟 Fitur Unggulan

| Fitur | Deskripsi |
|-------|-----------|
| 📅 **Booking Online** | Pasien dapat memesan janji dengan dokter pilihan dan melihat slot waktu tersedia |
| 🔄 **Antrean Real-time** | Sistem antrean dengan nomor urut dan estimasi waktu tunggu |
| 💳 **Pembayaran Digital** | Integrasi Midtrans untuk pembayaran konsultasi online |
| 📧 **Notifikasi Email** | Konfirmasi booking, pengingat janji, dan notifikasi pembatalan otomatis via email |
| 📋 **Rekam Medis Digital** | Catatan diagnosis, resep obat, dan riwayat kunjungan pasien tersimpan rapi |
| 💊 **Manajemen Farmasi** | Inventaris obat lengkap dengan status stok (tersedia, menipis, habis) |
| 🌙 **Dark Mode** | Tampilan antarmuka dengan dukungan mode gelap untuk kenyamanan pengguna |
| 🔒 **Sistem OTP** | Verifikasi dua langkah menggunakan kode OTP untuk keamanan akun |

---

## 🏗️ Arsitektur

### Diagram Basis Data

```
roles ─── users ───┬── doctor_profiles ─── polis
                   ├── patient_profiles
                   ├── doctor_leaves
                   ├── doctor_schedules ─── appointments ─── transaksi ─── detail_transaksi
                   └──                                        └── medical_records ─── medicines_record_medicine ─── medicines
```

### Struktur Tabel

| Tabel | Deskripsi |
|-------|-----------|
| `roles` | Master role pengguna (Admin/Dokter/Pasien) |
| `users` | Data pengguna terautentikasi |
| `polis` | Master poli/departemen kesehatan |
| `doctor_profiles` | Profesional informasi dokter (SIP, spesialisasi) |
| `patient_profiles` | Data demografis pasien (NIM/NIP, gol darah, alamat) |
| `doctor_schedules` | Jadwal praktik dokter (shift, ruang, kuota) |
| `doctor_leaves` | Cuti/jadwal libur dokter |
| `appointments` | Janji temu & antrean pasien |
| `medical_records` | Rekam medis & diagnosis |
| `medicines` | Inventaris obat |
| `medicines_record_medicine` | Detail resep obat per rekam medis |
| `transaksi` | Data transaksi pembayaran |
| `detail_transaksi` | Rincian item transaksi |

### Tech Stack

#### Backend
- **Framework:** Laravel 13
- **Bahasa:** PHP 8.3
- **Database:** SQLite / MySQL (konfigurabel)
- **Queue:** Database queue driver

#### Frontend
- **CSS Framework:** TailwindCSS 4
- **Build Tool:** Vite 8
- **Template Engine:** Blade

#### Third-Party Services
| Service | Kegunaan |
|---------|----------|
| **Midtrans** | Payment gateway untuk pembayaran konsultasi |
| **Laravel Mail** | Notifikasi email (SMTP/Mailtrap/Log) |

---

## ⚙️ Instalasi

### 📋 Prasyarat

Pastikan sistem Anda telah terinstall:

- PHP **^8.3** ([unduh](https://php.net/downloads))
- Composer **^2.0** ([unduh](https://getcomposer.org))
- Node.js **^18** ([unduh](https://nodejs.org))
- Database **SQLite** (bawaan PHP) atau **MySQL** 5.7+

### 🔧 Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/your-username/medcampus.git
cd medcampus

# 2. Install dependency PHP
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database (SQLite default)
# Untuk SQLite: secara default sudah menggunakan SQLite
touch database/database.sqlite

# Atau untuk MySQL, edit file .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=medcampus
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi database
php artisan migrate

# 6. (Opsional) Seed data awal
php artisan db:seed

# 7. Install & build asset frontend
npm install
npm run build

# 8. Jalankan aplikasi
php artisan serve
```

Akses aplikasi di **http://localhost:8000** 🎉

### 🐳 Development Mode

```bash
# Jalankan semua service sekaligus (server, queue, logs, vite)
composer run dev
```

Perintah di atas akan menjalankan:
- `php artisan serve` → Server web
- `php artisan queue:listen` → Worker queue
- `php artisan pail` → Log viewer
- `npm run dev` → Vite HMR

### 🧪 Testing

```bash
# Jalankan seluruh test suite
composer test

# Atau secara manual
php artisan config:clear --ansi
php artisan test
```

---

## 📖 Panduan

### Alur Penggunaan

```
                    ┌──────────────┐
                    │   Register   │
                    │     /Login   │
                    └──────┬───────┘
                           │
              ┌────────────┼────────────┐
              ▼            ▼            ▼
        ┌──────────┐ ┌──────────┐ ┌──────────┐
        │  Admin   │ │  Dokter  │ │  Pasien  │
        └────┬─────┘ └────┬─────┘ └────┬─────┘
             │            │            │
             ▼            ▼            ▼
   ┌─────────────────┐ ┌────────┐ ┌──────────┐
   │ Manajemen Sistem│ │Layanan │ │  Booking │
   │ & Master Data   │ │Medis   │ │ & Antrean│
   └─────────────────┘ └────────┘ └──────────┘
```

### 📱 Fitur per Role

#### 🛡️ Admin — `/admin/*`

| Route | View | Fungsi |
|-------|------|--------|
| `/admin/dashboard` | `admin-dashboard` | Statistik pengguna, obat, jadwal & distribusi poli |
| `/admin/users` | `admin-users` | CRUD manajemen pengguna (add/edit/suspend) |
| `/admin/schedules` | `admin-schedules` | Atur jadwal praktik dokter (shift, ruang) |
| `/admin/inventory` | `admin-inventory` | Manajemen stok obat (add/edit/delete) |
| `/admin/settings` | `admin-settings` | Pengaturan sistem |

#### 🩺 Dokter — `/doctor/*`

| Route | View | Fungsi |
|-------|------|--------|
| `/doctor/dashboard` | `doctor-dashboard` | Ringkasan pasien hari ini & status antrean |
| `/doctor/patients` | `doctor-patients` | Daftar pasien berdasarkan jadwal shift |
| `/doctor/records` | `doctor-records` | Riwayat rekam medis & resep |
| `/doctor/new-entry` | `doctor-new-entry` | Input rekam medis & resep baru |
| `/doctor/schedule` | `doctor-schedule` | Jadwal praktik pribadi |
| `/doctor/profile` | `doctor-profile` | Edit profil & ganti password |

#### 👤 Pasien — `/patient/*`

| Route | View | Fungsi |
|-------|------|--------|
| `/patient/dashboard` | `dashboard` | Antrean aktif & status terkini |
| `/patient/booking` | `booking` | Booking janji dengan dokter (pilih tanggal & jam) |
| `/patient/checkout` | `checkout` | Halaman checkout pembayaran |
| `/patient/success` | `success` | Konfirmasi booking berhasil |
| `/patient/ticket` | `ticket` | Tiket antrean digital (nomor antrean, dokter, ruang) |
| `/patient/queue-detail` | `queue-detail` | Detail antrean real-time dengan progress bar |
| `/patient/history` | `history` | Riwayat kunjungan & tagihan |
| `/patient/visit-detail` | `visit-detail` | Detail kunjungan (diagnosis & resep) |
| `/patient/profile` | `patient-profile` | Edit profil pribadi |

### 🎨 Tema & Kustomisasi

MedCampus mendukung **Dark Mode** yang dapat diaktifkan melalui toggle pada antarmuka pengguna. Tema disimpan di `localStorage` sehingga preferensi tetap tersimpan antar sesi.

---

## 🗂️ Struktur Project

```
MedCampus/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php       # Autentikasi & OTP
│   │       ├── DashboardController.php   # Dashboard Admin
│   │       ├── DoctorController.php      # Fitur Dokter
│   │       ├── MedicineController.php    # Manajemen Obat
│   │       ├── PatientController.php     # Fitur Pasien
│   │       ├── ScheduleController.php    # Jadwal Dokter
│   │       └── UserController.php        # Manajemen User
│   ├── Mail/
│   │   ├── AppointmentMail.php          # Email konfirmasi booking
│   │   ├── CancellationMail.php         # Email pembatalan
│   │   ├── OtpMail.php                  # Email kode OTP
│   │   └── PaymentMail.php             # Email pembayaran
│   └── Models/
│       └── User.php
├── database/
│   ├── migrations/                      # 13 file migrasi
│   └── seeders/
├── resources/
│   └── views/                           # 34+ file Blade
│       ├── emails/                      # Template email
│       ├── admin-*.blade.php           # Halaman Admin
│       ├── doctor-*.blade.php          # Halaman Dokter
│       ├── patient-*.blade.php         # Halaman Pasien
│       └── *.blade.php                 # Halaman publik
├── routes/
│   └── web.php                          # Route definition
├── public/                              # Assets publik
├── config/                              # Konfigurasi Laravel
│── composer.json
└── package.json
```

---

## 🧪 Testing

Framework testing menggunakan **PHPUnit 12** dengan konfigurasi *in-memory SQLite database* untuk isolasi penuh.

```bash
# Jalankan semua test
composer test

# Jalankan test spesifik
php artisan test --filter=NamaTest

# Melakukan test dengan coverage (perlu Xdebug/PCOV)
php artisan test --coverage
```

**Konfigurasi Testing** (`phpunit.xml`):
- Environment: `testing`
- Database: SQLite `:memory:`
- Cache: `array` driver
- Session: `array` driver
- Mail: `array` driver

---

## 🙏 Kredit

- **[Laravel](https://laravel.com)** — Framework PHP yang elegan
- **[TailwindCSS](https://tailwindcss.com)** — CSS utility-first framework
- **[Midtrans](https://midtrans.com)** — Payment gateway Indonesia
- **[Vite](https://vitejs.dev)** — Build tool modern
