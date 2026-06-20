<?php
// Baris include kelola_laporan_admin.php DIHAPUS. Hanya panggil koneksi.
include "koneksi.php";

if(isset($_POST['bupdate'])){
    $id = $_POST['uid'];
    $nama = $_POST['unama'];
    $judul = $_POST['ujudul'];
    $kategori = $_POST['ukategori'];
    $status = $_POST['ustatus'];

    // Perbaikan: Menambahkan status='$status' ke dalam query UPDATE
    $ubah = mysqli_query($conn, "UPDATE pengaduan SET 
                                   nama_pelapor='$nama',
                                   judul_laporan='$judul',
                                   jenis_laporan='$kategori',
                                   status='$status'
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

    // PERBAIKAN: Jangan ubah 'status' menjadi 'diteruskan' karena akan error ENUM.
    // Biarkan status tetap 'selesai' (Disetujui) di sisi admin,
    // dan kita set 'progress_opd' untuk memicu antrean di dashboard OPD.
    $query = mysqli_query(
        $conn,
        "UPDATE pengaduan SET
            id_opd='$id_opd',

            status='disetujui',

            progress_opd='menunggu'

        WHERE id_pengaduan='$id_pengaduan'"
    );

    if($query){

        echo "
        <script>
        alert('Laporan berhasil diteruskan ke OPD terkait');
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