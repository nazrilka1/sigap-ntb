<?php

include "koneksi.php";

if(isset($_POST['bupdate'])){
    $id = $_POST['uid'];
    $nama = $_POST['unama'];
    $judul = $_POST['ujudul'];
    $kategori = $_POST['ukategori'];
    $status = $_POST['ustatus'];

    $ubah = mysqli_query($conn, "UPDATE pengaduan SET 
                                   nama_pelapor='$nama',
                                   deskripsi_laporan='$judul',
                                   jenis_laporan='$kategori'
                                   WHERE id_pengaduan='$id'");

    if($ubah){
        echo "<script>alert('Data berhasil diupdate');document.location='../pages/admin/kelola_laporan_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal update');document.location='../pages/admin/kelola_laporan_admin.php';</script>";
    }
}


if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    $hapus = mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan='$id'");

    if($hapus){
        echo "<script>alert('Data berhasil dihapus');document.location='../pages/admin/kelola_laporan_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal hapus');document.location='../pages/admin/kelola_laporan_admin.php';</script>";
    }
}
?>