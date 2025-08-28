<?php
session_start();
require_once 'koneksi.php';

// Pastikan hanya admin yang bisa mengakses API ini
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
  http_response_code(403); // Forbidden
  echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
  exit;
}

// Helper function untuk mengirim response JSON
function json_response($data, $statusCode = 200) {
  http_response_code($statusCode);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

// Helper function untuk mencatat aktivitas
function log_activity($koneksi, $action) {
  try {
    $stmt = $koneksi->prepare("INSERT INTO activity_log (user_id, username, action) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $_SESSION['id'], $_SESSION['username'], $action);
    $stmt->execute();
  } catch (Exception $e) {
    error_log("Gagal mencatat aktivitas: " . $e->getMessage());
  }
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
  // --- AKSI JADWAL ---
  case 'get_schedules':
    try {
      $result = $koneksi->query("SELECT * FROM kontrol_bel ORDER BY time ASC");
      $schedules = $result->fetch_all(MYSQLI_ASSOC);
      json_response(['success' => true, 'data' => $schedules]);
    } catch (Exception $e) {
      json_response(['success' => false, 'message' => 'Gagal mengambil jadwal.'], 500);
    }
    break;

  case 'add_schedule':
    $nama_jadwal = $_POST['nama_jadwal'] ?? '';
    $time = $_POST['time'] ?? '';
    $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
    
    if (empty($nama_jadwal) || empty($time)) {
      json_response(['success' => false, 'message' => 'Nama jadwal dan waktu harus diisi.'], 400);
    }

    try {
      $sql = "INSERT INTO kontrol_bel (nama_jadwal, time, senin, selasa, rabu, kamis, jumat, sabtu, minggu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $koneksi->prepare($sql);
      
      $senin = isset($_POST['senin']) ? 1 : 0;
      $selasa = isset($_POST['selasa']) ? 1 : 0;
      $rabu = isset($_POST['rabu']) ? 1 : 0;
      $kamis = isset($_POST['kamis']) ? 1 : 0;
      $jumat = isset($_POST['jumat']) ? 1 : 0;
      $sabtu = isset($_POST['sabtu']) ? 1 : 0;
      $minggu = isset($_POST['minggu']) ? 1 : 0;
      
      $stmt->bind_param("ssiiiiiii", $nama_jadwal, $time, $senin, $selasa, $rabu, $kamis, $jumat, $sabtu, $minggu);
      $stmt->execute();
      
      log_activity($koneksi, "Menambah jadwal baru: '{$nama_jadwal}'");
      json_response(['success' => true, 'message' => 'Jadwal berhasil ditambahkan.']);
    } catch (Exception $e) {
      json_response(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], 500);
    }
    break;

  case 'delete_schedule':
    $id = $_POST['id'] ?? 0;
    if ($id > 0) {
      $stmt = $koneksi->prepare("DELETE FROM kontrol_bel WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      log_activity($koneksi, "Menghapus jadwal dengan ID: {$id}");
      json_response(['success' => true, 'message' => 'Jadwal berhasil dihapus.']);
    }
    break;

  case 'delete_all_schedules':
    $koneksi->query("TRUNCATE TABLE kontrol_bel");
    log_activity($koneksi, "Menghapus SEMUA jadwal bel.");
    json_response(['success' => true, 'message' => 'Semua jadwal berhasil dihapus.']);
    break;

  case 'ring_bell_manually':
    $bell_name = isset($_GET['bell_name']) ? $_GET['bell_name'] : 'Manual';
    $esp8266_ip = '192.168.93.40'; 

    // Pastikan format URL-nya persis seperti ini:
    $request_url = "http://{$esp8266_ip}/ring?bell_name=" . urlencode($bell_name);

    // 3. Gunakan cURL untuk mengirim request ke ESP8266
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout dalam 5 detik

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    // 4. Catat aktivitas ke log database
    log_activity($koneksi, "Memicu bel manual: '{$bell_name}'");

    // 5. Beri respon ke website berdasarkan hasil request ke ESP8266
    if ($http_code == 200) {
      json_response(['success' => true, 'message' => "Perintah membunyikan '{$bell_name}' berhasil dikirim ke ESP."]);
    } else {
      // Jika ESP tidak merespon atau error
      error_log("Gagal menghubungi ESP8266. URL: {$request_url}, HTTP Code: {$http_code}, cURL Error: {$curl_error}");
      json_response([
        'success' => false, 
        'message' => "Gagal menghubungi perangkat bel. Pastikan perangkat aktif dan terhubung ke jaringan. (Error Code: {$http_code})"
      ], 503); // Service Unavailable
    }

    // --- AKHIR PERBAIKAN ---
    break;

  // --- AKSI PENGGUNA ---
  case 'get_users':
    $result = $koneksi->query("SELECT id, username, email, fullname, role FROM users ORDER BY id DESC");
    $users = $result->fetch_all(MYSQLI_ASSOC);
    json_response(['success' => true, 'data' => $users]);
    break;

  case 'add_user':
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if (empty($username) || empty($password) || empty($email) || empty($role)) {
      json_response(['success' => false, 'message' => 'Semua field wajib diisi.'], 400);
    }
    
    // Cek jika username atau email sudah ada
    $stmt_check = $koneksi->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
      json_response(['success' => false, 'message' => 'Username atau email sudah terdaftar.'], 409);
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare("INSERT INTO users (username, password, email, fullname, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $fullname, $role);
    $stmt->execute();

    log_activity($koneksi, "Menambah pengguna baru: '{$username}' dengan peran '{$role}'");
    json_response(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.']);
    break;
    
  case 'delete_user':
    $id = $_POST['id'] ?? 0;
    // Mencegah admin menghapus akunnya sendiri
    if ($id == $_SESSION['id']) {
      json_response(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri.'], 400);
    }
    if ($id > 0) {
      $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      log_activity($koneksi, "Menghapus pengguna dengan ID: {$id}");
      json_response(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
    }
    break;

  // --- AKSI LOG ---
  case 'get_logs':
    $result = $koneksi->query("SELECT username, action, created_at FROM activity_log ORDER BY created_at DESC LIMIT 10");
    $logs = $result->fetch_all(MYSQLI_ASSOC);
    json_response(['success' => true, 'data' => $logs]);
    break;
    
  default:
    json_response(['success' => false, 'message' => 'Aksi tidak valid.'], 404);
    break;
}
?>