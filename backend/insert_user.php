<?php
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

// insert data into table
$sql = "INSERT INTO user (name, email, password, role, date_created, date_modified, action) 
VALUES ('$name', '$email', '$password', '$role', '$date_created', '$date_modified', 'action')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
echo "<br>";
$conn->close();
// me-redirect ke file : read_data.php untuk menampilkan hasilnya
// header('Location: read_data.php');
?>