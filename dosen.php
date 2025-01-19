<?php
include 'koneksi.php';

// Tambah atau Edit Data Dosen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];

    // Jika terdapat id_edit, berarti proses edit
    if (isset($_POST['id_edit']) && !empty($_POST['id_edit'])) {
        $id_edit = $_POST['id_edit'];
        $sql = "UPDATE dosen SET nidn = '$nidn', nama_dosen = '$nama_dosen' WHERE nidn = '$id_edit'";
    } else {
        $sql = "INSERT INTO dosen (nidn, nama_dosen) VALUES ('$nidn', '$nama_dosen')";
    }
    $conn->query($sql);
    header('Location: dosen.php');
}

// Hapus Data Dosen
if (isset($_GET['hapus'])) {
    $nidn = $_GET['hapus'];
    $sql = "DELETE FROM dosen WHERE nidn = '$nidn'";
    $conn->query($sql);
    header('Location: dosen.php');
}

// Ambil Data Dosen
$result = $conn->query("SELECT * FROM dosen");

// Jika ingin edit, ambil data yang akan diedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $nidn_edit = $_GET['edit'];
    $edit_query = $conn->query("SELECT * FROM dosen WHERE nidn = '$nidn_edit'");
    $edit_data = $edit_query->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 60%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form {
            display: inline-block;
            margin-top: 20px;
            text-align: left;
        }
        form label {
            display: block;
            margin-top: 10px;
        }
        form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 8px 15px;
        }
    </style>
</head>
<body>
    <h2>Data Dosen</h2>
    <table>
        <tr>
            <th>NIDN</th>
            <th>Nama Dosen</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nidn']); ?></td>
            <td><?= htmlspecialchars($row['nama_dosen']); ?></td>
            <td>
                <a href="dosen.php?edit=<?= $row['nidn']; ?>">Edit</a> |
                <a href="dosen.php?hapus=<?= $row['nidn']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3><?= $edit_data ? "Edit Data Dosen" : "Tambah Data Dosen"; ?></h3>
    <form method="POST">
        <input type="hidden" name="id_edit" value="<?= $edit_data['nidn'] ?? ''; ?>">
        <label for="nidn">NIDN:</label>
        <input type="text" name="nidn" id="nidn" value="<?= $edit_data['nidn'] ?? ''; ?>" required>
        <label for="nama_dosen">Nama Dosen:</label>
        <input type="text" name="nama_dosen" id="nama_dosen" value="<?= $edit_data['nama_dosen'] ?? ''; ?>" required>
        <button type="submit" name="submit"><?= $edit_data ? "Update" : "Tambah"; ?></button>
    </form>
</body>
</html>

