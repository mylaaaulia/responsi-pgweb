<?php
// Koneksi database
$servername = "127.0.0.1:8111";
$username = "root";
$password = "";
$dbname = "dki_jkt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani form submit untuk menambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $sql = "INSERT INTO fasilitas_kesehatan (nama, longitude, latitude) VALUES ('$nama', '$longitude', '$latitude')";
    if ($conn->query($sql) === TRUE) {
        $pesan = "Data berhasil ditambahkan!";
    } else {
        $pesan = "Error: " . $conn->error;
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } elseif ($_GET['status'] == 'error') {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat menghapus data.</div>";
    }
}

// Query untuk menampilkan data
$sql = "SELECT id, nama, longitude, latitude FROM fasilitas_kesehatan";
$result = $conn->query($sql);

// Periksa apakah query berhasil dan hasilnya ada
if ($result === false) {
    die("Error: " . $conn->error); // Menampilkan pesan error jika query gagal
}

if (isset($_GET['nama'])) {
    $nama = $conn->real_escape_string($_GET['nama']);
    $sql = "DELETE FROM fasilitas_kesehatan WHERE nama = '$nama'";

    if ($conn->query($sql) === TRUE) {
        header("Location: formfaskes.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah dan Edit Data Fasilitas Kesehatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Background Website */
        body {
            background-image: url('./images/hosp1.jpg');
            /* Path relatif ke gambar */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-gray);
            font-family: 'Arial', sans-serif;
        }

        /* Overlay untuk latar belakang */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            /* Overlay warna putih dengan transparansi */
            z-index: -3;
            /* Pastikan overlay berada di bawah konten */
        }

        .header {
            background: linear-gradient(to right, #A8C3A7, #6B8F71);
            color: #fff;
            padding: 15px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
            margin: auto;
            max-width: 600px;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            padding: 15px 0;
            background-color: #6B8F71;
            color: #fff;
        }

        .table-container {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Tambah dan Edit Data Fasilitas Kesehatan</h1>
    </div>

    <!-- Formulir Input -->
    <div class="container">
        <div class="form-container">
            <h5 class="mb-4 text-center">Silakan Isi Formulir di Bawah Ini</h5>
            <?php if (isset($pesan)) {
                echo "<div class='alert alert-info'>$pesan</div>";
            } ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama fasilitas kesehatan" required>
                </div>
                <div class="mb-3">
                    <label for="longitude" class="form-label">Koordinat Longitude</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Koordinat longitude" required>
                </div>
                <div class="mb-3">
                    <label for="latitude" class="form-label">Koordinat Latitude</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Koordinat latitude" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Kirim</button>
                    <a href="index.html" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="table-container">
            <h5 class="text-center mb-3">Data Fasilitas Kesehatan</h5>
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Id</th>
                        <th>Nama Fasilitas</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $id = 1;
                        while ($row = $result->fetch_assoc()) {
                            // Pastikan kolom yang diminta ada
                            if (isset($row['nama'], $row['longitude'], $row['latitude'])) {
                                echo "<tr>";
                                echo "<td>" . $id++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['longitude']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['latitude']) . "</td>";
                                echo "<td>
                                <a href='formfaskes.php?nama=" . urlencode($row["nama"]) . "' class='btn btn-danger'
                                onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                      </td>";  // Tombol hapus
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Data tidak tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 WebGIS Persebaran Fasilitas Kesehatan DKI Jakarta | Universitas Gadjah Mada</p>
    </footer>

</body>

</html>
<?php
$conn->close();
?>