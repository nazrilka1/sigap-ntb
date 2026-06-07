<?php
include "../pages/admin/kelola_laporan_admin.php";
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


if(isset($_POST['bteruskan'])){

    $id_pengaduan = $_POST['id_pengaduan'];
    $id_opd = $_POST['id_opd'];

    $query = mysqli_query(
        $conn,
        "UPDATE pengaduan
        SET
            id_opd='$id_opd',
            status='diteruskan'
        WHERE id_pengaduan='$id_pengaduan'"
    );

    if($query){

        echo "
        <script>
        alert('Laporan berhasil diteruskan');
        location='../pages/admin/kelola_laporan_admin.php';
        </script>
        ";

    }else{

        echo "
        <script>
        alert('Gagal meneruskan laporan');
        history.back();
        </script>
        ";

    }
}
?>
