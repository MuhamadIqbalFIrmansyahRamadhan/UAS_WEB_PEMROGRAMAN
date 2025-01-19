<?php
include 'koneksi.php';

// Tambah atau Edit Data Mahasiswa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nama_mhs = $_POST['nama_mhs'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    // Jika terdapat id_edit, maka proses edit
    if (isset($_POST['id_edit']) && !empty($_POST['id_edit'])) {
        $id_edit = $_POST['id_edit'];
        $sql = "UPDATE mahasiswa 
                SET nama_mhs = '$nama_mhs', tgl_lahir = '$tgl_lahir', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin' 
                WHERE nim = '$id_edit'";
    } else {
        $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, alamat, jenis_kelamin) 
                VALUES ('$nim', '$nama_mhs', '$tgl_lahir', '$alamat', '$jenis_kelamin')";
    }
    $conn->query($sql);
    header('Location: mahasiswa.php');
}

// Hapus Data Mahasiswa
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];
    $sql = "DELETE FROM mahasiswa WHERE nim = '$nim'";
    $conn->query($sql);
    header('Location: mahasiswa.php');
}

// Ambil Data Mahasiswa
$result = $conn->query("SELECT * FROM mahasiswa");

// Ambil Data untuk Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $nim_edit = $_GET['edit'];
    $edit_query = $conn->query("SELECT * FROM mahasiswa WHERE nim = '$nim_edit'");
    $edit_data = $edit_query->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Mahasiswa</title>
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
        form input, form textarea, form select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
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
    <h2>Data Mahasiswa</h2>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nim']); ?></td>
            <td><?= htmlspecialchars($row['nama_mhs']); ?></td>
            <td><?= htmlspecialchars($row['tgl_lahir']); ?></td>
            <td><?= htmlspecialchars($row['alamat']); ?></td>
            <td><?= htmlspecialchars($row['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan'); ?></td>
            <td>
                <a href="mahasiswa.php?edit=<?= $row['nim']; ?>">Edit</a> |
                <a href="mahasiswa.php?hapus=<?= $row['nim']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3><?= $edit_data ? "Edit Data Mahasiswa" : "Tambah Data Mahasiswa"; ?></h3>
    <form method="POST">
        <input type="hidden" name="id_edit" value="<?= $edit_data['nim'] ?? ''; ?>">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" value="<?= $edit_data['nim'] ?? ''; ?>" <?= $edit_data ? 'readonly' : ''; ?> required>
        <label for="nama_mhs">Nama Mahasiswa:</label>
        <input type="text" name="nama_mhs" id="nama_mhs" value="<?= $edit_data['nama_mhs'] ?? ''; ?>" required>
        <label for="tgl_lahir">Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" id="tgl_lahir" value="<?= $edit_data['tgl_lahir'] ?? ''; ?>" required>
        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required><?= $edit_data['alamat'] ?? ''; ?></textarea>
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select name="jenis_kelamin" id="jenis_kelamin" required>
            <option value="L" <?= isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
            <option value="P" <?= isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
        </select>
        <button type="submit" name="submit"><?= $edit_data ? "Update" : "Tambah"; ?></button>
    </form>
</body>
</html>
