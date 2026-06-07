<?php

include "koneksi.php";

if(isset($_POST['dupdate'])){

    $progress = $_POST['dprogress'];
    $keterangan = $_POST['dketerangan'];
    $id_pengaduan = $_POST['id_pengaduan'];

    $query = mysqli_query($conn,
        "UPDATE pengaduan
         SET progress_opd='$progress',
             keterangan_progress='$keterangan'
         WHERE id_pengaduan='$id_pengaduan'"
    );

    if($query){
        header("Location: ../pages/opd/dashboard_opd.php");
        exit();
    }else{
        echo mysqli_error($conn);
    }
}
?>