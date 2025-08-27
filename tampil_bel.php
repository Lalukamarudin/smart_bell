<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak diizinkan.']);
    exit();
}

try {
    date_default_timezone_set('Asia/Makassar'); // Sesuaikan dengan zona waktu Anda
    $dayOfWeek = strtolower(date('l')); // ex: monday
    
    // Peta hari Inggris ke kolom database
    $hari_map = [
        'monday' => 'senin',
        'tuesday' => 'selasa',
        'wednesday' => 'rabu',
        'thursday' => 'kamis',
        'friday' => 'jumat',
        'saturday' => 'sabtu',
        'sunday' => 'minggu'
    ];
    
    $todayColumn = $hari_map[$dayOfWeek] ?? ''; // Dapatkan nama kolom hari ini
    
    if (empty($todayColumn)) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Hari tidak valid.']);
        exit();
    }
    
    // Ambil semua jadwal yang diatur untuk hari ini
    $sql = "SELECT time, nama_jadwal FROM kontrol_bel WHERE {$todayColumn} = 1 ORDER BY time ASC";
    $result = $koneksi->query($sql);
    
    $jadwal = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $jadwal[] = [
                'time' => $row['time'],
                'jenis' => $row['nama_jadwal'] // Gunakan nama_jadwal sebagai jenis
            ];
        }
    }
    
    echo json_encode($jadwal);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal mengambil data alarm: ' . $e->getMessage()
    ]);
}
?>