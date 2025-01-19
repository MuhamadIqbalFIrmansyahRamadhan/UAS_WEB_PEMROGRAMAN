<?php
include 'koneksi.php';

// Tambah atau Edit Data Perkuliahan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    if (isset($_POST['update'])) {
        // Proses Edit
        $sql = "UPDATE perkuliahan SET nidn = '$nidn', nilai = '$nilai' 
                WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
    } else {
        // Proses Tambah
        $sql = "INSERT INTO perkuliahan (nim, kode_matakuliah, nidn, nilai) 
                VALUES ('$nim', '$kode_matakuliah', '$nidn', '$nilai')";
    }
    $conn->query($sql);
    header("Location: perkuliahan.php");
}

// Hapus Data Perkuliahan
if (isset($_GET['hapus'])) {
    $nim = $_GET['nim'];
    $kode_matakuliah = $_GET['kode_matakuliah'];
    $sql = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
    $conn->query($sql);
    header("Location: perkuliahan.php");
}

// Ambil Data Perkuliahan
$result = $conn->query("SELECT m.nama_mhs, mk.nama_matakuliah, d.nama_dosen, p.nilai, p.nim, p.kode_matakuliah, p.nidn 
                        FROM perkuliahan p
                        JOIN mahasiswa m ON p.nim = m.nim
                        JOIN matakuliah mk ON p.kode_matakuliah = mk.kode_matakuliah
                        JOIN dosen d ON p.nidn = d.nidn");

// Untuk Data yang Akan Diedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $nim_edit = $_GET['nim'];
    $kode_edit = $_GET['kode_matakuliah'];
    $edit_query = $conn->query("SELECT * FROM perkuliahan WHERE nim = '$nim_edit' AND kode_matakuliah = '$kode_edit'");
    $edit_data = $edit_query->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Perkuliahan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h2, h3 {
            margin: 20px 0;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            margin-top: 20px;
            text-align: left;
            display: inline-block;
        }
        form label {
            display: block;
            margin: 10px 0 5px;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Data Perkuliahan</h2>
    <table>
        <tr>
            <th>Mahasiswa</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Nilai</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_mhs']); ?></td>
            <td><?= htmlspecialchars($row['nama_matakuliah']); ?></td>
            <td><?= htmlspecialchars($row['nama_dosen']); ?></td>
            <td><?= htmlspecialchars($row['nilai']); ?></td>
            <td>
                <a href="perkuliahan.php?edit=1&nim=<?= $row['nim']; ?>&kode_matakuliah=<?= $row['kode_matakuliah']; ?>">Edit</a> | 
                <a href="perkuliahan.php?hapus=1&nim=<?= $row['nim']; ?>&kode_matakuliah=<?= $row['kode_matakuliah']; ?>" 
                   onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3><?= isset($edit_data) ? 'Edit Data Perkuliahan' : 'Tambah Data Perkuliahan'; ?></h3>
    <form method="POST">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" value="<?= $edit_data['nim'] ?? ''; ?>" <?= isset($edit_data) ? 'readonly' : ''; ?> required>
        
        <label for="kode_matakuliah">Kode Mata Kuliah:</label>
        <input type="text" name="kode_matakuliah" id="kode_matakuliah" 
               value="<?= $edit_data['kode_matakuliah'] ?? ''; ?>" <?= isset($edit_data) ? 'readonly' : ''; ?> required>
        
        <label for="nidn">NIDN:</label>
        <input type="text" name="nidn" id="nidn" value="<?= $edit_data['nidn'] ?? ''; ?>" required>
        
        <label for="nilai">Nilai:</label>
        <input type="text" name="nilai" id="nilai" value="<?= $edit_data['nilai'] ?? ''; ?>" required>
        
        <button type="submit" name="<?= isset($edit_data) ? 'update' : 'tambah'; ?>">
            <?= isset($edit_data) ? 'Update' : 'Tambah'; ?>
        </button>
    </form>
</body>
</html>
