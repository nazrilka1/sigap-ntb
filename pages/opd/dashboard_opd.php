<?php
session_start();
include "../../php/koneksi.php";

if(!isset($_SESSION['username'])){
    header('location: ../../pages/login.php');
    exit();
}

if($_SESSION['role'] != 'opd'){
    header('location: ../../pages/login.php');
    exit();
}

$id_opd = $_SESSION['id_opd'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard OPD SIGAP NTB</title>
    
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/components/sidebar.css">
    <link rel="stylesheet" href="../../CSS/components/topbar.css">
    <link rel="stylesheet" href="../../CSS/components/card.css">
    <link rel="stylesheet" href="../../CSS/components/button.css">
    <link rel="stylesheet" href="../../CSS/components/chart.css">

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
                <li class="nav-item active">
                    <a href="dashboard_opd.php" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola_laporan_opd.php" class="nav-link">
                        <i class="far fa-file-alt"></i>
                        <span>Kelola Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pengaturan_opd.php" class="nav-link">
                        <i class="far fa-user-circle"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="../../php/logout.php" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
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
                    <h1>Dinas PUPR NTB</h1>
                    <p>
                        Fokus pada penyelesaian laporan masyarakat secara cepat, transparan, dan akuntabel untuk NTB yang Gemilang.
                    </p>
                </div>
            </div>

            <div class="header-actions">
                <div class="header-profile">
                    <img src="https://ui-avatars.com/api/?name=OPD&background=random" alt="OPD Profile" class="profile-img">
                    <div class="profile-info">
                        <span class="profile-name">Operator Dinas PUPR</span>
                        <span class="profile-role">Pemprov NTB</span>
                    </div>
                </div>
            </div>
        </header>

        <?php
            // Mengambil statistik berdasarkan progress OPD untuk OPD yang login
            $query_statistik = mysqli_query($conn,"
                SELECT
                    COUNT(*) AS total_laporan,
                    SUM(CASE WHEN progress_opd = 'menunggu konfirmasi' THEN 1 ELSE 0 END) AS menunggu,
                    SUM(CASE WHEN progress_opd = 'selesai' THEN 1 ELSE 0 END) AS selesai
                FROM pengaduan
                WHERE id_opd = '$id_opd'
            ");
            $statistik = mysqli_fetch_assoc($query_statistik);
        ?>

        <section class="summary-cards">
            <div class="card">
                <div class="card-icon icon-blue">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="card-label">
                    TOTAL LAPORAN
                </div>
                <div class="card-value">
                    <?= $statistik['total_laporan'] ? $statistik['total_laporan'] : 0 ?>
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
                     <?= $statistik['menunggu'] ? $statistik['menunggu'] : 0 ?>
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
                     <?= $statistik['selesai'] ? $statistik['selesai'] : 0 ?>
                </div>
            </div>
        </section>

        <section class="charts-section" id="chartsContainer"
            data-total="<?= $statistik['total_laporan'] ? $statistik['total_laporan'] : 0 ?>"
            data-menunggu="<?= $statistik['menunggu'] ? $statistik['menunggu'] : 0 ?>"
            data-selesai="<?= $statistik['selesai'] ? $statistik['selesai'] : 0 ?>">
            
            <div class="chart-card">
                <h3>Grafik Batang (Statistik)</h3>
                <canvas id="barChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Grafik Lingkaran (Proporsi)</h3>
                <canvas id="pieChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Grafik Garis (Alur Jumlah)</h3>
                <canvas id="lineChart"></canvas>
            </div>
        </section>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../JS/components/sidebar.js"></script>
<script src="../../JS/components/utils.js"></script>
<script src="../../JS/components/modal.js"></script>
<script src="../../JS/pages/dashboard_admin.js"></script> 

</body>
</html>