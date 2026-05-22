<?php

session_start();

include 'koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['userlogin'];
    $password = $_POST['passlogin'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM operator 
        WHERE username='$username' 
        AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['username'] = $data['username'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['role'] = $data['role'];

        // Redirect sesuai role
        if($data['role'] == 'admin'){

            header("Location: ../pages/admin/dashboard_admin.php");
            exit();

        } elseif($data['role'] == 'opd'){

            header("Location: ../pages/opd/dashboard_opd.php");
            exit();

        } else {

            echo "Role tidak ditemukan";
        }

    } else {

        echo "Username atau password salah";
    }
}
?>