<?php
session_start();

if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

if (isset($_GET['delete']) && $_SESSION['nama'] === 'admin') {
    $id_to_delete = $_GET['delete'];
    $stmt_del = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt_del->bind_param("i", $id_to_delete);
    $stmt_del->execute();
    $stmt_del->close();
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #aaa; padding: 4px 8px; text-align: center; }
        .btn { font-size: 12px; }
    </style>
</head>
<body>
    <p style="font-weight: bold; margin-bottom: 5px;">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>
    <a href="logout.php"><button class="btn">Logout</button></a>

    <?php if ($_SESSION['nama'] === 'admin'): ?>
        <br><br>
        <p style="font-weight: bold; margin-bottom: 5px;">Menu Admin: Kelola Pengguna</p>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = $conn->query("SELECT id, nama FROM users ORDER BY id DESC");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>"><button class="btn">Edit</button></a> | 
                    <a href="dashboard.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Hapus?');"><button class="btn">Hapus</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>