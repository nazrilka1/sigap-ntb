<?php
include "php/koneksi.php"; // sesuaikan path koneksi

$semuaUser = mysqli_query($conn, "SELECT id, password FROM operator");

$berhasil = 0;
$dilewati = 0;

while($row = mysqli_fetch_assoc($semuaUser)){
    // Hanya hash yang belum di-hash
    if(strpos($row['password'], '$2y$') !== 0){
        $hashed = password_hash($row['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE operator SET password='$hashed' WHERE id='".$row['id']."'");
        $berhasil++;
    } else {
        $dilewati++;
    }
}

echo "Selesai!<br>";
echo "Password di-hash: $berhasil akun<br>";
echo "Dilewati (sudah ter-hash): $dilewati akun<br>";
echo "<br><strong style='color:red'>⚠️ Hapus file ini sekarang!</strong>";
?>