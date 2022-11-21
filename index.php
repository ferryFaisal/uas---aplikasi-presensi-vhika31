<!doctype html>
<html lang="en">
<?php
session_start();
//pemeriksaan session
if (!isset($_SESSION['role'])) {//jika sudah login
  //session belum ada artinya belum login
  header("Location:admin/trash/login.php");
}
function cek($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit'])) {
    
    require 'admin/trash/database.php';
    $tgl = cek($_POST['tgl']);
    $makul = cek($_POST['makul']);
    $kelas = cek($_POST['kelas']);
    $nim = cek($_POST['nim']);
    $name = cek($_POST['nama']);
    $presensi= cek($_POST['presensi']);
    $sql = "SELECT tgl_presensi from presensi WHERE tgl_presensi = '$tgl' and nim = '$nim'";
    $result = $conn->query($sql);
    //cek email terdaftar
    if ($result->num_rows == 0) {
      //cek pw sama
      // echo "pw1 : ".cek($password).", pw2 : ".$cpassword."<br>";
        // echo "masuk";
        $sql = "INSERT INTO presensi (tgl_presensi, makul, kelas, nim, nama, status_presensi) 
        VALUES 
        ('$tgl','$makul','$kelas','$nim', '$name', '$presensi')";
        if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Data baru telah ditambahkan')</script>";
          // echo "New record created succesfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
      echo "<script>alert('Sudah ada absensi NIM:$nim pada tanggal $tgl')</script>";
    }
    $conn->close();
  }
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input | Presensi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <h1></h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    
    <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header text-center"><h4>Pengisian Kehadiran Mahasiswa</h4></div>
      <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <!-- <div class="form-group"> -->
            <div class="row form-row mb-1">
              <div class="col-md-4">
                <div class="form-label-group">
                  <input type="date" id="tgl" name="tgl" class="form-control" autofocus="autofocus" placeholder="Tgl" value="<?=date("Y-m-d")?>" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-label-group">
                  <select name="makul" id="makul" class="form-control" autofocus="autofocus" required>
                    <option value=""> -- Pilih Mata Kuliah  -- </option>
                    <option value="WebProg"> Pemrograman Web </option>
                    <option value="WebProgLab"> Praktik Pemrograman Web </option>
                    <option value="SoftDev"> Rekayasa Perangkat Lunak </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-label-group">
                  <form method="post" action="">
                  <select name="kelas" id="kelas" class="form-control" autofocus="autofocus" required onchange="this.form.submit()">
                    <option value=""> -- Pilih Kelas -- </option>
                    <option value="5A"> 5A </option>
                    <option value="5B"> 5B </option>
                  </select>
                  </form>
                </div>
              </div>
            </div><hr>
            <div class="row text-center">
                <div class="col-md-4"><strong>Nomor Induk Mahasiswa</strong></div>
                <div class="col-md-4"><strong>Nama Lengkap</strong></div>
                <div class="col-md-4"><strong>Status Presensi</strong></div>
            </div><hr>
            <?php
                require 'backend/connect_db.php';
                  if (isset($_POST['kelas'])) {
                    $sql = "SELECT * FROM mahasiswa where kelas = '$_POST[kelas]' ORDER BY nim ASC";
                  }else{
                    $sql = "SELECT * FROM mahasiswa ORDER BY nim ASC";
                  }
                  $result = $conn->query($sql);
                  foreach($result as $row)
                  {
                    ?>
            <div class="row form-row mb-1">
              <div class="col-md-4">
                <div class="form-label-group">
                  <input type="text" id="nim" name="nim" class="form-control" placeholder="NIM" autofocus="autofocus" value="<?=$row['nim']?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-label-group">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" autofocus="autofocus" value="<?=$row['nama']?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-label-group">
                  <select name="presensi" id="presensi" class="form-control" autofocus="autofocus" required>
                      <option selected="selected" value="Hadir"> Hadir </option>
                      <option value="Sakit"> Sakit </option>
                      <option value="Izin"> Izin </option>
                      <option value="Alpa"> Alpa </option>
                  </select>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          <!-- </div> -->
          <br>
          <p class="text-center">
          <input type="submit" name="submit" value="Simpan Presensi" class="btn btn-primary btn-block"></p>
          <!-- <a class="btn btn-secondary btn-block" href="users.php">Cancel</a> -->
        </form>
        <div class="text-center">
          <br>Copyright © Program Studi Teknik Informatika - <?= date('Y');?><br>
        </div>
      </div>
    </div>
                
</body>
</html>