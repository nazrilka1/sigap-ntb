<?php
include "koneksi.php";


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Laporan - SIGAP NTB</title>

    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/status.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.html" class="nav-logo">
                <img src="../Assets/images/logo-ntb.png" alt="Logo NTB" class="logo-img">

                <div>
                    <span class="logo-text">PEMERINTAH NUSA TENGGARA BARAT</span>
                    <p>SIGAP NUSA TENGGARA BARAT</p>
                </div>
            </a>
            
            <ul class="nav-links" id="navLinks">
                <li><a href="../index.php">Beranda</a></li>
                <li><a href="pengaduan.php">Pengaduan</a></li>
                <li><a href="status.php" class="active">Status Pengaduan</a></li>
                <li><a href="riwayat.php">Riwayat Pengaduan</a></li>
            </ul>

            <div class="nav-actions">
                <a href="../pages/login.php" class="btn btn-login">Login</a>

                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Buka menu">
                    ☰
                </button>
            </div>
        </div>
    </nav>

    <main class="status-page">

        <section class="status-hero">
            <div class="container">
                <div class="status-hero-content">
                    <span class="status-badge">Transparansi Laporan</span>

                    <h1>Cek Status Laporan</h1>

                    <p>
                        Pantau perkembangan aduan Anda secara real-time. Kami berkomitmen untuk transparansi dan kecepatan
                        dalam menanggapi setiap laporan warga demi NTB yang Gemilang.
                    </p>
                </div>
            </div>
        </section>

        <section class="status-search-section">
            <div class="container">
                <form class="status-search-card" method="GET">
                    <div class="status-form-group">
                        <label for="kode_laporan">Kode Laporan</label>

                        <div class="status-input-icon">
                            <span class="material-symbols-outlined">search</span>
                            <input 
                                type="text" 
                                id="kode_laporan" 
                                name="kode_laporan"
                                value="<?= isset($_GET['kode_laporan']) ? htmlspecialchars($_GET['kode_laporan']) : '' ?>"
                                placeholder="Contoh: NTB-2024-XXXX">
                        </div>
                    </div>

                     <div class="status-form-group">
                        <label for="wilayah">Wilayah / Kabupaten</label>

                        <select id="wilayah" name="wilayah">

                            <option value=""
                            <?= (!isset($_GET['wilayah']) || $_GET['wilayah']=="") ? "selected" : "" ?>>
                                Semua Wilayah
                            </option>

                            <option value="kota mataram"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kota mataram") ? "selected" : "" ?>>
                                Kota Mataram
                            </option>

                            <option value="kab. lombok barat"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. lombok barat") ? "selected" : "" ?>>
                                Kab. Lombok Barat
                            </option>

                            <option value="kab. lombok tengah"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. lombok tengah") ? "selected" : "" ?>>
                                Kab. Lombok Tengah
                            </option>

                            <option value="kab. lombok timur"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. lombok timur") ? "selected" : "" ?>>
                                Kab. Lombok Timur
                            </option>

                            <option value="kab. lombok utara"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. lombok utara") ? "selected" : "" ?>>
                                Kab. Lombok Utara
                            </option>

                            <option value="kab. sumbawa"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. sumbawa") ? "selected" : "" ?>>
                                Kab. Sumbawa
                            </option>

                            <option value="kab. sumbawa barat"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. sumbawa barat") ? "selected" : "" ?>>
                                Kab. Sumbawa Barat
                            </option>

                            <option value="kab. dompu"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. dompu") ? "selected" : "" ?>>
                                Kab. Dompu
                            </option>

                            <option value="kab. bima"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kab. bima") ? "selected" : "" ?>>
                                Kab. Bima
                            </option>

                            <option value="kota bima"
                            <?= (isset($_GET['wilayah']) && $_GET['wilayah']=="kota bima") ? "selected" : "" ?>>
                                Kota Bima
                            </option>

                        </select>
                    </div>


                    <button type="submit" class="status-search-btn" name=cari_laporan>
                        Cari Laporan
                    </button>
                </form>
            </div>
        </section>


        <section class="status-content">
            <div class="container">
                <div class="status-section-header">
                    <div>
                        <span class="status-section-label">Data Laporan</span>
                        <h2>Daftar Laporan Terbaru</h2>
                        <p>Menampilkan laporan publik terkini di wilayah Nusa Tenggara Barat.</p>
                    </div>
                </div>

                <div class="status-table-card">
                    <div class="status-table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Kode Laporan</th>
                                    <th>Jenis Laporan</th>
                                    <th>Wilayah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
    
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                        

                                $kode     = isset($_GET['kode_laporan']) ? mysqli_real_escape_string($conn, $_GET['kode_laporan']) : '';
                                $wilayah  = isset($_GET['wilayah']) ? mysqli_real_escape_string($conn, $_GET['wilayah']) : '';

                                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

                                $tampilkan = mysqli_query($conn,"
                                    SELECT *
                                    FROM pengaduan
                                    WHERE
                                        ('$kode' = '' OR kode_laporan = '$kode')
                                    AND
                                        ('$wilayah' = '' OR wilayah = '$wilayah')
                                    ORDER BY id_pengaduan DESC
                                    LIMIT $limit
                                ");



                            while($data = mysqli_fetch_assoc($tampilkan)){
                            ?>
                                <tr>
                                    <td class="report-code"><?= $data['kode_laporan']?></td>
                                    <td><?= $data['jenis_laporan']?></td>
                                    <td><?= $data['wilayah']?></td>
                                    <td class="text-muted"><?= $data['tanggal_laporan']?></td>
                                    <td>
                                        <?php

                                        $class = "status-process";

                                        if($data['status']=="selesai"){
                                            $class = "status-completed";
                                        }
                                        elseif($data['status']=="menunggu"){
                                            $class = "status-pending";
                                        }
                                        elseif($data['status']=="ditolak"){
                                            $class = "status-rejected";
                                        }

                                        ?>

                                        <span class="status-pill <?= $class ?>">
                                            <?= ucfirst($data['status']) ?>
                                        </span>
                                                                            </td>
                                    
                                </tr>

                               <?php } $total = mysqli_query($conn,"
                                    SELECT COUNT(*) AS jumlah
                                    FROM pengaduan
                                    WHERE
                                        ('$kode' = '' OR kode_laporan = '$kode')
                                    AND
                                        ('$wilayah' = '' OR wilayah = '$wilayah')
                                ");

                                $total_data = mysqli_fetch_assoc($total);?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                if($limit < $total_data['jumlah']){
                ?>

                <a
                    class="status-load-btn"
                    href="?kode_laporan=<?= urlencode($kode) ?>&wilayah=<?= urlencode($wilayah) ?>&limit=<?= $limit + 10 ?>">

                    Tampilkan Lebih Banyak

                </a>

                <?php } ?>
            </div>
        </section>

    </main>
    
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <img src="../Assets/images/logo-ntb.png" alt="Logo NTB" class="logo-img">

                <div>
                    <h3>PEMERINTAH NUSA TENGGARA BARAT</h3>
                    <p>Sistem Pengaduan Masyarakat Nusa Tenggara Barat</p>
                </div>
            </div>

                        <div class="footer-links">
                <a href="#">Contact Us</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">FAQ</a>
            </div>
            
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', function () {
                navLinks.classList.toggle('active');
            });
        }

        const navbar = document.querySelector('.navbar');

        if (navbar) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 20) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }
    </script>

</body>
</html>
