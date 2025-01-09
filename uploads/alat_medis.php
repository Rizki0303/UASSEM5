<?php
session_start();
include 'db.php';  // Pastikan koneksi ke database sudah benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Ambil data alat medis dari database
$sql = "SELECT * FROM alat_medis";
$alat_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Paperless Office</title>
    <style>
        /* Reset CSS untuk margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Mengatur tampilan body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin-bottom: 10px;
        }

        /* Navigasi */
        nav {
            display: flex;
            justify-content: center;
            background-color: #555;
            padding: 12px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 8px 16px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #333;
        }

        /* Kontainer utama */
        .container {
            padding: 20px;
            text-align: center;
        }

        /* Menu utama */
        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .menu-item {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 220px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .menu-item:hover {
            transform: scale(1.05);
        }

        .menu-item a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 18px;
        }

        .menu-item a:hover {
            color: #007bff;
        }

        /* Tabel Alat Medis */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        /* Bagian kontak */
        .contact-section {
            margin-top: 40px;
            padding: 20px;
            background: #333;
            color: white;
            border-radius: 10px;
            text-align: center;
        }

        .contact-section h2 {
            margin-bottom: 15px;
        }

        .contact-section p {
            margin: 10px 0;
        }

        .contact-section a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-section a:hover {
            text-decoration: underline;
        }

        /* Media Query untuk Responsivitas */
        @media (max-width: 768px) {
            .menu {
                flex-direction: column;
            }

            .menu-item {
                width: 100%;
                max-width: 300px;
                margin-bottom: 20px;
            }

            nav {
                flex-direction: column;
            }

            nav a {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Dashboard - Paperless Office</h1>
        <p>Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
    </header>

    <!-- Navigasi -->
    <nav>
        <a href="dashboard.php">Home</a>
        <a href="alat_medis.php">Data Alat Medis</a>
        <a href="kalibrasi.php">Data Alat Kalibrasi</a>
        <a href="riwayat_pemeliharaan.php">Data Riwayat Pemeliharaan</a>
        <a href="reports.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </nav>

    <!-- Kontainer Utama -->
    <div class="container">
        <h2>Data Alat Medis</h2>

        <!-- Tabel Alat Medis -->
        <table>
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Jenis Alat</th>
                    <th>Status</th>
                    <th>Tanggal Diperoleh</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $alat_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nama_alat']; ?></td>
                        <td><?php echo $row['jenis_alat']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['tanggal_diperoleh']; ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bagian Kontak -->
    <div class="contact-section">
        <h2>Kontak Kami</h2>
        <p>Hubungi kami untuk bantuan atau informasi lebih lanjut:</p>
        <p>Email: <a href="mailto:support@paperless.com">support@paperless.com</a></p>
        <p>Telepon: <a href="tel:+62123456789">+62 123 456 789</a></p>
        <p>Alamat: Jl. Teknologi No. 123, Jakarta</p>
    </div>

</body>
</html>
