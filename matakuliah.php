<?php
include 'koneksi.php';

// Tambah atau Edit Data Mata Kuliah
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];

    if (isset($_POST['update'])) {
        // Proses Edit
        $sql = "UPDATE matakuliah SET nama_matakuliah = '$nama_matakuliah', sks = '$sks' 
                WHERE kode_matakuliah = '$kode_matakuliah'";
    } else {
        // Proses Tambah
        $sql = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, sks) 
                VALUES ('$kode_matakuliah', '$nama_matakuliah', '$sks')";
    }
    $conn->query($sql);
}

// Hapus Data Mata Kuliah
if (isset($_GET['hapus'])) {
    $kode = $_GET['hapus'];
    $sql = "DELETE FROM matakuliah WHERE kode_matakuliah = '$kode'";
    $conn->query($sql);
}

// Ambil Data Mata Kuliah
$result = $conn->query("SELECT * FROM matakuliah");

// Untuk Data yang Akan Diedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $kode_edit = $_GET['edit'];
    $edit_query = $conn->query("SELECT * FROM matakuliah WHERE kode_matakuliah = '$kode_edit'");
    $edit_data = $edit_query->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
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
        h2, h3 {
            color: #333;
        }
        form {
            display: inline-block;
            margin-top: 20px;
            text-align: left;
            width: 50%;
        }
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Data Mata Kuliah</h2>
    <table>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['kode_matakuliah']); ?></td>
            <td><?= htmlspecialchars($row['nama_matakuliah']); ?></td>
            <td><?= htmlspecialchars($row['sks']); ?></td>
            <td>
                <a href="matakuliah.php?edit=<?= $row['kode_matakuliah']; ?>">Edit</a> | 
                <a href="matakuliah.php?hapus=<?= $row['kode_matakuliah']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3><?= isset($edit_data) ? 'Edit Data Mata Kuliah' : 'Tambah Data Mata Kuliah'; ?></h3>
    <form method="POST">
        <label for="kode_matakuliah">Kode:</label>
        <input type="text" name="kode_matakuliah" id="kode_matakuliah" 
               value="<?= $edit_data['kode_matakuliah'] ?? ''; ?>" <?= isset($edit_data) ? 'readonly' : ''; ?> required>
        <label for="nama_matakuliah">Nama:</label>
        <input type="text" name="nama_matakuliah" id="nama_matakuliah" 
               value="<?= $edit_data['nama_matakuliah'] ?? ''; ?>" required>
        <label for="sks">SKS:</label>
        <input type="number" name="sks" id="sks" 
               value="<?= $edit_data['sks'] ?? ''; ?>" required>
        <button type="submit" name="<?= isset($edit_data) ? 'update' : 'tambah'; ?>">
            <?= isset($edit_data) ? 'Update' : 'Tambah'; ?>
        </button>
    </form>
</body>
</html>
