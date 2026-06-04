<?php

$SERVER = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "sigap_ntb";

$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD, $DATABASE);

if(!$conn){
    die("Tidak dapat terhubung ke database : " . mysqli_connect_error());
}

?>