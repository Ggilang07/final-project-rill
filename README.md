# 📁 Sistem File Archive Perusahaan

Aplikasi digital untuk mengelola arsip file template surat resmi perusahaan, dengan fitur pengajuan surat otomatis, manajemen template, serta penomoran surat yang historis dan terstandarisasi.

---

## 🧭 Latar Belakang

Sistem ini dibuat untuk:
- Menstandarkan akses terhadap template dokumen administratif.
- Mempermudah proses pengajuan surat oleh karyawan.
- Mengelola dan melacak nomor surat resmi berdasarkan jenis dan waktu.

---

## ⚙️ Teknologi yang Digunakan

| Komponen     | Teknologi                    |
|--------------|-------------------------------|
| Frontend     | Ionic + Angular (mobile app)  |
| Backend      | Laravel / Django REST Framework (DRF) |
| Database     | MySQL                         |
| Autentikasi  | Token-based & Role-based      |

---

## 👥 Role Pengguna & Fitur

### 👨‍💼 Karyawan
- 🔐 Login menggunakan akun HRD
- 📄 Lihat dan unduh template surat (Word/PDF)
- 📝 Ajukan surat melalui form berdasarkan template
- 🔢 Nomor surat dihasilkan otomatis sesuai kategori
- 📊 Pantau status pengajuan (verifikasi, cetak, distribusi)
- 📚 Lihat riwayat surat yang pernah diajukan

### 🧑‍💼 Admin (HRD / General Affair)
- 🔐 Login admin
- 🗂 Kelola file template (tambah/edit/hapus)
- 🏷 Klasifikasikan template berdasarkan jenis surat
- 🔢 Penomoran surat otomatis (berurutan per tahun dan kategori)
- ✅ Verifikasi dan validasi surat pengajuan
- 📈 Laporan pengajuan dan riwayat nomor surat

---

## 📌 Format Penomoran Surat

Contoh format:
- `HRD/2025/001`
- `GA/2025/015`

Penomoran dihasilkan otomatis berdasarkan:
- Kategori surat
- Tahun pengajuan
- Urutan surat dalam tahun berjalan

---

## 🗂 Struktur Sistem

- **Mobile App**: Digunakan oleh karyawan untuk pengajuan dan akses template.
- **Web App**: Digunakan oleh Admin untuk manajemen template dan surat.
- **Backend API**: Mengelola login, pengajuan surat, validasi, dan laporan.
- **Database**: Menyimpan user, template, pengajuan, nomor surat, dan histori.

---

## 📎 Catatan Teknis

- Semua file tersimpan di storage/database internal perusahaan.
- Aplikasi mobile wajib mendukung format Word dan PDF.
- Backend menggunakan autentikasi token-based dan role-based access.

---

## 🚀 Status

🔧 **Dalam pengembangan** – sistem sedang dalam tahap implementasi awal.

