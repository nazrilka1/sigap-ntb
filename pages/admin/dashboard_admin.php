<?php

session_start();

if(!isset($_SESSION['username'])){
    header('location: ../../login.php');
    exit();
}

if($_SESSION['role'] != 'admin'){
    header('location: ../../login.php');
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
                    1,284
                </div>

                <div class="card-status status-up">
                    <i class="fas fa-arrow-up"></i>
                    +12% dari bulan lalu
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
                    42
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
                    912
                </div>

                <div class="card-status status-good">
                    <i class="fas fa-check"></i>
                    Tingkat penyelesaian tinggi
                </div>

            </div>

            <div class="card">

                <div class="card-icon icon-blue">
                    <i class="fas fa-chart-line"></i>
                </div>

                <div class="card-label">
                    RESPON RATA-RATA
                </div>

                <div class="card-value">
                    2.4 Hari
                </div>

                <div class="card-status status-good">
                    <i class="fas fa-bolt"></i>
                    Lebih cepat dari target
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
                    placeholder="Cari laporan...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>JENIS</th>
                            <th>TANGGAL</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>#NTB001</td>
                            <td>Ahmad Hidayat</td>
                            <td>Infrastruktur</td>
                            <td>21 Mei 2026</td>

                            <td>
                                <span class="badge badge-yellow-light">
                                    Diproses
                                </span>
                            </td>

                            <td>

                                <button class="action-btn">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="action-btn action-green">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button class="action-btn action-yellow">
                                    <i class="fas fa-history"></i>
                                </button>

                            </td>

                        </tr>

                        <tr>

                            <td>#NTB002</td>
                            <td>Siti Aminah</td>
                            <td>Kesehatan</td>
                            <td>20 Mei 2026</td>

                            <td>
                                <span class="badge badge-green-light">
                                    Selesai
                                </span>
                            </td>

                            <td>

                                <button class="action-btn">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="action-btn action-green">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button class="action-btn action-yellow">
                                    <i class="fas fa-history"></i>
                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

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
