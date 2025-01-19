<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Akademik</title>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }
    h1 {
        font-size: 3em;
        margin: 30px 0 10px; /* Naikkan posisi dan beri jarak bawah */
        color: #333;
    }
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px;
    }
    .menu {
        width: 200px;
        height: 150px;
        margin: 15px;
        background-color: #007BFF;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 1.5em;
        font-weight: bold;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
    }
    .menu:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <h1>Dashboard Akademik</h1>
    <div class="container">
        <a href="dosen.php" class="menu">Dosen</a>
        <a href="mahasiswa.php" class="menu">Mahasiswa</a>
        <a href="matakuliah.php" class="menu">Mata Kuliah</a>
        <a href="perkuliahan.php" class="menu">Perkuliahan</a>
    </div>
</body>
</html>
