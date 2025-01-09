<?php
session_start();
include 'config.php';

// Periksa login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Proses Unggah Dokumen
if (isset($_POST['upload_document'])) {
    $equipment_id = $_POST['equipment_id'];
    $document_name = $_POST['document_name'];
    $uploaded_by = $_SESSION['username']; // Nama pengguna yang login

    // Proses upload file
    $target_dir = "uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . uniqid() . "_" . $file_name; // Nama unik untuk file

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO paperless (equipment_id, document_name, file_path, uploaded_by) 
                VALUES (:equipment_id, :document_name, :file_path, :uploaded_by)
            ");
            $stmt->execute([
                'equipment_id' => $equipment_id,
                'document_name' => $document_name,
                'file_path' => $target_file,
                'uploaded_by' => $uploaded_by
            ]);
            echo "<script>alert('Dokumen berhasil diunggah!');</script>";
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
}

// Ambil data dokumen untuk ditampilkan
try {
    $stmt = $conn->prepare("
        SELECT 
            p.id, 
            e.name AS equipment_name, 
            p.document_name, 
            p.upload_date, 
            p.file_path, 
            p.uploaded_by 
        FROM paperless p
        JOIN equipment e ON p.equipment_id = e.id
        ORDER BY p.upload_date DESC
    ");
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dokumen Paperless</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007BFF;
            color: white;
            padding: 1rem;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .navbar .nav-links {
            list-style: none;
            display: flex;
            gap: 1rem;
        }
        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 400px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navigasi -->
    <nav class="navbar">
        <div class="container">
            <h1 class="brand">Manajemen Laporan</h1>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_equipment.php">Peralatan</a></li>
                <li><a href="add_maintenance.php">Pemeliharaan</a></li>
                <li><a href="paperless.php">Laporan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <h2>Dokumen Peralatan</h2>

    <!-- Form Unggah Dokumen -->
    <form method="post" enctype="multipart/form-data">
        <label>Nama Peralatan:
            <select name="equipment_id" required>
                <?php
                $stmt = $conn->query("SELECT * FROM equipment ORDER BY name");
                $equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($equipments as $equipment) {
                    echo "<option value='{$equipment['id']}'>{$equipment['name']}</option>";
                }
                ?>
            </select>
        </label>
        <label>Nama Dokumen:
            <input type="text" name="document_name" required>
        </label>
        <label>Unggah File:
            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
        </label>
        <button type="submit" name="upload_document">Unggah Dokumen</button>
    </form>

    <!-- Tabel Daftar Dokumen -->
    <h2>Daftar Dokumen</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peralatan</th>
                <th>Nama Dokumen</th>
                <th>Tanggal Unggah</th>
                <th>Diunggah Oleh</th>
                <th>file</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($documents)): ?>
                <?php foreach ($documents as $doc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doc['id']); ?></td>
                        <td><?php echo htmlspecialchars($doc['equipment_name']); ?></td>
                        <td><?php echo htmlspecialchars($doc['document_name']); ?></td>
                        <td><?php echo htmlspecialchars($doc['upload_date']); ?></td>
                        <td><?php echo htmlspecialchars($doc['uploaded_by']); ?></td>
                        <td><?php echo htmlspecialchars($doc['file_path']); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" download>Unduh</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Belum ada dokumen.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>