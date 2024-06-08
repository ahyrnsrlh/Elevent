<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "elevent";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Error persiapan statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    // Bind hasil query ke variabel
    $stmt->bind_result($db_username, $stored_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
    
        if (password_verify($pass, $stored_password)) {
            $_SESSION['username'] = $db_username;
            header("Location: Home.html");
            exit();
        } 
    } else {
        echo "Username tidak ditemukan.";
    }
    $stmt->close();
}

$conn->close();
?>
