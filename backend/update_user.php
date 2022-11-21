<?php

// require "database.php";
//                 $sql= "SELECT * FROM user WHERE email='$_GET[email]'";
//                 $result = $conn->query($sql);
                
            $nameErr = $emailErr = $passErr =  $roleErr = "";
            $name = $email = $pass =$role = "";
            
            $attrAdmin=$attrDosen="";
            require "connect_db.php";
            // $email= $_GET['email'];
            $sql= "SELECT * FROM user WHERE email='$_GET[email]'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row=$result->fetch_assoc()){
               
            switch ($row['role']){
                case "Admin":
                    $attrAdmin = "selected";
                    break;
                case "Dosen":
                    $attrDosen= "selected";
                    break;
                default:
                $attrAdmin=$attrDosen="";
             }
        //  }
        // }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
      .error { color: #FF0000;

      }
      </style>
      <title>Form Update</title>
    </head>
        <body>
        <div class="container-fluid">
      <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
            
                <!-- alert untuk success -->
                <!-- <?php if(isset($success)) : ?>
                <?php endif; ?>
                alert untuk error
                <?php if(isset($error)) : ?>
                <?php endif; ?> -->
                
                <h3 class="text-light">Form Update User</h3>
               
               
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
                <div class="mb-3">
                <label class="form-label">Name</label>
                <span class="error">* <?php echo $nameErr;?></span>
                <?php echo "<br>";?> <input type="text" name="name" class="form-control" value="<?= $row['name'];?>">
                </div>
                <div class="mb-3">
                <label class="form-label">Email</label>
                <span class="error">* <?php echo $emailErr;?></span>
                <?php echo "<br>";?> <input type="text" name="email" class="form-control" value="<?= $row['email'];?>">
                </div>
                <div class="mb-3">
                <label class="form-label">Password</label>
                <span class="error">*<?php echo $passErr;?></span>
                <?php echo "<br>";?> <input type="password" name="pass"class="form-control"  value="<?= $row['password'];?>">
                </div>
                <div class="mb-3">
                <label class="form-label">Role</label>
                <span class="error">* <?php echo $roleErr;?></span>
                <?php echo "<br>";?> <select name="role" class="form-control" id="role" maxlength="100">
                        <option value="">---SELECT---</option>
                        <option value="Admin" <?php echo $attrAdmin;?> >Admin</option>
                        <option value="Dosen" <?php echo $attrDosen;?>>Dosen</option>
                      </select>
                </div>
 
           <?php
                }
            }else{
                echo "0 results";
            }
            ?>
            <input type="submit" name="submit" value="UPDATE" > 
                </form>

        </body>
        </html>
<?php
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$valName = $valEmail = $valPass= $valRole = false;
if(isset($_POST['submit'])){
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      //echo "tesname".$_POST['name'];                echo "tesmail".$_POST['email'];

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
        }else{
      //read data email from table user
      require "connect_db.php";
              $sql = "SELECT email FROM user";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      if ($row["email"] == $email) {
                          $emailErr = "Email already exist!";
                          break;
                      }else {
                          $valEmail = true;
                      }
                  }
              } else {
                  echo "0 results";
              }
             
           }
         
}

    if(empty($_POST["pass"])){
        $passErr = "Password is require";
    }else{
        $pass = sanitize($_POST["pass"]);
        // if(!preg_match("/^(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}/",$pass)) {
        //     $passErr = "Invalid password format";
        // }
        $valPass = true;
    } 

    
    if(empty($_POST["role"])){
        $roleErr = "Role is required";
    }else{
        $role = sanitize($_POST["role"]);
        $valRole = true;
    }
    if ($valName&& $valPass && $valRole == true ){
          
      $pass = sha1($pass);
      //$pass = md5($_POST['password']);
      $modified = date("Y-m-d");
      $sql2= "UPDATE user SET name='$name',password='$pass',role='$role', date_modified='$modified' WHERE email='$_POST[email]'";
      if ($conn->query($sql2)=== TRUE){
          header("location: table_user.php");
      } else {
          //pesan error gagal update data
          echo "Data Gagal Diupate!".$conn->error;
      
      }
$conn->close();
}
}
}

      

 ?>