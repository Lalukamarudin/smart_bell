<?php
/**
 * File koneksi.php (Versi Optimal)
 *
 * File ini bertanggung jawab untuk membuat koneksi ke database MySQL.
 * Menggunakan mode pelaporan error modern (exception) untuk keamanan
 * dan kemudahan debugging.
 */

// Mengatur mode pelaporan error mysqli untuk "melempar" exception jika terjadi kesalahan.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Detail koneksi database Anda
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "smart_bel";

try {
    // Membuat objek koneksi baru
    $koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    // Mengatur set karakter koneksi ke utf8mb4 untuk mendukung berbagai karakter
    $koneksi->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Menangani error jika koneksi gagal
    // Hentikan eksekusi skrip dan tampilkan pesan yang ramah untuk pengguna.
    // Detail error dicatat di log server untuk developer.
    error_log("Database connection failed: " . $e->getMessage());
    die("Terjadi masalah dengan koneksi database. Silakan coba lagi nanti.");
}
?>
