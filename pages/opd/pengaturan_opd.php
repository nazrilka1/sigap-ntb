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

if(isset($_POST['ubahProfil'])){
    $namaLengkap = mysqli_real_escape_string($conn, $_POST['namaLengkap']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $noTelp      = mysqli_real_escape_string($conn, $_POST['noTelp']);
    $username    = $_SESSION['username'];

    mysqli_query($conn,"
        UPDATE operator
        SET nama_lengkap='$namaLengkap', email='$email', nomor_telpon='$noTelp'
        WHERE username='$username'
    ");

    echo "<script>alert('Data diri berhasil diperbarui!');</script>";
}

if(isset($_POST['ubahPassword'])){

    $passwordLama = $_POST['oldPassword'];
    $passwordBaru = $_POST['newPassword'];
    $konfirmasi   = $_POST['confirmPassword'];
    $username     = $_SESSION['username'];

    $cek = mysqli_query($conn,"SELECT password FROM operator WHERE username='$username'");
    $dataUser = mysqli_fetch_assoc($cek);

   
    if(!password_verify($passwordLama, $dataUser['password'])){
        echo "<script>alert('Password lama salah!');</script>";

    }elseif(empty($passwordBaru)){
        echo "<script>alert('Password baru tidak boleh kosong!');</script>";

    }elseif(strlen($passwordBaru) < 8){
        echo "<script>alert('Password minimal 8 karakter!');</script>";

    }elseif($passwordBaru != $konfirmasi){
        echo "<script>alert('Konfirmasi password tidak sama!');</script>";

    }else{
   
        $passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        mysqli_query($conn,"
            UPDATE operator
            SET password='$passwordHash'
            WHERE username='$username'
        ");

        echo "<script>alert('Password berhasil diubah!');</script>";
    }
}


$username = $_SESSION['username'];

$tampilkan = mysqli_query(
    $conn,
    "SELECT * FROM operator WHERE username='$username'"
);

$data = mysqli_fetch_assoc($tampilkan);

?>
<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Admin</title>
    
    <link rel="stylesheet" href="../../CSS/admin.css">
    <link rel="stylesheet" href="../../CSS/components/sidebar.css">
    <link rel="stylesheet" href="../../CSS/components/topbar.css">
    <link rel="stylesheet" href="../../CSS/components/card.css">
    <link rel="stylesheet" href="../../CSS/components/toast.css">
    <link rel="stylesheet" href="../../CSS/components/button.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="app-container">
        <!-- SIDEBAR -->
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
                    <li class="nav-item">
                        <a href="kelola_laporan_opd.php" class="nav-link">
                            <i class="far fa-file-alt"></i>
                            <span>Kelola Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="topbar">
                <div class="header-title">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>Update Profil</h1>
                        <p>Kelola informasi akun dan pengaturan keamanan Anda.</p>
                    </div>
                </div>
            </header>
            

            <div class="profile-wrapper">
                <!-- Kiri Foto & Info Singkat -->
                <div class="profile-left">
                    <div class="card profile-pic-card">
                        <div class="profile-pic-container">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Profile" class="profile-pic-preview" id="profilePicPreview">
                            <h3 class="profile-fullname"><?=$data['nama_lengkap']?></h3>
                            
                            <p class="profile-id"><?=$data['id']?></p>
                            
                            
                        </div>
                    </div>

                    <div class="card account-info-card">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Akun</h3>
                        <ul class="account-info-list">
                            <li>
                                <span class="info-label">Role Akun</span>
                                <span class="info-value"><?=$data['id']?></span>
                            </li>
                            
                            <li>
                                <span class="info-label">Login Terakhir</span>
                                <span class="info-value"><?= date('d M Y, H:i', strtotime($data['login_terakhir'])) ?> WITA</span>
                            </li>
                            <li>
                                <span class="info-label">Status</span>
                                <span class="badge badge-green-light">AKTIF</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Kanan Form Data & Password -->
                <div class="profile-right">
                     <!-- Form 1: Data Diri -->
                    <form method="POST">
                        <div class="card">
                            <h3 class="card-title"><i class="far fa-id-card"></i> Data Diri</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="namaLengkap">Nama Lengkap</label>
                                    <input type="text" id="namaLengkap" name="namaLengkap" 
                                        class="form-control" value="<?=$data['nama_lengkap']?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control" 
                                        value="<?=$data['username']?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" 
                                        class="form-control" value="<?=$data['email']?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="noTelp">Nomor Telepon</label>
                                    <input type="tel" id="noTelp" name="noTelp" 
                                        class="form-control" value="<?=$data['nomor_telpon']?>">
                                </div>
                            </div>
                        </div>
                        <div class="profile-actions">
                            <button type="reset" class="btn-action btn-outline">Reset Form</button>
                            <button type="submit" name="ubahProfil" class="btn-action btn-green">
                                <i class="fas fa-save"></i> Update Profil
                            </button>
                        </div>
                    </form>

                    <!-- Form 2: Ubah Password -->
                    <form method="POST">
                        <div class="card">
                            <h3 class="card-title"><i class="fas fa-lock"></i> Ubah Password</h3>
                            <p class="form-subtitle">Biarkan kosong jika tidak ingin mengubah password.</p>
                            <div class="form-grid">
                                <div class="form-group form-full">
                                    <label for="oldPassword">Password Lama</label>
                                    <div class="input-icon-wrap">
                                        <input type="password" id="oldPassword" name="oldPassword" class="form-control">
                                        <i class="far fa-eye toggle-password" data-target="oldPassword"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">Password Baru</label>
                                    <div class="input-icon-wrap">
                                        <input type="password" id="newPassword" name="newPassword" class="form-control">
                                        <i class="far fa-eye toggle-password" data-target="newPassword"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Konfirmasi Password</label>
                                    <div class="input-icon-wrap">
                                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">
                                        <i class="far fa-eye toggle-password" data-target="confirmPassword"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-actions">
                            <button type="reset" class="btn-action btn-outline">Reset Form</button>
                            <button type="submit" name="ubahPassword" class="btn-action btn-green">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notifikasi Toast -->
            <div class="toast-notification" id="toastNotif">
                <i class="fas fa-check-circle"></i>
                <span>Profil berhasil diperbarui!</span>
            </div>
        </main>
    </div>

    <script src="../../js/components/sidebar.js"></script>
    <script src="../../js/components/utils.js"></script>
    <script src="../../js/components/modal.js"></script>
    <script src="../../js/pages/profil.js"></script>
</body>
</html>
</body>
</html>
