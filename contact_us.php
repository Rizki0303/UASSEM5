<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color:rgb(8, 9, 10);
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        .contact-form {
            width: 50%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            <h2 class="brand">Manajemen Kontak</h2>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_equipment.php">Peralatan</a></li>
                <li><a href="add_maintenance.php">Pemeliharaan</a></li>
                <li><a href="paperless.php">Laporan</a></li>
                <li><a href="contact_us.php">Kontak</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <h1>Kontak Kami</h1>
    <div class="contact-form">
        <form method="post">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Pesan:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Kirim</button>
        </form>
    </div>
     
     <div class="address-container">
        <h2>Alamat Kami</h2>
        <p>Jl. Raya No. 123, Jakarta, Indonesia</p>
        <p>Telepon: +62 21 23456789</p>
        <p>Email: support@peralatansystem.com</p>
    </div>
</body>
</html>
