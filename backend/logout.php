<?php
session_start();
// if (isset($_SESSION['name'])){
    $_SESSION=[];
    unset ($_SESSION);
    session_destroy();
    //
    header("Location:login.php");
    // echo "<h1>Anda sudah berhasil LOGOUT</h1>";
    // echo "<h2>Klik <a href = 'login.php'>di sini</a> untuk LOGIN kembali</h2>";
    // echo "<h2>Anda sekarang tidak bisa masuk ke halaman <a href = 'index.php'>index.php</a> lagi </h2>";
// }
?>