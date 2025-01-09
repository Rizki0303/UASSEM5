<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Ambil file path dari database
        $stmt = $conn->prepare("SELECT file_path FROM paperless WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Hapus file dari folder uploads
            if (file_exists($file['file_path'])) {
                unlink($file['file_path']);
            }

            // Hapus data dari database
            $stmt = $conn->prepare("DELETE FROM paperless WHERE id = :id");
            $stmt->execute(['id' => $id]);
            echo "<script>alert('Dokumen berhasil dihapus.'); window.location = 'paperless.php';</script>";
        } else {
            echo "<script>alert('Dokumen tidak ditemukan.'); window.location = 'paperless.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}
?>
