<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hapus_semua'])) {
        // Hapus semua data
        $koneksi->query("DELETE FROM kontrol_bel");
    } elseif (isset($_POST['id'])) {
        // Hapus satu data berdasarkan ID
        $id = intval($_POST['id']);
        $stmt = $koneksi->prepare("DELETE FROM kontrol_bel WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$koneksi->close();
?>
