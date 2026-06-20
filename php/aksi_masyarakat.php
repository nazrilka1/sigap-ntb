<?php
include "koneksi.php";

if(isset($_POST['submit'])){

    // ===== 1. Validasi field wajib =====
    $required = ['nama','nik','alamat','wilayah','jenis','alamat_kejadian','deskripsi','lat','lng'];
    foreach($required as $field){
        if(empty($_POST[$field])){
            die("Field $field wajib diisi");
        }
    }

    if(!isset($_FILES['foto_bukti']) || $_FILES['foto_bukti']['error'] !== UPLOAD_ERR_OK){
        die("Upload foto gagal atau belum dipilih");
    }

    // ===== 2. Ambil & escape input teks =====
    $nama            = mysqli_real_escape_string($conn, $_POST['nama']);
    $nik             = mysqli_real_escape_string($conn, $_POST['nik']);
    $alamat          = mysqli_real_escape_string($conn, $_POST['alamat']);
    $wilayah         = mysqli_real_escape_string($conn, $_POST['wilayah']);
    $jenis_laporan   = mysqli_real_escape_string($conn, $_POST['jenis']);
    $alamat_kejadian = mysqli_real_escape_string($conn, $_POST['alamat_kejadian']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Validasi koordinat harus numerik
    if(!is_numeric($_POST['lat']) || !is_numeric($_POST['lng'])){
        die("Koordinat lokasi tidak valid");
    }
    $latitude  = $_POST['lat'];
    $longitude = $_POST['lng'];

    // Validasi NIK (harus 16 digit angka, sesuaikan kalau aturan beda)
    if(!preg_match('/^\d{16}$/', $nik)){
        die("NIK harus 16 digit angka");
    }

    $kode_laporan = '#NTB-' . date('Y') . '-' . rand(1000, 1999);

    // ===== 3. Validasi file upload (BAGIAN PALING PENTING) =====
    $folder = 'uploads/';

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];
    $ukuran_maks        = 5 * 1024 * 1024; // 5 MB

    $file_asli  = $_FILES['foto_bukti']['name'];
    $file_tmp   = $_FILES['foto_bukti']['tmp_name'];
    $file_size  = $_FILES['foto_bukti']['size'];

    $ekstensi = strtolower(pathinfo($file_asli, PATHINFO_EXTENSION));

    if (!in_array($ekstensi, $ekstensi_diizinkan)) {
        die("Tipe file tidak diizinkan. Hanya JPG, JPEG, PNG, WEBP.");
    }

    if ($file_size > $ukuran_maks) {
        die("Ukuran file maksimal 5MB");
    }

    // Cek MIME type asli file (bukan cuma percaya nama ekstensi)
    $mime_diizinkan = ['image/jpeg', 'image/png', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if (!in_array($mime, $mime_diizinkan)) {
        die("File bukan gambar yang valid");
    }

    // Generate nama file aman (acak, bukan dari nama asli user)
    $nama_file = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ekstensi;

    if (!move_uploaded_file($file_tmp, $folder . $nama_file)) {
        die("Upload gagal");
    }

    // ===== 4. Insert pakai prepared statement =====
    $stmt = mysqli_prepare($conn,
        "INSERT INTO pengaduan 
        (nama_pelapor, nik, alamat, jenis_laporan, alamat_kejadian, deskripsi_laporan, bukti_file, latitude, longitude, kode_laporan, tanggal_laporan, wilayah)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssddss",
        $nama, $nik, $alamat, $jenis_laporan, $alamat_kejadian,
        $deskripsi, $nama_file, $latitude, $longitude, $kode_laporan, $wilayah
    );

    $query = mysqli_stmt_execute($stmt);

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan');document.location='Pengaduan.php';</script>";
    } else {
        // Hapus file yang sudah terlanjur diupload kalau insert gagal
        unlink($folder . $nama_file);
        echo "<script>alert('Gagal menambahkan data');document.location='index.php';</script>";
    }

    mysqli_stmt_close($stmt);
}
?>