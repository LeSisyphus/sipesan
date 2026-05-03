# SiPesan : Sistem Pengajuan Surat Mahasiswa

Aplikasi web untuk pengajuan surat mahasiswa secara digital.
Dibangun sebagai Tugas Akhir mata kuliah Pemrograman Web II.

---

## Tim Pengembang

| Nama    | Role                   | GitHub      |
| ------- | ---------------------- | ----------- |
| Maulana | Project Lead & Backend | @LeSisyphus |
| Adiya   | Frontend & UI          | @Adiyaus    |
| Azri    | Backend & CRUD Admin   | @AzriPrime  |

---

## Tech Stack

| Komponen        | Teknologi      |
| --------------- | -------------- |
| Backend         | Laravel 11     |
| Database        | MySQL          |
| CSS             | Tailwind CSS   |
| JS              | Alpine.js      |
| Template        | Blade          |
| Auth            | Laravel Breeze |
| Version Control | Git + GitHub   |

---

## Cara Instalasi

### Prasyarat

Pastikan sudah terinstall di komputer:

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL

### Langkah Instalasi

1. Clone repository

    ```bash
    git clone https://github.com/username/SiPesan.git
    cd SiPesan
    ```

2. Install dependencies PHP

    ```bash
    composer install
    ```

3. Install dependencies JavaScript

    ```bash
    npm install
    ```

4. Salin file environment

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Konfigurasi database di file `.env`

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sipesan
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Jalankan migration dan seeder

    ```bash
    php artisan migrate:fresh --seed
    ```

7. Build assets

    ```bash
    npm run build
    ```

8. Jalankan server

    ```bash
    php artisan serve
    ```

9. Buka browser di `http://localhost:8000`

---

## Akun Default

| Role      | Email                       | Password |
| --------- | --------------------------- | -------- |
| Admin     | admin@sipesan.com           | password |
| Mahasiswa | daftar via halaman register | -        |

---

## Struktur Database

| Tabel                | Keterangan                                 |
| -------------------- | ------------------------------------------ |
| `users`              | Akun login semua role                      |
| `mahasiswa`          | Data profil mahasiswa                      |
| `prodi`              | Data program studi                         |
| `jenis_surat`        | Jenis surat yang tersedia                  |
| `dokumen_syarat`     | Syarat per jenis surat                     |
| `jenis_surat_syarat` | Relasi many-to-many jenis surat dan syarat |
| `pengajuan`          | Data pengajuan surat mahasiswa             |

---

## Alur Status Pengajuan

```
Menunggu → Diproses → Selesai
                    → Ditolak
```

---

## Role Pengguna

### Admin / TU

- Melihat semua pengajuan
- Memproses, menyetujui, atau menolak pengajuan
- Mengelola data jenis surat, prodi, dan mahasiswa
- Mengunduh laporan pengajuan

### Mahasiswa

- Mengajukan surat
- Memantau status pengajuan
- Mengunduh surat yang sudah selesai
- Mengelola profil

---

## Lisensi

Proyek ini dibuat untuk keperluan akademik Tugas Akhir mata kuliah Pemrograman Web II
