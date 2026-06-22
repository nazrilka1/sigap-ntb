<?php

session_start();

include 'koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['userlogin'];
    $password = $_POST['passlogin'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM operator 
        WHERE username='$username'"
    );

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        if(!password_verify($password, $data['password'])){
            echo "<script>
                alert('Username atau password salah!');
                window.history.back();
            </script>";
            exit();
        }

        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['id_opd'] = $data['id_opd'];

        date_default_timezone_set('Asia/Makassar');
        $waktu = date('Y-m-d H:i:s');

        mysqli_query($conn,"
            UPDATE operator
            SET login_terakhir = '$waktu'
            WHERE username = '$username'
        ");

        if($data['role'] == 'admin'){
            header("Location: ../pages/admin/dashboard_admin.php");
            exit();
        } elseif($data['role'] == 'opd'){
            header("Location: ../pages/opd/dashboard_opd.php");
            exit();
        } else {
            echo "<script>
                alert('Role tidak ditemukan!');
                window.history.back();
            </script>";
        }

    } else {
        
        echo "<script>
            alert('Username atau password salah!');
            window.history.back();
        </script>";
    }
}
?>
