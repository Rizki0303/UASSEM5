<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Hapus data berdasarkan ID
        $stmt = $conn->prepare("DELETE FROM equipment WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Arahkan kembali ke halaman utama setelah menghapus
        header("Location: add_equipment.php");
        exit();
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
} else {
    echo "ID peralatan tidak ditemukan.";
}
?>
