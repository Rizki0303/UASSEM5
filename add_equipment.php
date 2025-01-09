<?php
session_start();
include 'config.php';

// Tangani pengiriman formulir
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $room = $_POST['room'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];
    $status = $_POST['status'];

    try {
        // Periksa apakah serial_number sudah ada
        $stmt = $conn->prepare("SELECT COUNT(*) FROM equipment WHERE serial_number = :serial_number");
        //$stmt = $conn->prepare("SELECT COUNT(*) FROM equipment WHERE serial_no = :serial_number");

        $stmt->execute(['serial_number' => $serial_number]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('Nomor seri sudah ada! Harap masukkan nomor seri yang berbeda.');</script>";
        } else {
            // Masukkan data ke tabel equipment
            $sql = "INSERT INTO equipment (name, room, serial_number, purchase_date, status) 
                    VALUES (:name, :room, :serial_number, :purchase_date, :status)";
            
    
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'room' => $room,
                'serial_number' => $serial_number,
                'purchase_date' => $purchase_date,
                'status' => $status,
            ]);
            echo "<script>alert('Data peralatan berhasil ditambahkan!');</script>";
        }
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}

// Ambil data dari tabel equipment
try {
    $stmt = $conn->prepare("SELECT * FROM equipment ORDER BY id DESC");
    $stmt->execute();
    $equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peralatan</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        h1, h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 300px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
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
        .btn-back {
            margin: 20px auto;
            width: 300px;
            display: block;
            text-align: center;
            background-color: #6c757d;
            text-decoration: none;
            color: white;
            padding: 8px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .address-container {
            background-color: #fff;
            color: #333;
            text-align: center;
            padding: 0.1rem;
            margin-top: 50px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background-color: #007BFF;
        }

        .address-container h2 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color:rgb(255, 255, 255);
            
        }

        .address-container p {
            font-size: 1rem;
            color:rgb(255, 255, 255);
            
        }
    </style>
</head>
<body>
        <!-- Navigasi -->
        <nav class="navbar">
        <div class="container">
            <h1 class="brand">Manajemen Peralatan</h1>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_equipment.php">Peralatan</a></li>
                <li><a href="add_maintenance.php">Pemeliharaan</a></li>
                <li><a href="paperless.php">Laporan </a></li>
                <li><a href="contact_us.php">Kontak </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Form Tambah Peralatan -->
    <h1>Peralatan</h1>
    <form method="post">
        <label>Nama Peralatan:</label>
        <input type="text" name="name" required>
        
        <label>Ruangan:</label>
        <input type="text" name="room" required>
        
        <label>Nomor Seri:</label>
        <input type="text" name="serial_number" required>
        
        <label>Tanggal Pengecekan:</label>
        <input type="date" name="purchase_date" required>
        
        <label>Status:</label>
        <select name="status" required>
            <option value="Available">Tersedia</option>
            <option value="In Use">Digunakan</option>
            <option value="Under Maintenance">Dalam Perbaikan</option>
            <option value="Decommissioned">Dihapus</option>
        </select>
        
        <button type="submit">Tambah</button>
    </form>

    <!-- Tabel Daftar Peralatan -->
    <h2>Daftar Peralatan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Peralatan</th>
                <th>Ruangan</th>
                <th>Nomor Seri</th>
                <th>Tanggal Pengecekan</th>
                <th>Status</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($equipments)): ?>
                <?php foreach ($equipments as $equipment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['room']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['serial_number']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['purchase_date']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['status']); ?></td>
                        <td>
                        <!-- Tombol Edit -->
                        <a href="edit_equipment.php?id=<?php echo $equipment['id']; ?>">Edit</a> |
                        <!-- Tombol Hapus -->
                        <a href="delete_equipment.php?id=<?php echo $equipment['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus peralatan ini?')">Hapus</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Belum ada data peralatan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Alamat Kami Section -->
    <div class="address-container">
        <h2>Alamat Kami</h2>
        <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
        <p>Telepon: +62 21 23456789</p>
        <p>Email: support@peralatansystem.com</p>
    </div>
</body>
</html>
