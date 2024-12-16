<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Data Persebaran Fasilitas Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Fasilitas Kesehatan</h2>

        <?php
        // Konfigurasi MySQL
        $servername = "127.0.0.1:8111";
        $username = "root";
        $password = "";
        $dbname = "dki_jkt";

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Cek koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Cek apakah ada data yang dikirimkan dari form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $conn->real_escape_string($_POST["id"]);
            $nama = $conn->real_escape_string($_POST["nama"]);
            $longitude = $conn->real_escape_string($_POST["longitude"]);
            $latitude = $conn->real_escape_string($_POST["latitude"]);

            // Update data ke dalam tabel
            $sql = "UPDATE fasilitas_kesehatan SET id='$id', nama='$nama', longitude='$longitude', latitude='$latitude' WHERE nama='$nama'";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
                echo "<a href='index.php' class='btn btn-primary'>Kembali ke Halaman Utama</a>";
                exit;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        // Ambil data yang akan diedit berdasarkan parameter nama fasilitas
        if (isset($_GET['nama'])) {
            $kecamatan = $conn->real_escape_string($_GET['nama']);
            $sql = "SELECT * FROM fasilitas_kesehatan WHERE nama='$nama'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-danger'>Parameter nama fasilitas kesehatan tidak ditemukan.</div>";
            exit;
        }

        // Menutup koneksi
        $conn->close();
        ?>

        <!-- Form untuk mengedit data -->
        <form method="POST" action="">
            <input type="hidden" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>">

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo htmlspecialchars($row['longitude']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo htmlspecialchars($row['latitude']); ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
