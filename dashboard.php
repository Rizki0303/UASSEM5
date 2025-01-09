<?php
session_start();
include 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5); /* Gradient background */
            color: #333;
        }

        .navbar {
            background-color: #007BFF;
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            box-shadow: 0 4px 10px rgba(250, 250, 250, 0.1);
        }

        .navbar h1 {
            margin: 0;
            font-size: 2rem;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 2rem;
            gap: 2rem;
            margin-top: 20px;
        }

        .menu-item {
            text-align: center;
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            width: 220px;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .menu-item:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
        }

        .menu-item a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            font-size: 1.3rem;
            display: block;
            margin-bottom: 1rem;
        }

        .menu-item p {
            margin-top: 0.5rem;
            font-size: 1rem;
            color: #555;
        }

        .menu-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 5px;
            background-color: #007BFF;
            border-radius: 10px;
        }

        .menu-item a:hover {
            text-decoration: underline;
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

        @media (max-width: 768px) {
            .menu {
                flex-direction: column;
                align-items: center;
                
            }

            .menu-item {
                width: 100%;
                max-width: 300px;
                
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Dashboard Manajemen Peralatan</h1>
    </nav>

    <div class="menu">
        <div class="menu-item">
            <a href="add_equipment.php">Peralatan</a>
            <p>Kelola Daftar Peralatan</p>
        </div>
        <div class="menu-item">
            <a href="add_maintenance.php">Pemeliharaan</a>
            <p>Riwayat Pemeliharaan Peralatan</p>
        </div>

        <div class="menu-item">
            <a href="paperless.php">Laporan</a>
            <p>Tambahkan laporan</p>
        </div>
        <div class="menu-item">
            <a href="contact_us.php">Kontak Kami</a>
            <p>Hubungi tim kami</p>
        </div>
        <div class="menu-item">
            <a href="logout.php">Logout</a>
            <p>Keluar dari sistem</p>
        </div>    
    </div>

    <!-- Alamat Kami Section -->
    <div class="address-container">
        <h2>Alamat Kami</h2>
        <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
        <p>Telepon: +62 21 23456789</p>
        <p>Email: support@peralatansystem.com</p>
    </div>
</body>
</html>
