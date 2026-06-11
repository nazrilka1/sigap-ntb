<?php
    include "koneksi.php";

    $nama     = isset($_GET['search_laporan']) ? mysqli_real_escape_string($conn, $_GET['search_laporan']) : '';
    $progress   = isset($_GET['filter_status']) ? mysqli_real_escape_string($conn, $_GET['filter_status']) : '';
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
                                value="<?= isset($_GET['search_laporan']) ? $_GET['search_laporan'] : '' ?>"
                            >
                        </div>
                    </div>

                    <div class="filter-item">
                        <label for="filter_status">Status</label>

                        <select id="filter_status" name="filter_status">
                            <option value="">Semua Status</option>

                            <option value="sedang dikerjakan"
                            <?= ($progress=="sedang dikerjakan") ? "selected" : "" ?>>
                            sedang dikerjakan
                            </option>

                            <option value="menunggu konfirmasi"
                            <?= ($progress=="menunggu konfirmasi") ? "selected" : "" ?>>
                            menunggu konfirmasi
                            </option>

                            <option value="selesai"
                            <?= ($progress=="selesai") ? "selected" : "" ?>>
                            selesai
                            </option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label for="filter_tanggal">Tanggal</label>
                        <input type="date" id="filter_tanggal" name="filter_tanggal" value="<?= $tanggal ?>">
                    </div>
                    <button
                            type="submit"
                            name="filter"
                            class="btn btn-primary">
                            Filter Pencarian
                    </button>

                    <button type="button" class="btn-reset" onclick="window.location='riwayat.php'">
                        <span class="material-symbols-outlined">filter_alt_off</span>
                        Reset
                    </button>
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
                                FROM pengaduan  WHERE
                                    ('$nama'='' OR nama_pelapor LIKE '%$nama%')
                                AND
                                    ('$progress'='' OR progress_opd='$progress')
                                AND
                                    ('$tanggal'='' OR DATE(tanggal_laporan)='$tanggal')
                            ");

                            $total_data = mysqli_fetch_assoc($total_data_query)['total'];

                            $total_halaman = ceil($total_data / $limit);
                                                    

                           

                            $tampilkan = mysqli_query($conn,"
                                SELECT *
                                FROM pengaduan
                                WHERE
                                    ('$nama' = '' OR nama_pelapor LIKE '%$nama%')
                                AND
                                    ('$progress' = '' OR progress_opd = '$progress')
                                AND
                                    ('$tanggal' = '' OR DATE(tanggal_laporan) = '$tanggal')
                                ORDER BY id_pengaduan ASC
                                LIMIT $offset,$limit
                            ");
                            



                        while($data = mysqli_fetch_assoc($tampilkan)){
                            
                        ?>

                <article class="report-card">
                    <div class="card-body">
                        <div class="card-main">
                            <div class="card-meta">
                                <?php
                                $status = strtolower($data['progress_opd']);

                                $badge = "badge-pending";

                                if($data['progress_opd'] == "selesai"){
                                    $badge = "badge-success";
                                }
                                elseif($data['progress_opd'] == "sedang dikerjakan"){
                                    $badge = "badge-process";
                                }
                                elseif($data['progress_opd'] == "menunggu konfirmasi"){
                                    $badge = "badge-pending";
                                }

                                ?>
                                <span class="badge <?= $badge ?> "><?=$data['progress_opd']?></span>
                                <span class="separator">|</span>
                                <span class="report-id"><?=$data['kode_laporan']?></span>
                            </div>

                            <h3 class="report-title"><?=$data['judul_laporan']?></h3>

                            <div class="report-info">
                                <div class="info-item">
                                    <span class="material-symbols-outlined">jenis laporan</span>
                                    <span><?=$data['jenis_laporan']?></span>
                                </div>

                                <div class="info-item">
                                    <span class="material-symbols-outlined">calendar_today</span>
                                    <span><?=$data['tanggal_laporan']?></span>
                                </div>
                            </div>

                            <div class="alert-box alert-error">
                                <p class="alert-label">Keterangan:</p>
                                <p class="alert-text">
                                   <?=$data['keterangan_progress']?>
                                </p>
                            </div>
                        </div>

                        <div class="card-side">
                            <button type="button" class="btn-view" onclick="openModal('detail<?= $data['id_pengaduan'] ?>')">
                                <span class="material-symbols-outlined">visibility</span>
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </article>
                <!-- MODAL -->
                <div class="modal" id="detail<?= $data['id_pengaduan'] ?>">

                    <div class="modal-content">

                        <span
                            class="close"
                            onclick="closeModal('detail<?= $data['id_pengaduan'] ?>')">
                            &times;
                        </span>

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
                                <td><?= $data['progress_opd'] ?></td>
                            </tr>

                            <tr>
                                <th>Deskripsi</th>
                                <td><?= $data['deskripsi_laporan'] ?></td>
                            </tr>

                        </table>

                    </div>

                </div>
                

               <?php } ?>


            </section>
           

            <div class="pagination">

            <?php if($halaman > 1){ ?>
                <a class="page-nav"
                href="?page=<?= $halaman-1 ?>">
                ←
                </a>
            <?php } ?>

            <?php for($i=1;$i<=$total_halaman;$i++){ ?>

                <a
                    href="?page=<?= $halaman-1 ?>&search_laporan=<?= urlencode($nama) ?>&filter_status=<?= urlencode($progress) ?>&filter_tanggal=<?= urlencode($tanggal) ?>"
                    class="page-num <?= ($i==$halaman)?'active':'' ?>">

                    <?= $i ?>

                </a>

            <?php } ?>

            <?php if($halaman < $total_halaman){ ?>
                <a class="page-nav"
                href="?page=<?= $halaman+1 ?>">
                →
                </a>
            <?php } ?>

        </div>
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
console.log("JS Berjalan");

function openModal(id){
    console.log("Buka Modal:", id);

    let modal = document.getElementById(id);

    console.log(modal);

    modal.classList.add('show');
}

function closeModal(id){
    document.getElementById(id).classList.remove('show');
}
</script>

</body>
</html>
