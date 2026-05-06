<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $npm  = mysqli_real_escape_string($conn, $_POST['npm']);
    mysqli_query($conn, "INSERT INTO mahasiswa (nama, npm) VALUES ('$nama', '$npm')");
    header("Location: index.php");
    exit;
}

if (isset($_POST['update'])) {
    $id   = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $npm  = mysqli_real_escape_string($conn, $_POST['npm']);
    mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', npm='$npm' WHERE id=$id");
    header("Location: index.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
    header("Location: index.php");
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $id   = (int) $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id");
    $edit = mysqli_fetch_assoc($result);
}

$data = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>
<head><title>CRUD Mahasiswa</title></head>
<body>
<h2>Data Mahasiswa</h2>

<?php if (!$edit): ?>
<form method="POST">
    Nama: <input type="text" name="nama" required>
    NPM: <input type="text" name="npm" required>
    <button type="submit" name="tambah">Tambah</button>
</form>

<?php else: ?>
<h3>Edit Data</h3>
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    Nama: <input type="text" name="nama" value="<?= htmlspecialchars($edit['nama']) ?>" required>
    NPM: <input type="text" name="npm" value="<?= htmlspecialchars($edit['npm']) ?>" required>
    <button type="submit" name="update">Update</button>
    <a href="index.php">Batal</a>
</form>
<?php endif; ?>

<br>

<table border="1" cellpadding="5">
    <tr><th>No</th><th>Nama</th><th>NPM</th><th>Aksi</th></tr>
    <?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['npm']) ?></td>
        <td>
            <a href="?edit=<?= $row['id'] ?>">Edit</a> |
            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>