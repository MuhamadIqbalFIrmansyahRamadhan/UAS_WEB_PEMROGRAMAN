<?php
include 'koneksi.php';

$nim = $_GET['nim'];
$kode_matakuliah = $_GET['kode_matakuliah'];

// Ambil data yang akan diedit
$result = $conn->query("SELECT * FROM perkuliahan WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    $sql = "UPDATE perkuliahan 
            SET kode_matakuliah = '$kode_matakuliah', nidn = '$nidn', nilai = '$nilai'
            WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
    $conn->query($sql);
    header("Location: perkuliahan.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data Perkuliahan</title>
</head>
<body>
    <h3>Edit Data Perkuliahan</h3>
    <form method="POST">
        <label>Kode Mata Kuliah:</label><br>
        <input type="text" name="kode_matakuliah" value="<?= htmlspecialchars($data['kode_matakuliah']); ?>" required><br>
        <label>NIDN:</label><br>
        <input type="text" name="nidn" value="<?= htmlspecialchars($data['nidn']); ?>" required><br>
        <label>Nilai:</label><br>
        <input type="text" name="nilai" value="<?= htmlspecialchars($data['nilai']); ?>" required><br>
        <button type="submit" name="edit">Simpan Perubahan</button>
    </form>
</body>
</html>
