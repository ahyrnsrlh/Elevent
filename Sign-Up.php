<?php
// Aktifkan pelaporan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "elevent"; 

$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Dapatkan data form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi input
if ($username && $date && $email && $password) {
    // Konversi tanggal ke format YYYY-MM-DD
    $date = date("Y-m-d", strtotime($date));
  
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Debug: Tampilkan hash password
    echo "Hashed Password: " . htmlspecialchars($hashed_password) . "<br>";

    // Masukkan data ke dalam database
    $sql = "INSERT INTO users (username, date, email, password) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssss", $username, $date, $email, $hashed_password);

        if ($stmt->execute()) {
            // Alihkan ke Home.html setelah pendaftaran berhasil
            header("Location: Home.html");
            exit();
        } else {
            echo "Error eksekusi query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error persiapan statement: " . $conn->error;
    }
} else {
    echo "Semua field form wajib diisi.";
}

$conn->close();
?>
