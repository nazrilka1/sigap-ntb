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
    <title>Dashboard OPD</title>
    
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/components/sidebar.css">
    <link rel="stylesheet" href="../../CSS/components/topbar.css">
    <link rel="stylesheet" href="../../CSS/components/opd_panel.css">
    <link rel="stylesheet" href="../../CSS/components/toast.css">
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
                    <li class="nav-item active">
                        <a href="dashboard_opd.html" class="nav-link">
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
                        <a href="pengaturan_opd.html" class="nav-link">
                            <i class="fas fa-cog"></i>
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

        <main class="main-content opd-main">
            <div class="opd-header-wrap">
                
                <div class="opd-title-wrapper">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="opd-title-area">
                        <span class="opd-subtitle">DASHBOARD EKSEKUSI</span>
                        <?php
                        $query = mysqli_query($conn,"SELECT * FROM operator
                                                    WHERE role = '".$_SESSION['role']."' ");

                        $data = mysqli_fetch_assoc($query);
                        if($data['username']=='dispupr'){
                           echo'<h1 class="opd-title">Dinas PUPR NTB</h1>';
                        }else{
                            
                            echo'<h1 class="opd-title">Dinas Perhubungan NTB</h1>';
                        }

                        ?>
                        <p class="opd-desc">Fokus pada penyelesaian laporan masyarakat secara cepat, transparan, dan akuntabel untuk NTB yang Gemilang.</p>
                    </div>
                </div>
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

                <div class="opd-stats-area">
                    <div class="stat-badge stat-blue">
                        <div class="stat-icon-wrap"><i class="far fa-calendar-alt"></i></div>
                        <div class="stat-text-wrap">
                            <span class="stat-label">MENUNGGU</span>
                            <span class="stat-number"><?=$statistik['menunggu_konfirmasi']?> </span>
                        </div>
                    </div>
                    <div class="stat-badge stat-green">
                        <div class="stat-icon-wrap"><i class="far fa-check-circle"></i></div>
                        <div class="stat-text-wrap">
                            <span class="stat-label">SELESAI</span>
                            <span class="stat-number"><?=$statistik['selesai']?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-heading-row">
                <h2>Laporan Masuk</h2>
                <div class="sort-action">
                    <i class="fas fa-sort-amount-down"></i> Urutkan: Terbaru
                </div>
            </div>

            <div class="opd-report-list">
                <?php

                $tampilkan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_opd = '$id_opd'");
                while($data = mysqli_fetch_assoc($tampilkan)){


                ?>
                
                <div class="opd-report-card card-hover-effect">
                    <div class="report-content-left">
                        <div class="report-tags">
                            <span class="badge badge-red"><?= $data['jenis_laporan']?></span>
                            <span class="report-id">ID:<?= $data['kode_laporan']?></span>
                            <span class="report-time"><?= $data['tanggal_laporan']?></span>
                        </div>
                        <h3 class="report-heading"><?= $data['judul_laporan']?></h3>
                        <p class="report-paragraph"><?= $data['deskripsi_laporan']?></p>
                        <div class="report-meta">
                            <span><i class="far fa-map"></i> <?= $data['alamat_kejadian']?></span>
                            <span><i class="far fa-user"></i> <?= $data['nama_pelapor']?></span>
                        </div>
                    </div>
                    <div class="report-action-right">
                        <div class="form-group-light">
                        <form action="../../php/aksi_opd.php" method ='post'>
                         <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan'] ?>">
                            <label>GANTI STATUS</label>
                            <select class="form-control form-light" name = 'dprogress'>
                                <option value="sedang dikerjakan" <?= $data['progress_opd']=='sedang dikerjakan' ? 'selected' : "" ?>>Sedang Dikerjakan</option>
                                <option value="menunggu konfirmasi" <?= $data['progress_opd']=='menunggu konfirmasi' ? 'selected' : "" ?>>Menunggu Konfirmasi</option>
                                <option value="selesai" <?= $data['progress_opd']=='selesai' ? 'selected' : "" ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group-light">
                            <label>KETERANGAN PROGRESS</label>
                            <textarea class="form-control form-light" rows="3" placeholder="Masukkan update penanganan..." name='dketerangan'></textarea>
                        </div>
                        <button class="btn-action btn-green w-100 btn-update" onclick="window.showToast()" name='dupdate'>Update Progress</button>
                        </form>
                    </div>
                </div>
                <?php } ?>

            </div>

            <div class="opd-bottom-grid">
                <div class="opd-map-card card-hover-effect">
                    <div class="map-text">
                        <h3>Visualisasi Lokasi Laporan</h3>
                        <p>Peta sebaran laporan masuk untuk wilayah kerja Dinas Perhubungan NTB bulan ini.</p>
                        <button class="btn-action btn-yellow-solid">Buka Peta Interaktif</button>
                    </div>
                    <div class="map-image-placeholder">
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" alt="Map Illustration">
                    </div>
                </div>

                <div class="opd-activity-card card-hover-effect">
                    <h3>Aktivitas Tim</h3>
                    <ul class="activity-timeline">
                        <li>
                            <div class="activity-icon icon-success"><i class="fas fa-check"></i></div>
                            <div class="activity-detail">
                                <p><strong>Bpk. Suryono</strong> menyelesaikan peninjauan Marka Pagutan.</p>
                            </div>
                        </li>
                        <li>
                            <div class="activity-icon icon-neutral"><i class="fas fa-list-ul"></i></div>
                            <div class="activity-detail">
                                <p><strong>Admin</strong> mengubah status laporan #NTB-8821 ke "Dikerjakan".</p>
                            </div>
                        </li>
                    </ul>
                    <button class="btn-outline-border w-100">Lihat Semua Log</button>
                </div>
            </div>
            
            <div class="toast-notification" id="toastNotif">
                <i class="fas fa-check-circle"></i>
                <span>Status berhasil diperbarui!</span>
            </div>

        </main>
    </div>

    <footer class="opd-footer">
        <div class="footer-left">
            <h2>Pemerintah NTB</h2>
            <p>© 2026 Pemerintah Provinsi Nusa Tenggara Barat. Melayani dengan Gemilang.</p>
        </div>
        <div class="footer-right">
            <a href="#">Contact Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">FAQ</a>
        </div>
    </footer>

    <script src="../../js/components/sidebar.js"></script>
    <script src="../../js/components/utils.js"></script>
</body>
</html>
