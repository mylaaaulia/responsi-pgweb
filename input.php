<?php
// Cek apakah form dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'] ?? '';
    $longitude = $_POST['longitude'] ?? 0;
    $latitude = $_POST['latitude'] ?? 0;

    // Validasi input
    if (empty($nama) || empty($longitude) || empty($latitude)) {
        die("Semua kolom harus diisi!");
    }

    // Konfigurasi database
    $servername = "127.0.0.1:8111";
    $username = "root";
    $password = "";
    $dbname = "dki_jkt"; // Sesuaikan nama database Anda

    // Koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query SQL untuk menambahkan data
    $sql = "INSERT INTO fasilitas_kesehatan (nama, longitude, latitude)
            VALUES ('$nama', '$longitude', '$latitude')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align: center; margin-top: 20px;'>
                <h3>Data berhasil ditambahkan!</h3>
                <a href='index.html' class='btn btn-primary'>Kembali ke Peta</a>
            </div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
