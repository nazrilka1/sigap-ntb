<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'opd'){
    header("Location: ../pages/login.php");
    exit();
}

if(isset($_POST['dupdate'])){

    $required = ['dprogress', 'dketerangan', 'uid'];
    foreach($required as $field){
        if(empty($_POST[$field])){
            die("Field $field wajib diisi");
        }
    }

    $progress     = mysqli_real_escape_string($conn, $_POST['dprogress']);
    $keterangan   = mysqli_real_escape_string($conn, $_POST['dketerangan']);
    $id_pengaduan = $_POST['uid'];

    $progress_diizinkan = ['sedang dikerjakan', 'menunggu', 'selesai'];
    if(!in_array($progress, $progress_diizinkan)){
        die("Status progress tidak valid");
    }

    $nama_file_progress = null;

    if(isset($_FILES['dfoto']) && $_FILES['dfoto']['error'] === UPLOAD_ERR_OK){

        $folder = 'uploads/';

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];
        $ukuran_maks        = 5 * 1024 * 1024; 

        $file_asli = $_FILES['dfoto']['name'];
        $file_tmp  = $_FILES['dfoto']['tmp_name'];
        $file_size = $_FILES['dfoto']['size'];

        $ekstensi = strtolower(pathinfo($file_asli, PATHINFO_EXTENSION));

        if (!in_array($ekstensi, $ekstensi_diizinkan)) {
            die("Tipe file tidak diizinkan. Hanya JPG, JPEG, PNG, WEBP.");
        }

        if ($file_size > $ukuran_maks) {
            die("Ukuran file maksimal 5MB");
        }

        $mime_diizinkan = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file_tmp);
        finfo_close($finfo);

        if (!in_array($mime, $mime_diizinkan)) {
            die("File bukan gambar yang valid");
        }

        $nama_file_progress = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ekstensi;

        if (!move_uploaded_file($file_tmp, $folder . $nama_file_progress)) {
            die("Upload foto progress gagal");
        }
    }

    if($nama_file_progress !== null){
        $query = mysqli_query($conn,
            "UPDATE pengaduan
             SET progress_opd='$progress',
                 keterangan_progress='$keterangan',
                 foto_sesudah='$nama_file_progress'
             WHERE id_pengaduan='$id_pengaduan'"
        );
    } else {
        $query = mysqli_query($conn,
            "UPDATE pengaduan
             SET progress_opd='$progress',
                 keterangan_progress='$keterangan'
             WHERE id_pengaduan='$id_pengaduan'"
        );
    }

    if($query){
        header("Location: ../pages/opd/kelola_laporan_opd.php");
        exit();
    } else {
        if($nama_file_progress !== null){
            unlink($folder . $nama_file_progress);
        }
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>