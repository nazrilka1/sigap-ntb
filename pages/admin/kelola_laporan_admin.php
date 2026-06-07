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
                        <a href="dashboard_admin.php" class="nav-link">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="kelola_laporan_admin.php" class="nav-link">
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
                <form method="POST">
                    <div class="filter-bar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input
                                type="text"
                                placeholder="Cari Nama Pelapor..."
                                name="fnama"
                                value="<?= isset($_POST['fnama']) ? $_POST['fnama'] : '' ?>">
                        </div>

                        <select class="filter-select" name="fstatus">
                            <option value="">Semua Status</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>

                        <select class="filter-select" name="fkategori">
                            <option value="">Semua Kategori</option>
                            <option value="infrastruktur">Infrastruktur</option>
                            <option value="kesehatan">Kesehatan</option>
                            <option value="kamtibmas">Kamtibmas</option>
                            <option value="lingkungan">Lingkungan</option>
                        </select>

                        <input
                            type="date"
                            class="filter-date"
                            name="ftanggal">

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
                                <th>KATEGORI</th>
                                <th>LOKASI</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th class="text-right">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        

                            $nama     = isset($_POST['fnama']) ? mysqli_real_escape_string($conn, $_POST['fnama']) : '';
                            $status   = isset($_POST['fstatus']) ? mysqli_real_escape_string($conn, $_POST['fstatus']) : '';
                            $kategori = isset($_POST['fkategori']) ? mysqli_real_escape_string($conn, $_POST['fkategori']) : '';
                            $tanggal  = isset($_POST['ftanggal']) ? mysqli_real_escape_string($conn, $_POST['ftanggal']) : '';

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
                                WHERE
                                    ('$nama' = '' OR nama_pelapor LIKE '%$nama%')
                                AND
                                    ('$status' = '' OR status = '$status')
                                AND
                                    ('$kategori' = '' OR jenis_laporan = '$kategori')
                                AND
                                    ('$tanggal' = '' OR tanggal_laporan = '$tanggal')
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
                                       

                                       <button
                                            type="button"
                                            class="action-btn action-green"
                                            onclick="openModal('teruskan<?= $data['id_pengaduan'] ?>')">

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
                            <div class="modal" id="teruskan<?= $data['id_pengaduan'] ?>">
                            <div class="modal-content">

                                <span
                                    class="close"
                                    onclick="closeModal('teruskan<?= $data['id_pengaduan'] ?>')">
                                    &times;
                                </span>

                                <h3>Teruskan Laporan ke OPD</h3>

                                <form action="../../php/aksi_admin.php" method="POST">

                                    <input
                                        type="hidden"
                                        name="id_pengaduan"
                                        value="<?= $data['id_pengaduan'] ?>">

                                    <div class="form-group">
                                        <label>Pilih OPD</label>

                                        <select name="id_opd" required>

                                            <?php
                                            $opd = mysqli_query(
                                                $conn,
                                                "SELECT * FROM opd ORDER BY nama_opd ASC"
                                            );

                                            while($o = mysqli_fetch_assoc($opd)){
                                            ?>

                                            <option value="<?= $o['id_opd'] ?>">
                                                <?= $o['nama_opd'] ?>
                                            </option>

                                            <?php } ?>

                                        </select>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        name="bteruskan">
                                        Teruskan
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
