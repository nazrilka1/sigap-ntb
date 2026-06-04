<?php
include "koneksi.php";

if(isset($_POST['submit'])){

    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenis_laporan = $_POST['jenis'];
    $alamat_kejadian = $_POST['alamat_kejadian'];
    $deskripsi = $_POST['deskripsi'];
    $latitude = $_POST['lat'];
    $longitude = $_POST['lng'];

    $folder = 'uploads/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $nama_file = time() . '_' . $_FILES['foto_bukti']['name'];
    $tmp_file = $_FILES['foto_bukti']['tmp_name'];

    if (!move_uploaded_file($tmp_file, $folder.$nama_file)) {
        die("Upload gagal");
    }

    $query = mysqli_query($conn,
        "INSERT INTO pengaduan 
        (nama_pelapor,nik,alamat,jenis_laporan,alamat_kejadian,deskripsi_laporan,bukti_file,latitude,longitude)
        VALUES
        ('$nama','$nik','$alamat','$jenis_laporan','$alamat_kejadian','$deskripsi','$nama_file','$latitude','$longitude')"
    );

    if($query){
        echo "<script>alert('Data berhasil ditambahkan');document.location='Pengaduan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');document.location='index.php';</script>";
    }
}
?>