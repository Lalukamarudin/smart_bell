<?php
// check_command.php
require_once 'koneksi.php'; // Sesuaikan path jika perlu

header('Content-Type: application/json');

// 1. Cari perintah yang masih 'pending'
$result = $koneksi->query("SELECT * FROM manual_control WHERE status = 'pending' ORDER BY created_at ASC LIMIT 1");

if ($result && $result->num_rows > 0) {
    $command = $result->fetch_assoc();
    $command_id = $command['id'];
    $bell_name = $command['bell_name'];

    // 2. Tandai perintah sebagai 'executed' agar tidak dijalankan lagi
    $stmt = $koneksi->prepare("UPDATE manual_control SET status = 'executed' WHERE id = ?");
    $stmt->bind_param("i", $command_id);
    $stmt->execute();
    
    // 3. Kirim respon ke ESP8266
    echo json_encode([
        'status' => 'ring_now',
        'bell_name' => $bell_name
    ]);

} else {
    // Jika tidak ada perintah
    echo json_encode(['status' => 'no_command']);
}

$koneksi->close();
?>