# Panduan Kontribusi Tim SiPesan

Dokumen ini berisi konvensi yang **wajib diikuti** oleh semua anggota tim selama pengerjaan proyek.

---

## Daftar Isi

- [Alur Kerja](#alur-kerja)
- [Pembagian Area Kerja](#pembagian-area-kerja)
- [Konvensi Penamaan Branch](#konvensi-penamaan-branch)
- [Konvensi Commit Message](#konvensi-commit-message)
- [Konvensi Issue](#konvensi-issue)
- [Konvensi Pull Request](#konvensi-pull-request)
- [File yang Tidak Boleh Diedit Bersamaan](#file-yang-tidak-boleh-diedit-bersamaan)
- [Aturan Tambahan](#aturan-tambahan)

---

## Alur Kerja

Setiap mengerjakan fitur, ikuti alur berikut:

```
Ambil issue yang di-assign → Buat branch baru → Kerjakan fitur
        → Push branch → Buat Pull Request → Minta review
        → Di-approve → Merge ke main → Hapus branch
```

Wajib jalankan perintah ini **setiap kali mulai kerja** agar kode selalu up to date:

```bash
git checkout main
git pull origin main
git checkout nama-branch-kamu
git merge main
```

---

## Pembagian Area Kerja

Untuk menghindari konflik, setiap anggota fokus di area masing-masing:

| Anggota | Area Utama                                                       |
| ------- | ---------------------------------------------------------------- |
| Maulana | `routes/`, `app/Http/Controllers/Mahasiswa/`, logic bisnis utama |
| Adiya   | `resources/views/`, komponen UI, layout Blade                    |
| Azri    | `app/Http/Controllers/Admin/`, migration baru, validasi form     |

Kalau terpaksa harus edit file di luar area sendiri, **koordinasi dulu di grup** sebelum mulai.

---

## Konvensi Penamaan Branch

Format:

```
<prefix>/<nomor-issue>-<deskripsi-singkat>
```

Contoh yang benar:

```bash
git checkout -b feat/14-form-pengajuan-surat
git checkout -b ui/15-layout-admin
git checkout -b fix/24-redirect-login
git checkout -b chore/22-validasi-form
git checkout -b docs/1-tambah-readme
```

Prefix yang dipakai:

| Prefix     | Dipakai untuk                  |
| ---------- | ------------------------------ |
| `feat`     | Fitur baru                     |
| `fix`      | Perbaikan bug                  |
| `ui`       | Perubahan tampilan murni       |
| `chore`    | Konfigurasi dan setup          |
| `docs`     | Dokumentasi                    |
| `refactor` | Rapikan kode tanpa ubah fungsi |

---

## Konvensi Commit Message

Format:

```
<prefix>: <deskripsi singkat dalam bahasa indonesia>
```

Aturan penulisan:

- Huruf kecil semua
- Tanpa titik di akhir kalimat
- Maksimal 72 karakter
- Gunakan kalimat perintah

Contoh yang **benar**:

```bash
git commit -m "feat: tambah form pengajuan surat"
git commit -m "fix: perbaiki redirect setelah login"
git commit -m "ui: tambah sidebar navigasi admin"
git commit -m "chore: tambah validasi form request"
git commit -m "docs: tambah panduan instalasi di README"
git commit -m "refactor: sederhanakan logic pengajuan controller"
```

Contoh yang **salah**:

```bash
# Huruf kapital
git commit -m "Feat: Tambah Form Pengajuan"

# Pakai titik di akhir
git commit -m "feat: tambah form pengajuan."

# Terlalu panjang
git commit -m "feat: tambah form pengajuan surat yang menampilkan dropdown jenis surat dan input keperluan mahasiswa"

# Tidak jelas
git commit -m "update"
git commit -m "fix bug"
git commit -m "perubahan"
```

Kalau commit terkait issue tertentu, sebut nomornya di body commit:

```bash
git commit -m "feat: tambah form pengajuan surat

Closes #14"
```

---

## Konvensi Issue

Format judul issue:

```
<nomor urut>. [<prefix>] <deskripsi lengkap>
```

Contoh:

```
14. [feat] Buat form pengajuan surat untuk mahasiswa
15. [ui] Buat base layout admin dengan sidebar dan navbar
24. [fix] Testing manual semua alur dan perbaikan bug
```

Prefix issue:

| Prefix  | Dipakai untuk         |
| ------- | --------------------- |
| `feat`  | Fitur baru            |
| `fix`   | Bug atau perbaikan    |
| `ui`    | Perubahan tampilan    |
| `chore` | Konfigurasi dan setup |
| `docs`  | Dokumentasi           |

---

## Konvensi Pull Request

Format judul PR:

```
<prefix>: <deskripsi singkat> (#<nomor issue>)
```

Contoh:

```
feat: tambah form pengajuan surat (#14)
ui: buat layout admin dengan sidebar (#15)
fix: perbaiki redirect setelah login (#24)
```

Wajib isi semua bagian di template deskripsi PR yang sudah tersedia.

---

## File yang Tidak Boleh Diedit Bersamaan

File-file berikut rawan konflik jika diedit bersamaan oleh lebih dari satu orang:

| File                                  | Aturan                                                 |
| ------------------------------------- | ------------------------------------------------------ |
| `routes/web.php`                      | Koordinasi dulu di gc whatsapp sebelum edit            |
| `database/migrations/`                | Jangan ubah migration yang sudah di-push ke main       |
| `.env`                                | Jangan di-commit, gunakan `.env.example` sebagai acuan |
| `database/seeders/DatabaseSeeder.php` | Koordinasi jika perlu tambah seeder baru               |

---

## Aturan Tambahan

- Jangan push langsung ke `main` — selalu lewat Pull Request
- Jangan merge PR milik sendiri — minta anggota lain untuk review
- Selesaikan semua konflik sebelum minta review
- Hapus branch setelah PR berhasil di-merge
- Jangan commit file `.env`, `node_modules/`, atau `vendor/`
