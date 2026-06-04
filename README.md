# SIGAP NTB — Sistem Informasi Gerakan Aspirasi Publik NTB

## Website Name
# SIGAP NTB — Sistem Informasi Gerakan Aspirasi Publik NTB

---

# Short Description
SIGAP NTB adalah sebuah platform digital berbasis web yang berfungsi sebagai sistem pelaporan, pengaduan, dan pengajuan terkait kerusakan fasilitas umum maupun permasalahan sosial di wilayah Nusa Tenggara Barat (NTB). Sistem ini dirancang untuk menggantikan proses pelaporan semi-manual yang rentan miskomunikasi, kurang terstruktur, dan tidak transparan. SIGAP NTB hadir dengan menyediakan sistem yang terintegrasi dan digital untuk meningkatkan efisiensi, transparansi, dan akuntabilitas dalam penanganan pengaduan masyarakat.

---

# Team Members & Responsibilities

| Nama | NIM | Role | Responsibilities |
|------|------|------|------|
| Nazril Hidayat | F1D02410007 | Fullstack Developer | Frontend: Membuat UI Form Pengaduan Masyarakat, Halaman Cek Status Laporan, dan Halaman Riwayat Laporan.Backend: Membuat logika insert data laporan baru ke database (beserta upload foto) dan query pencarian data untuk menampilkan status/riwayat ke publik. |
| Irlan Hadi | F1D02410058 | Fullstack Developer | Frontend: Membuat desain UI Form Login. Backend (Dominan): Mengembangkan sistem Autentikasi (Sesi login, enkripsi password, logout), Otorisasi Hak Akses (membedakan view Admin dan OPD), logika utama perubahan status laporan (Verifikasi Admin & Update Progres OPD), serta bertindak sebagai Arsitek Database (merancang struktur dan relasi tabel keseluruhan). |
| Muhammad Ravi Rayvansyah | F1D02410078 | Fullstack Developer | Frontend: Membangun antarmuka Dashboard Admin, Dashboard OPD, dan tabel interaktif untuk manajemen laporan.Backend: Membuat query untuk menampilkan statistik data di dashboard (jumlah laporan masuk, selesai, dll), serta logika untuk menampilkan daftar laporan berdasarkan OPD terkait. |

---

# Website Users / Actors

## 1. Masyarakat
### Fitur
- Membuat laporan/pengaduan tanpa login dengan melampirkan foto dan deskripsi masalah.
- Melihat status laporan sendiri dan laporan masyarakat lain secara transparan.
- Melihat riwayat laporan yang sudah selesai sebagai bentuk akuntabilitas.  

## 2. Admin
### Fitur
- Login untuk mengakses dashboard pengelolaan laporan.
- Melihat statistik laporan berdasarkan status (menunggu verifikasi, terverifikasi, diteruskan ke OPD, selesai).
- Mengelola laporan dengan melihat detail, mengubah status, dan menghapus laporan yang tidak valid.
- Meneruskan laporan yang sudah terverifikasi ke OPD terkait.  

## 3. OPD (Organisasi Perangkat Daerah)
### Fitur
- Login untuk mengakses dashboard khusus OPD.  
- Menerima laporan yang diteruskan oleh admin.  -
- Memperbarui status laporan dari antrian, sedang dikerjakan, hingga selesai.  
- Memberikan pembaruan kepada admin dan masyarakat terkait progres penanganan. 

---

# Tech Stack

## Frontend
- HTML5
- CSS3
- JavaScript

## Backend
- PHP Native

## Database
- MySQL

## Development Tools
- Visual Studio Code
- XAMPP
- GitHub

# Project Goals
- Mempermudah masyarakat dalam membuat pengaduan dan pengajuan fasilitas umum tanpa hambatan akses login.  
- Meningkatkan transparansi dengan memberikan akses bagi masyarakat untuk memantau status dan riwayat laporan.  
- Memberikan alat yang efektif bagi admin untuk mengelola, memverifikasi, dan meneruskan laporan secara sistematis.  
- Memudahkan OPD dalam mengelola dan memperbarui status laporan yang menjadi tanggung jawabnya.  
- Meningkatkan koordinasi antar pihak terkait sehingga penanganan pengaduan menjadi lebih cepat dan tepat sasaran.  
