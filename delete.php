<?php
// Include file koneksi database
include 'formfaskes.php';  // Pastikan file ini berisi koneksi database

// Gantilah dengan detail koneksi database Anda jika perlu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dki_jkt";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah ada ID yang dikirimkan
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM fasilitas_kesehatan WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);  // Mengikat parameter ID
        if ($stmt->execute()) {  // Eksekusi query
            // Redirect kembali ke halaman utama setelah menghapus
            header("Location: formfaskes.php?status=success");
            exit();  // Pastikan keluar setelah redirect
        } else {
            // Jika gagal menghapus
            header("Location: formfaskes.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        // Query gagal
        header("Location: formfaskes.php?status=error");
        exit();
    }
} else {
    // Jika tidak ada ID yang dikirimkan
    header("Location: formfaskes.php?status=error");
    exit();
}

// Tutup koneksi
$conn->close();
?>
