<?php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['nama'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}
require 'koneksi.php';
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_baru = trim($_POST['nama']);
    $password_baru = $_POST['password'];
    if (!empty($nama_baru) && !empty($password_baru)) {
        $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
        $stmt_update = $conn->prepare("UPDATE users SET nama = ?, password = ? WHERE id = ?");
        $stmt_update->bind_param("ssi", $nama_baru, $hashed_password, $id);
        $stmt_update->execute();
        $stmt_update->close();
        header("Location: dashboard.php");
        exit();}
}
$stmt = $conn->prepare("SELECT nama FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nama_lama);
$stmt->fetch();
$stmt->close();
if (!$nama_lama) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pengguna</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .form-box { border: 1px solid #aaa; padding: 10px 15px 15px 15px; display: inline-block; }
        .btn { font-size: 12px; margin-top: 5px; }
        label { font-size: 12px; }
        input { margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="form-box">
    <p style="font-weight: bold; margin-top: 0; font-size: 14px;">Edit Data Pengguna</p>
    <form method="POST" action="">
        <label>Nama Pengguna:</label><br>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($nama_lama); ?>" required><br> <label>Password Baru:</label><br>
        <input type="password" name="password" placeholder="Masukkan password baru" required><br>
        
        <button type="submit" class="btn">Simpan Perubahan</button><br>
        <a href="dashboard.php"><button type="button" class="btn">Batal</button></a>
    </form>

</div>

</body>

</html>