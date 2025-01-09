<?php
session_start();
include 'config.php';

// Periksa login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Proses Tambah Data Pemeliharaan
if (isset($_POST['add_maintenance'])) {
    $equipment_id = $_POST['equipment_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $maintenance_type = $_POST['maintenance_type'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("INSERT INTO maintenance (equipment_id, maintenance_date, maintenance_type, status) 
                                VALUES (:equipment_id, :maintenance_date, :maintenance_type, :status)");
        $stmt->execute([
            'equipment_id' => $equipment_id,
            'maintenance_date' => $maintenance_date,
            'maintenance_type' => $maintenance_type,
            'status' => $status
        ]);
        echo "<script>alert('Data pemeliharaan berhasil ditambahkan!');</script>";
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}

// Ambil data pemeliharaan untuk ditampilkan dalam tabel
try {
    $stmt = $conn->prepare("
        SELECT 
            m.id, 
            e.name AS equipment_name, 
            m.maintenance_date, 
            m.maintenance_type, 
            m.status 
        FROM maintenance m
        JOIN equipment e ON m.equipment_id = e.id
        ORDER BY m.maintenance_date DESC
    ");
    $stmt->execute();
    $maintenance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemeliharaan Peralatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            <h1 class="brand">Manajemen Pemeliharaan</h1>
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

    <h2>Pemeliharaan</h2>

    <!-- Form Tambah Pemeliharaan -->
    <form method="post">
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
        <label>Tanggal Pemeliharaan: 
            <input type="date" name="maintenance_date" required>
        </label>
        <label>Jenis Pemeliharaan: 
            <input type="text" name="maintenance_type" required>
        </label>
        <label>Status:
            <select name="status" required>
                <option value="Completed">Selesai</option>
                <option value="In Progress">Dalam Proses</option>
            </select>
        </label>
        <button type="submit" name="add_maintenance">Tambah</button>
    </form>

    <!-- Tabel Daftar Pemeliharaan -->
    <h2>Daftar Pemeliharaan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peralatan</th>
                <th>Tanggal Pemeliharaan</th>
                <th>Jenis Pemeliharaan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($maintenance_records)): ?>
                <?php foreach ($maintenance_records as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                        <td><?php echo htmlspecialchars($record['equipment_name']); ?></td>
                        <td><?php echo htmlspecialchars($record['maintenance_date']); ?></td>
                        <td><?php echo htmlspecialchars($record['maintenance_type']); ?></td>
                        <td><?php echo htmlspecialchars($record['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Belum ada data pemeliharaan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="address-container">
        <h2>Alamat Kami</h2>
        <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
        <p>Telepon: +62 21 23456789</p>
        <p>Email: support@peralatansystem.com</p>
    </div>
</body>
</html>