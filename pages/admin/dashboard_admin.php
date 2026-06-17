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

    <title>Dashboard Admin SIGAP NTB</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/components/sidebar.css">
    <link rel="stylesheet" href="../../CSS/components/topbar.css">
    <link rel="stylesheet" href="../../CSS/components/card.css">
    <link rel="stylesheet" href="../../CSS/components/table.css">
    <link rel="stylesheet" href="../../CSS/components/button.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="app-container">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <h2>Admin<br>Panel</h2>
            <p>Provinsi NTB</p>
        </div>

        <nav class="sidebar-nav">

            <ul class="nav-list">

                <li class="nav-item active">
                    <a href="dashboard_admin.php" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="kelola_laporan_admin.php" class="nav-link">
                        <i class="far fa-file-alt"></i>
                        <span>Kelola Laporan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="pengaturan_admin.php" class="nav-link">
                        <i class="far fa-user-circle"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>

            </ul>

        </nav>

        <div class="sidebar-footer">

            <a href="/project/sigap-ntb/php/logout.php" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="header-title">

                <button class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div>
                    <h1>Dashboard Admin</h1>
                    <p>
                        Selamat datang di Sistem Informasi SIGAP NTB
                    </p>
                </div>

            </div>

            <div class="header-actions">

                <button class="notification-btn">
                    <i class="far fa-bell"></i>
                    <span class="badge-dot"></span>
                </button>

                <div class="header-profile">

                    <img
                    src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['username']; ?>&background=random"
                    alt="Profile"
                    class="profile-img">

                    <div class="profile-info">

                        <span class="profile-name">
                            <?php echo $_SESSION['username']; ?>
                        </span>

                        <span class="profile-role">
                            <?php echo $_SESSION['role']; ?>
                        </span>

                    </div>

                </div>

            </div>

        </header>
         <?php
                
                $query_statistik = mysqli_query($conn,"
                    SELECT
                        COUNT(*) AS total_laporan,
                        SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) AS menunggu,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
                        SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) AS diproses,
                        SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) AS selesai
                    FROM pengaduan
                ");

                $statistik = mysqli_fetch_assoc($query_statistik);

            ?>

        <!-- CARD -->
        <section class="summary-cards">

            <div class="card">

                <div class="card-icon">
                    <i class="fas fa-inbox"></i>
                </div>

                <div class="card-label">
                    TOTAL LAPORAN
                </div>

                <div class="card-value">
                    <?= $statistik['total_laporan']?>
                </div>

                <div class="card-status status-up">
                    dari berbagai penjuru NTB
                </div>

            </div>

            <div class="card">

                <div class="card-icon icon-yellow">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="card-label">
                    MENUNGGU VERIFIKASI
                </div>

                <div class="card-value">
                     <?= $statistik['menunggu']?>
                </div>

                <div class="card-status status-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    Perlu tindakan segera
                </div>

            </div>

            <div class="card">

                <div class="card-icon icon-green">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="card-label">
                    LAPORAN SELESAI
                </div>

                <div class="card-value">
                     <?= $statistik['selesai']?>
                </div>

                <div class="card-status status-good">
                    <i class="fas fa-check"></i>
                    Tingkat penyelesaian tinggi
                </div>

            </div>


        </section>

        <!-- TABLE -->
        <section class="table-section">

            <div class="table-header">

                <h2>Daftar Laporan Terkini</h2>

                <div class="search-box">

                    <i class="fas fa-search"></i>

                    <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari laporan..."
                    name="fnama"
                    value="<?= isset($_POST['fnama']) ? $_POST['fnama'] : '' ?>">

                </div>

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
                           
                            $tampilkan = mysqli_query($conn,"
                                SELECT *
                                FROM pengaduan
                                WHERE
                                    ('$nama' = '' OR nama_pelapor LIKE '%$nama%')
                               
                                ORDER BY id_pengaduan ASC
                            ");



                        while($data = mysqli_fetch_assoc($tampilkan)){
                        ?>

                            <tr>
                                <td><?= $data['kode_laporan'] ?></td>
                                <td><?= $data['nama_pelapor'] ?></td>
                                <td><?= $data['judul_laporan'] ?></td>

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
                                <?php } ?>
                            </tr> 
                        </tbody> 
                    </table>
        </section>

    </main>

</div>

<!-- JS -->
<script src="../../js/components/sidebar.js"></script>
<script src="../../js/components/utils.js"></script>
<script src="../../js/components/modal.js"></script>
<script src="../../js/pages/laporan.js"></script>

</body>
</html>
