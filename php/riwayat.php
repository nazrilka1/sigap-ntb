<?php
    include "koneksi.php";

    $nama     = isset($_GET['search_laporan']) ? mysqli_real_escape_string($conn, $_GET['search_laporan']) : '';
    $tanggal  = isset($_GET['filter_tanggal']) ? mysqli_real_escape_string($conn, $_GET['filter_tanggal']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan - SIGAP NTB</title>

    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/riwayat.css">
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
                <li><a href="pengaduan.php" >Pengaduan</a></li>
                <li><a href="status.php" >Status Pengaduan</a></li>
                <li><a href="riwayat.php" class="active">Riwayat Pengaduan</a></li>
            </ul>

            <div class="nav-actions">
                <a href="../pages/login.php" class="btn btn-login">Login</a>
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Buka menu">
                    ☰
                </button>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">

            <header class="page-header">
                <h1>Riwayat Pengaduan Saya</h1>
                <p>
                    Pantau seluruh status laporan dan pengaduan Anda. Kami berkomitmen untuk transparansi 
                    dan penyelesaian yang cepat demi NTB Gemilang.
                </p>
            </header>

            <section class="filter-card">
                <form method='get'>
                <div class="filter-grid">
                
                    <div class="filter-item flex-grow">
                        <label for="search_laporan">Cari Laporan</label>
                        <div class="search-input">
                            <span class="material-symbols-outlined">search</span>
                            <input 
                                type="text" 
                                id="search_laporan"
                                name="search_laporan"
                                placeholder="Cari ID Laporan atau kata kunci..."
                                value="<?= isset($_GET['search_laporan']) ? htmlspecialchars($_GET['search_laporan']) : '' ?>"
                            >
                        </div>
                    </div>

                    <div class="filter-item">
                        <label for="filter_tanggal">Tanggal</label>
                        <input type="date" id="filter_tanggal" name="filter_tanggal" value="<?= htmlspecialchars($tanggal) ?>">
                    </div>
                    
                    <div style="display: flex; gap: 10px; align-items: flex-end;">
                        <button type="submit" name="filter" class="btn-action btn-green" style="height: 42px;">
                            Filter Pencarian
                        </button>

                        <a href="riwayat.php" class="btn-action btn-outline" style="height: 42px; box-sizing: border-box;">
                            Reset
                        </a>
                    </div>
                </div>
             </form>
            </section>
            

            <section class="reports-list">
                  <?php
                            $limit = 3;
                            $halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                            if($halaman < 1){
                                $halaman = 1;
                            }

                            $offset = ($halaman - 1) * $limit;
                            
                            $total_data_query = mysqli_query($conn,"
                                SELECT COUNT(*) as total
                                FROM pengaduan WHERE
                                    ('$nama'='' OR nama_pelapor LIKE '%$nama%' OR kode_laporan LIKE '%$nama%')
                                AND
                                    progress_opd IN ('selesai', 'ditolak', 'Ditolak', 'DITOLAK')
                                AND
                                    ('$tanggal'='' OR DATE(tanggal_laporan)='$tanggal')
                            ");

                            $total_data = mysqli_fetch_assoc($total_data_query)['total'];
                            $total_halaman = ceil($total_data / $limit);

                            $tampilkan = mysqli_query($conn,"
                                SELECT *
                                FROM pengaduan
                                WHERE
                                    ('$nama' = '' OR nama_pelapor LIKE '%$nama%' OR kode_laporan LIKE '%$nama%')
                                AND
                                    progress_opd IN ('selesai', 'ditolak', 'Ditolak', 'DITOLAK')
                                AND
                                    ('$tanggal' = '' OR DATE(tanggal_laporan) = '$tanggal')
                                ORDER BY id_pengaduan ASC
                                LIMIT $offset,$limit
                            ");

                        while($data = mysqli_fetch_assoc($tampilkan)){
                        ?>

                <article class="report-card">
                    <div class="card-body" style="display: block;">
                        <div class="card-main">
                            <div class="card-meta">
                                <?php
                                $status = strtolower($data['progress_opd']);
                                $badge = "badge-pending";

                                if($status == "selesai"){
                                    $badge = "badge-success";
                                }
                                elseif($status == "ditolak"){
                                    $badge = "badge-danger"; 
                                }
                                elseif($status == "sedang dikerjakan"){
                                    $badge = "badge-process";
                                }
                                elseif($status == "menunggu"){
                                    $badge = "badge-pending";
                                }
                                ?>
                                <span class="badge <?= $badge ?> "><?= ucfirst($data['progress_opd']) ?></span>
                                <span class="separator">|</span>
                                <span class="report-id"><?=$data['kode_laporan']?></span>
                            </div>

                            <div class="report-info" style="margin-bottom: 8px;">
                                <div class="info-item">
                                    <span>Jenis Laporan:</span> 
                                    <span><?=$data['jenis_laporan']?></span>
                                </div>
                                <div class="info-item">
                                    <span>Tanggal:</span>
                                    <span><?=$data['tanggal_laporan']?></span>
                                </div>
                            </div>

                            <h3 class="report-title" style="margin-bottom: 12px; font-size: 16px;">
                                Judul Laporan: <?=$data['judul_laporan']?>
                            </h3>

                            <div class="alert-box" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px;">
                                <p class="alert-label" style="color: #475569; margin: 0; font-weight: 600;">Keterangan / Alasan:</p>
                                <p class="alert-text-biru">
                                   <?= nl2br(htmlspecialchars($data['keterangan_progress'])) ?>
                                </p>
                            </div>
                        </div>

                        <div class="action-bottom">
                            <button type="button" class="btn-lihat-detail" onclick="openModal('detail<?= $data['id_pengaduan'] ?>')">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </article>

                <div class="modal" id="detail<?= $data['id_pengaduan'] ?>">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('detail<?= $data['id_pengaduan'] ?>')">&times;</span>
                        <h2>Detail Laporan</h2>

                        <table class="detail-table">
                            <tr>
                                <th>Kode Laporan</th>
                                <td><?= $data['kode_laporan'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pelapor</th>
                                <td><?= $data['nama_pelapor'] ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Laporan</th>
                                <td><?= $data['jenis_laporan'] ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= ucfirst($data['progress_opd']) ?></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><?= nl2br(htmlspecialchars($data['deskripsi_laporan'])) ?></td>
                            </tr>
                            <tr>
                                <th>Foto Progress Pekerjaan / Bukti Penolakan</th>
                                <td>
                                    <?php
                                    $folder_upload = "uploads/";   
                                    $file_foto     = $data['foto_sesudah'];
                                    $path_lengkap  = $folder_upload . $file_foto;
                                    ?>

                                    <?php if(!empty($file_foto) && file_exists($path_lengkap)): ?>
                                        <div class="foto-bukti-box">
                                            <img
                                                src="<?= $folder_upload . htmlspecialchars($file_foto) ?>"
                                                alt="Bukti Laporan"
                                                class="foto-bukti-img"
                                                onclick="bukaLightbox('<?= $folder_upload . htmlspecialchars($file_foto) ?>')">

                                            <a href="<?= $folder_upload . htmlspecialchars($file_foto) ?>" download="<?= htmlspecialchars($file_foto) ?>" class="btn-action btn-outline">
                                                <i class="fas fa-download"></i> Download Foto
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="value text-muted">Tidak ada foto</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
               <?php } ?>
            </section>
            
           <div class="pagination">
                <?php if($halaman > 1){ ?>
                    <a class="page-nav" href="?page=<?= $halaman-1 ?>&search_laporan=<?= urlencode($nama) ?>&filter_tanggal=<?= urlencode($tanggal) ?>">&larr;</a>
                <?php } ?>

                <?php for($i = 1; $i <= $total_halaman; $i++){ ?>
                    <a href="?page=<?= $i ?>&search_laporan=<?= urlencode($nama) ?>&filter_tanggal=<?= urlencode($tanggal) ?>" class="page-num <?= ($i==$halaman) ? 'active' : '' ?>"><?= $i ?></a>
                <?php } ?>

                <?php if($halaman < $total_halaman){ ?>
                    <a class="page-nav" href="?page=<?= $halaman+1 ?>&search_laporan=<?= urlencode($nama) ?>&filter_tanggal=<?= urlencode($tanggal) ?>">&rarr;</a>
                <?php } ?>
            </div>
    </main>

    <div class="lightbox-overlay" id="lightboxFoto">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightboxImg" class="lightbox-img" src="" alt="Foto Bukti">
    </div>

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
    function bukaLightbox(src){
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxFoto').classList.add('show');
    }

    function closeLightbox(){
        document.getElementById('lightboxFoto').classList.remove('show');
        document.getElementById('lightboxImg').src = '';
    }

    function openModal(id){
        let modal = document.getElementById(id);
        if(modal) modal.classList.add('show');
    }

    function closeModal(id){
        let modal = document.getElementById(id);
        if(modal) modal.classList.remove('show');
    }
    </script>
</body>
</html>