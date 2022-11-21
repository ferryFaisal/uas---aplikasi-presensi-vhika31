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
      <title>Form Input User</title>
    </head>
    <body> 
    <div class="container-fluid">
      <div class="container">
        
        <?php
            $nameErr = $emailErr = $passErr = $repassErr = $roleErr = "";
            $name = $email = $pass = $repass = $role = "";
            $valName = $valEmail = $valPass = $valRepass = $valRole = false;

            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = sanitize($_POST["name"]);
                    // if(!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    //     $nameErr = "Only letters and white space allowed";
                    // }else{
                        // $valName = true;
                    // }
                    $valName = true;
                }
                if(empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } else {
                    $email = sanitize($_POST["email"]);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                    // } else {
                    //     $namafile = "user_account.txt";
                    //     $handle = fopen($namafile, "r");
                    // } if(!$handle) {
                    //     echo "<b>File tidak dapat dibuka atau belum ada</b>";
                    // } else {
                    //     if ($handle){
                            // $valEmail = true;
                            // while(!feof($handle)) {
                            //     $data = fgets($handle, 2048);
                            //     $acc = explode("==", $data);
                            //     if(sanitize($email) == sanitize($acc[0])) {
                            //         $emailErr = "Email sudah terdaftar";
                            //         $valEmail = false;
                            //         break;
                            //     }
                            // }
                            // fclose($handle);
                        // }
                    } else {
                        require "connect_db.php";
                        $sql = "SELECT email FROM user where email ='$email'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($row["email"] == $email) {
                                    $emailErr = "Email already exist!";
                                    break;
                                }
                            }
                        } else {
                            $valEmail = true;
                           // echo "0 results";
                        }
                       
                        
                    }
                   
                }
                if(empty($_POST["pass"])){
                    $passErr = "Password is require letter, number and symbol";
                }else{
                    $pass = sanitize($_POST["pass"]);
                    if(!preg_match("/^(?=.[a-z])(?=.*[A-Z]).{8,}/",$pass)) {
                        $passErr = "Invalid password format";
                    }
                } 
                if(empty($_POST["repass"])){
                    $repassErr = "Repeat Password is require";
                }else{
                    $repass = sanitize($_POST["repass"]);
                    if ($repass != $pass){
                        $repassErr = "Required password is different from password";
                    }
                    $valPass = true;
                }
                if(empty($_POST["role"])){
                    $roleErr = "Role is required";
                }else{
                    $role = sanitize($_POST["role"]);
                    $valRole = true;
                }
        // var_dump($name);
        // echo "<br>";
        // var_dump($email);
        // echo "<br>";
        // var_dump($pass);
        // echo "<br>";
        // var_dump($repass);
        // echo "<br>";
        // var_dump($role);
        // echo "<br>";
        
        if($valName && $valEmail && $valPass && $valRole == true){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "uas_presensi_vhikawanasa";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $date = date("Y-m-d");
            // insert data into table
            $sql = "INSERT INTO user (email, name, password, role, date_created, date_modified) 
            VALUES ('$email', '$name', '$pass', '$role', '$date', '$date')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            echo "<br>";
            $conn->close();
            // me-redirect ke file : read_data.php untuk menampilkan hasilnya
            header('Location: table_user.php');
            // echo "<h2>Your Input:</h2>";
            // echo $name;
            // echo "<br>";
            // echo $email;
            // echo "<br>";
            // echo $pass = md5($_POST['pass']);
            // echo "<br>";
            // echo $role;
            // echo "<br>";
            // echo "This date ";
            // echo  date("Y-m-d");
            // echo "<br>";

            // include "insert_datauser.php";
            // header('Location: tables_user.php'); 
        }

            }
            function sanitize($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <h1 class="text-light">REGISTRATION</h1>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        Name:<?php echo "<br>";?> <input type="text" name="name" value="<?php echo $name;?>">
                <span class="error">*  <?php echo $nameErr;?></span>
                <br><br>

        E-mail:<?php echo "<br>";?> <input type="email" name="email" value="<?php echo $email;?>">
                <span class="error">*  <?php echo $emailErr;?></span>
                <br><br>

        Password:<?php echo "<br>";?> <input type="password" name="pass" value="<?php echo $pass;?>">
                <span class="error">*  <?php echo $passErr;?></span>
                <br><br>

        Repeat Password:<?php echo "<br>";?> <input type="password" name="repass" value="<?php echo $repass;?>">
                <span class="error">*  <?php echo $repassErr;?></span>
                <br><br>
        
        Role:<?php echo "<br>";?> <select name="role">
                <option value="">---select---</option>
                <option value="Admin">Admin</option>
                <option value="Dosen">Dosen</option>
                </select>
                <span class="error">* <?php echo $roleErr;?></span>
                <br><br>

            <input class="button" type="submit" name="submit" value="Submit">
            <!-- <br><a href="valid_login.php"><input class="button" name="Login" value="Login"></a></br> -->

        </form>
        
    </body>
</html>