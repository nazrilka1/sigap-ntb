<?php
include "../../php/koneksi.php";

session_start();

if(!isset($_SESSION['username'])){
    header('location: ../../pages/login.php');
    exit();
}

if($_SESSION['role'] != 'admin'){
    header('location: ../../pages/login.php');
    exit();
}

?>





<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan Admin</title>
    
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/components/sidebar.css">
    <link rel="stylesheet" href="../../CSS/components/topbar.css">
    <link rel="stylesheet" href="../../CSS/components/card.css">
    <link rel="stylesheet" href="../../CSS/components/table.css">
    <link rel="stylesheet" href="../../CSS/components/modal.css">
    <link rel="stylesheet" href="../../CSS/components/button.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="app-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>Admin<br>Panel</h2>
                <p>Provinsi NTB</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard_admin.html" class="nav-link">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="/kelola_laporan_admin.php" class="nav-link">
                            <i class="far fa-file-alt"></i>
                            <span>Kelola Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pengaturan_admin.html" class="nav-link">
                            <i class="far fa-user-circle"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a href="../../php/logout.php" class="nav-link logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-title">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>Kelola Laporan</h1>
                        <p>Manajemen data pengaduan dan aspirasi masyarakat.</p>
                    </div>
                </div>
                
                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="far fa-bell"></i>
                        <span class="badge-dot"></span>
                    </button>
                    <div class="header-profile">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin Profile" class="profile-img">
                        <div class="profile-info">
                            <span class="profile-name">Administrator Utama</span>
                            <span class="profile-role">Pemprov NTB</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="summary-cards">
                <div class="card">
                    <div class="card-icon icon-blue"><i class="fas fa-folder-open"></i></div>
                    <div class="card-label">TOTAL LAPORAN</div>
                    <div class="card-value">1,284</div>
                </div>
                <div class="card">
                    <div class="card-icon icon-red"><i class="fas fa-clock"></i></div>
                    <div class="card-label">PENDING</div>
                    <div class="card-value">145</div>
                </div>
                <div class="card">
                    <div class="card-icon icon-yellow"><i class="fas fa-spinner"></i></div>
                    <div class="card-label">DIPROSES</div>
                    <div class="card-value">220</div>
                </div>
                <div class="card">
                    <div class="card-icon icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="card-label">SELESAI</div>
                    <div class="card-value">919</div>
                </div>
            </section>

            <section class="table-section">
                <div class="table-header flex-column">
                    <div class="table-header-top">
                        <h2>Daftar Semua Laporan</h2>
                    </div>
                    
                    <div class="filter-bar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari ID, Judul, atau Nama...">
                        </div>
                        <select class="filter-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        <select class="filter-select" id="kategoriFilter">
                            <option value="">Semua Kategori</option>
                            <option value="infrastruktur">Infrastruktur</option>
                            <option value="kesehatan">Kesehatan</option>
                            <option value="kamtibmas">Kamtibmas</option>
                            <option value="lingkungan">Lingkungan</option>
                        </select>
                        <input type="date" class="filter-date" id="dateFilter">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PELAPOR</th>
                                <th>JUDUL LAPORAN</th>
                                <th>KATEGORI</th>
                                <th>LOKASI</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th class="text-right">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        $tampilkan = mysqli_query($conn,"
                            SELECT
                            id_pengaduan,
                            nama_pelapor,
                            deskripsi_laporan,
                            jenis_laporan,
                            alamat_kejadian,
                            tanggal_laporan,
                            status
                            FROM pengaduan
                            ORDER BY id_pengaduan ASC
                        ");

                        while($data = mysqli_fetch_assoc($tampilkan)){
                        ?>

                            <tr>
                                <td><?= $data['id_pengaduan'] ?></td>
                                <td><?= $data['nama_pelapor'] ?></td>
                                <td><?= $data['deskripsi_laporan'] ?></td>

                                <td>
                                    <span class="badge badge-blue">
                                        <?= $data['jenis_laporan'] ?>
                                    </span>
                                </td>

                                <td><?= $data['alamat_kejadian'] ?></td>

                                <td><?= $data['tanggal_laporan'] ?></td>

                                <td>
                                    <span class="badge badge-yellow-light">
                                        <?= $data['status'] ?>
                                    </span>
                                </td>

                                <td class="text-right">
                                    <div class="action-flex">

                                        <button class="action-btn action-blue">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button
                                            type="button"
                                            class="action-btn"
                                            onclick="openModal('edit<?= $data['id_pengaduan'] ?>')">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <a href="../../php/aksi_admin.php?hapus=<?= $data['id_pengaduan'] ?>"
                                        onclick="return confirm('Yakin hapus data?')">
                                         <i class="fas fa-trash"></i>
                                        </a>
                                       

                                        <button class="action-btn action-green">
                                            <i class="fas fa-share"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <div class="modal" id="edit<?= $data['id_pengaduan'] ?>">
                                <div class="modal-content">

                                    <span
                                        class="close"
                                        onclick="closeModal('edit<?= $data['id_pengaduan'] ?>')">
                                        &times;
                                    </span>

                                    <h3>Edit Data Laporan</h3>

                                    <form action="../../php/aksi_admin.php" method="post">

                                        <input
                                            type="hidden"
                                            name="uid"
                                            value="<?= $data['id_pengaduan'] ?>">

                                        <div class="form-group">
                                            <label>Nama Pelapor</label>

                                            <input
                                                type="text"
                                                name="unama"
                                                value="<?= htmlspecialchars($data['nama_pelapor']) ?>"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label>Deskripsi Laporan</label>

                                            <textarea
                                                name="ujudul"
                                                rows="4"
                                                required><?= htmlspecialchars($data['deskripsi_laporan']) ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis Laporan</label>

                                            <input
                                                type="text"
                                                name="ukategori"
                                                value="<?= htmlspecialchars($data['jenis_laporan']) ?>"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>

                                            <select name="ustatus">

                                                <option value="menunggu"
                                                <?= $data['status']=="menunggu" ? "selected" : "" ?>>
                                                Menunggu
                                                </option>

                                                <option value="diproses"
                                                <?= $data['status']=="diproses" ? "selected" : "" ?>>
                                                Diproses
                                                </option>

                                                <option value="selesai"
                                                <?= $data['status']=="selesai" ? "selected" : "" ?>>
                                                Selesai
                                                </option>

                                                <option value="ditolak"
                                                <?= $data['status']=="ditolak" ? "selected" : "" ?>>
                                                Ditolak
                                                </option>

                                            </select>
                                        </div>

                                        <button
                                            type="submit"
                                            name="bupdate"
                                            class="btn btn-primary">
                                            Update Data
                                        </button>

                                    </form>

                                </div>
                            </div>

                        <?php } ?>

                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>

    <div class="modal-overlay" id="detailModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2>Detail Laporan <span id="modalReportId">#NTB-001</span></h2>
                <button class="btn-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="modal-body">
                <div class="modal-left">
                    <div class="report-image-box">
                        <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800&q=80" alt="Bukti Laporan" class="report-main-img">
                    </div>
                    
                    <div class="report-meta">
                        <div class="meta-item">
                            <span class="meta-label">Pelapor:</span>
                            <span class="meta-value">Ahmad Hidayat</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Lokasi:</span>
                            <span class="meta-value">Jl. Majapahit, Mataram</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Tanggal:</span>
                            <span class="meta-value">24 Okt 2023, 14:30 WITA</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Status:</span>
                            <span class="badge badge-yellow-light">DIPROSES</span>
                        </div>
                    </div>

                    <div class="report-desc">
                        <h3>Isi Laporan:</h3>
                        <p>Terdapat lubang besar di tengah jalan Majapahit dekat perempatan. Sangat membahayakan pengendara motor terutama saat malam hari karena minim penerangan. Mohon segera diperbaiki.</p>
                    </div>

                    <div class="report-desc">
                        <h3>Catatan Admin:</h3>
                        <textarea class="admin-note" placeholder="Tambahkan catatan internal..."></textarea>
                    </div>
                </div>

                <div class="modal-right">
                    
                    <div class="timeline-container">
                        <h3>Progress Laporan</h3>
                        <div class="timeline">
                            <div class="timeline-item done">
                                <div class="timeline-dot"><i class="fas fa-check"></i></div>
                                <div class="timeline-content">
                                    <h4>Laporan Masuk</h4>
                                    <p>24 Okt 2023, 14:30</p>
                                </div>
                            </div>
                            <div class="timeline-item done">
                                <div class="timeline-dot"><i class="fas fa-check"></i></div>
                                <div class="timeline-content">
                                    <h4>Diverifikasi</h4>
                                    <p>24 Okt 2023, 15:00</p>
                                </div>
                            </div>
                            <div class="timeline-item active">
                                <div class="timeline-dot"><i class="fas fa-spinner"></i></div>
                                <div class="timeline-content">
                                    <h4>Diproses OPD</h4>
                                    <p>Dinas PUPR - Sedang dikerjakan</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Selesai</h4>
                                    <p>Menunggu penyelesaian</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="docs-container">
                        <h3>Dokumentasi Penanganan</h3>
                        <div class="upload-grid">
                            <label class="upload-zone" id="dropZoneBefore">
                                <input type="file" hidden accept="image/*" onchange="previewImage(this, 'previewBefore')">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Foto Sebelum</span>
                                <img id="previewBefore" class="upload-preview">
                            </label>
                            
                            <label class="upload-zone" id="dropZoneAfter">
                                <input type="file" hidden accept="image/*" onchange="previewImage(this, 'previewAfter')">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Foto Sesudah</span>
                                <img id="previewAfter" class="upload-preview">
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-action btn-red" onclick="closeModal()">Tolak</button>
                <div class="footer-right">
                    <button class="btn-action btn-outline">Terima Laporan</button>
                    <button class="btn-action btn-yellow">Proses</button>
                    <button class="btn-action btn-green">Selesaikan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ... kode lainnya ... -->
    <script src="../js/components/sidebar.js"></script>
    <script src="../js/components/utils.js"></script>
    <script src="../js/components/modal.js"></script>
    
    <!-- Panggil Laporan JS -->
    <script src="../js/pages/laporan.js"></script>
    <script>
        function openModal(id){
            document.getElementById(id).classList.add('show');
        }

        function closeModal(id){
            document.getElementById(id).classList.remove('show');
        }
    </script>
</body>
</html>
</body>
</html>
