
<?php
include "../../php/koneksi.php";

session_start();

if(!isset($_SESSION['username'])){
    header("location: ../../pages/login.php");
    exit();
}

if($_SESSION['role'] != 'opd'){
    header("location: ../../pages/login.php");
    exit();
}

$id_opd = $_SESSION['id_opd'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan OPD</title>
    
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
                <h2>OPD<br>Panel</h2>
                <p>Provinsi NTB</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard_opd.php" class="nav-link">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="kelola_laporan_opd.php" class="nav-link">
                            <i class="far fa-file-alt"></i>
                            <span>Kelola Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pengaturan_opd.html" class="nav-link">
                            <i class="far fa-user-circle"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a href="login.html" class="nav-link logout-btn">
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
            <?php
                
                $query_statistik = mysqli_query($conn,"
                    SELECT
                        COUNT(*) AS total_laporan,
                        SUM(CASE WHEN progress_opd = 'dikerjakan' THEN 1 ELSE 0 END) AS dikerjakan,
                        SUM(CASE WHEN progress_opd = 'menunggu konfirmasi' THEN 1 ELSE 0 END) AS menunggu_konfirmasi,
                        SUM(CASE WHEN progress_opd = 'selesai' THEN 1 ELSE 0 END) AS selesai
                    FROM pengaduan
                ");

                $statistik = mysqli_fetch_assoc($query_statistik);

                $total_laporan = $statistik['total_laporan'];
                $dikerjakan = $statistik['dikerjakan'];
                $menunggu_konfirmasi = $statistik['menunggu_konfirmasi'];
                $selesai = $statistik['selesai'];

            
            
            ?>

            <section class="summary-cards">
                <div class="card">
                    <div class="card-icon icon-blue"><i class="fas fa-folder-open"></i></div>
                    <div class="card-label">TOTAL LAPORAN</div>
                    <div class="card-value"><?=$statistik['total_laporan'] ?></div>
                </div>
                <div class="card">
                    <div class="card-icon icon-red"><i class="fas fa-clock"></i></div>
                    <div class="card-label">DIKERJAKAN</div>
                    <div class="card-value"><?=$statistik['dikerjakan'] ?></div>
                </div>
                <div class="card">
                    <div class="card-icon icon-yellow"><i class="fas fa-spinner"></i></div>
                    <div class="card-label">MENUNGGU KONFIRMASI</div>
                    <div class="card-value"><?=$statistik['menunggu_konfirmasi'] ?></div>
                </div>
                <div class="card">
                    <div class="card-icon icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="card-label">SELESAI</div>
                    <div class="card-value"><?=$statistik['total_laporan'] ?></div>
                </div>
            </section>

            <section class="table-section">
                <div class="table-header flex-column">
                    <div class="table-header-top">
                        <h2>Daftar Semua Laporan</h2>
                    </div>
                <form method='post'>
                    <div class="filter-bar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari ID, Judul, atau Nama..." name='fnama'
                             value="<?= isset($_POST['fnama']) ? $_POST['fnama'] : '' ?>">
                        </div>
                        <select class="filter-select" id="statusFilter" name='fprogress'>
                            <option value="">Semua Status</option>
                            <option value="dikerjakan">Dikerjakan</option>
                            <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                            <option value="selesai">Selesai</option>
                           
                        </select>
                        <select class="filter-select" id="kategoriFilter" name='fkategori'>
                            <option value="">Semua Jenis Laporan</option>
                            <option value="pengaduan">Pengaduan</option>
                            <option value="pengajuan">Pengajuan</option>
                            
                        </select>
                        <input type="date" class="filter-date" id="dateFilter" name='ftanggal'>
                          <button
                            type="submit"
                            name="fupdate"
                            class="btn btn-primary">
                            Filter Pencarian
                        </button>

                        <a href="kelola_laporan_admin.php" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PELAPOR</th>
                                <th>JUDUL LAPORAN</th>
                                <th>JENIS</th>
                                <th>LOKASI</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th class="text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $nama     = isset($_POST['fnama']) ? mysqli_real_escape_string($conn, $_POST['fnama']) : '';
                            $progress   = isset($_POST['fprogress']) ? mysqli_real_escape_string($conn, $_POST['fprogress']) : '';
                            $kategori = isset($_POST['fkategori']) ? mysqli_real_escape_string($conn, $_POST['fkategori']) : '';
                            $tanggal  = isset($_POST['ftanggal']) ? mysqli_real_escape_string($conn, $_POST['ftanggal']) : '';

                            $tampilkan = mysqli_query($conn,"
                                SELECT *
                                FROM pengaduan
                                WHERE
                                    ('$nama' = '' OR nama_pelapor LIKE '%$nama%')
                                AND
                                    ('$progress' = '' OR progress_opd = '$progress')
                                AND
                                    ('$kategori' = '' OR jenis_laporan = '$kategori')
                                AND
                                    ('$tanggal' = '' OR tanggal_laporan = '$tanggal')
                                ORDER BY id_pengaduan ASC
                            ");


                           

                            while($data = mysqli_fetch_assoc($tampilkan)){
                            ?>

                            <tr>

                                <td>
                                    <?= $data['kode_laporan'] ?>
                                </td>

                                <td>
                                    <?= $data['nama_pelapor'] ?>
                                </td>

                                <td>
                                    <?= $data['judul_laporan'] ?>
                                </td>

                                <td>
                                    <span class="badge badge-blue">
                                        <?= $data['jenis_laporan'] ?>
                                    </span>
                                </td>

                                <td>
                                    <?= $data['alamat_kejadian'] ?>
                                </td>

                                <td>
                                    <?= $data['tanggal_laporan'] ?>
                                </td>

                                <td>
                                    <span class="badge badge-yellow-light">
                                        <?= $data['progress_opd'] ?>
                                    </span>
                                </td>

                                <td class="text-right">

                                    <div class="action-flex">

                                        <button
                                            class="action-btn action-blue"
                                            onclick="openModal('detail<?= $data['id_pengaduan'] ?>')">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                            <div class="modal"
                            id="detail<?= $data['id_pengaduan'] ?>">

                            <div class="modal-content">

                            <span class="close" onclick="closeModal('detail<?= $data['id_pengaduan'] ?>')">

                            &times;

                            </span>

                            <h3>Detail Laporan</h3>

                            <p>
                            <b>Pelapor :</b>
                            <?= $data['nama_pelapor'] ?>
                            </p>

                            <p>
                            <b>Laporan :</b>
                            <?= $data['deskripsi_laporan'] ?>
                            </p>

                            <p>
                            <b>Lokasi :</b>
                            <?= $data['alamat_kejadian'] ?>
                            </p>

                            <form action="../../php/aksi_opd.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan'] ?>">

                            <div class="form-group">

                            <label>Status</label>

                            <select name="status">

                            <option value="diteruskan"> Diteruskan </option>

                            <option value="diproses"> Diproses </option>

                            <option value="selesai"> Selesai </option>

                            <option value="ditolak">  Ditolak  </option>

                            </select>

                            </div>

                            <div class="form-group">

                            <label>Catatan OPD</label>

                            <textarea name="catatan_opd" rows="4"></textarea>

                            </div>

                            <div class="form-group">

                            <label>Foto Sebelum</label>

                            <input
                            type="file"
                            name="foto_sebelum">

                            </div>

                            <div class="form-group">

                            <label>Foto Sesudah</label>

                            <input
                            type="file"
                            name="foto_sesudah">

                            </div>

                            <button
                            type="submit"
                            name="bupdateopd"
                            class="btn btn-primary">

                            Simpan Perubahan

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
</body>
</html>
</body>
</html>
