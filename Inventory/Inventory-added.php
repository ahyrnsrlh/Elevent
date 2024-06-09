<?php

require_once('../dbdbdb.php');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $idProduk = $_POST["idProduk"];
    $namaProduk = $_POST["namaProduk"];
    $harga = $_POST["harga"];
    $total = $_POST["total"];
    $status = $_POST["status"];
    $idKategori = (int) $_POST["idKategori"]; 


    // Memproses file gambar yang diunggah
    $target_dir = "../Inventory/imagesAdd/"; // Direktori untuk menyimpan gambar
    $image = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek jika file sudah ada
    if (file_exists($image)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["image"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Izinkan format file tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0
    if ($uploadOk == 0) {
        echo "Maaf, file tidak terunggah.";
    // Jika semuanya benar, coba unggah file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
            echo "File ". htmlspecialchars(basename($_FILES["image"]["name"])). " sudah berhasil diunggah.";
            // Menyimpan informasi produk ke database
            $sql = "INSERT INTO produk (idProduk, namaProduk, total, status, harga, image, idKategori)
            VALUES ('$idProduk','$namaProduk', '$total', '$status', '$harga', '$image', '$idKategori')";
            
            // Debugging: Print query SQL
            echo $sql;

            if ($conn->query($sql) === TRUE) {
                echo "Data produk berhasil ditambahkan.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>
