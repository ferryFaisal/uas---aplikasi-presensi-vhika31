<!DOCTYPE HTML>  
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
      .error { color: #FF0000;

      }
      </style>
      <title>Form Input Mahasiswa</title>
    </head>
    <body> 
    <div class="container-fluid">
      <div class="container">
        
        <?php
            $nimErr = $namaErr = $kelasErr = "";
            $nim = $nama = $kelas = "";
            $valnim = $valnama = $valkelas = false;

            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["nim"])) {
                   //  $idErr = "Id is required";
                } else {
                    $nim = sanitize($_POST["nim"]);
                    
                    $valnim = true;
                }

                if(empty($_POST["nama"])) {
                    $namaErr = "Nama is required";
                } else {
                    $nama = sanitize($_POST["nama"]);
                   
                    $valnama = true;
                }

           
                if(empty($_POST["kelas"])) {
                    $kelasErr = "Kelas is required";
                } else {
                    $kelas = sanitize($_POST["kelas"]);
                   
                    $valkelas = true;
                }
            }
            function sanitize($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <h3 class="text-light">Form Input Mahasiswa</h3>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                Nim :<?php echo "<br>";?> <input type="text" name="nim" value="<?php echo $nim;?>">
                    <span class="error">*  <?php echo $nimErr;?></span>
                    <br><br>
                Nama :<?php echo "<br>";?> <input type="text" name="nama" value="<?php echo $nama;?>">
                    <span class="error">*  <?php echo $namaErr;?></span>
                    <br><br>
                Kelas :<?php echo "<br>";?> <select name="kelas">
                <option value="">---select---</option>
                <option value="5A">5A</option>
                <option value="5B">5B</option>
                style.css
                </select>
                <span class="error">* <?php echo $kelasErr;?></span>
                <br><br>

                <input class="button" type="submit" name="submit" value="Submit">
        </form>

        <?php
        if($valnama && $valkelas == true){
            echo "<h2>Your Input:</h2>";
           echo $nim;
            echo "<br>";
            echo $nama;
            echo "<br>";
            echo $kelas;
            echo "<br>";

            include "insert_mahasiswa.php";
            header('Location: table_mahasiswa.php');

        }
        ?>
    </body>
</html>