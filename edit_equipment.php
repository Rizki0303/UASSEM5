<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data peralatan berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM equipment WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data peralatan tidak ditemukan
    if (!$equipment) {
        echo "Data peralatan tidak ditemukan.";
        exit();
    }

    // Proses pembaruan data jika formulir disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $room = $_POST['room'];
        $serial_number = $_POST['serial_number'];
        $purchase_date = $_POST['purchase_date'];
        $status = $_POST['status'];

        try {
            // Perbarui data peralatan
            $stmt = $conn->prepare("UPDATE equipment SET name = :name, room = :room, serial_number = :serial_number, purchase_date = :purchase_date, status = :status WHERE id = :id");
            $stmt->execute([
                'name' => $name,
                'room' => $room,
                'serial_number' => $serial_number,
                'purchase_date' => $purchase_date,
                'status' => $status,
                'id' => $id
            ]);

            // Arahkan ke halaman utama setelah memperbarui
            header("Location: add_equipment.php");
            exit();
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
} else {
    echo "ID peralatan tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peralatan</title>
    <style>
        /* Anda bisa menambahkan style yang sesuai dengan tampilan form */
        
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
    <h1>Edit Peralatan</h1>
    <form method="post">
        <label>Nama Peralatan:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($equipment['name']); ?>" required>

        <label>Ruangan:</label>
        <input type="text" name="room" value="<?php echo htmlspecialchars($equipment['room']); ?>" required>

        <label>Nomor Seri:</label>
        <input type="text" name="serial_number" value="<?php echo htmlspecialchars($equipment['serial_number']); ?>" required>

        <label>Tanggal Pengecekan:</label>
        <input type="date" name="purchase_date" value="<?php echo htmlspecialchars($equipment['purchase_date']); ?>" required>

        <label>Status:</label>
        <select name="status" required>
            <option value="Available" <?php if ($equipment['status'] == 'Available') echo 'selected'; ?>>Tersedia</option>
            <option value="In Use" <?php if ($equipment['status'] == 'In Use') echo 'selected'; ?>>Digunakan</option>
            <option value="Under Maintenance" <?php if ($equipment['status'] == 'Under Maintenance') echo 'selected'; ?>>Dalam Perbaikan</option>
            <option value="Decommissioned" <?php if ($equipment['status'] == 'Decommissioned') echo 'selected'; ?>>Dihapus</option>
        </select>

        <button type="submit">Perbarui</button>
    </form>
</body>
</html>
