<?php
// 1. Mulai session
session_start();
require_once 'koneksi.php';

// 2. Jika admin sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}

$error_message = '';
$username_value = ''; // Simpan username untuk diisi kembali di form

// 3. Proses form jika ada request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $username_value = $username; // Simpan input username

    if (empty($username) || empty($password)) {
        $error_message = "Username dan Password tidak boleh kosong.";
    } else {
        try {
            // 4. Query hanya mencari user berdasarkan username
            $stmt = $koneksi->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                // Verifikasi password DAN peran (role)
                if (password_verify($password, $user['password']) && $user['role'] === 'admin') {
                    // 5. Login berhasil HANYA JIKA user adalah admin
                    session_regenerate_id(true); // Keamanan

                    // Simpan data ke session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // 6. Arahkan ke dashboard admin
                    header("Location: admin_dashboard.php");
                    exit;
                } else {
                    // Pesan error jika password salah ATAU bukan admin
                    $error_message = "Akses ditolak. Pastikan username, password, dan hak akses benar.";
                }
            } else {
                // Pesan error jika username tidak ditemukan
                $error_message = "Akses ditolak. Pastikan username, password, dan hak akses benar.";
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Login DB Error: " . $e->getMessage());
            $error_message = "Terjadi masalah pada sistem. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #28a745; --primary-light: #5cb85c; --primary-dark: #218838; --secondary: #1e7e34; --accent: #4CAF50; --success: #4caf50; --dark: #212529; --light: #f8f9fa; --danger: #f44336; --warning: #ffc107; }
        body { background: linear-gradient(135deg, #66bb6a 0%, #2e7d32 100%); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; font-family: 'Poppins', sans-serif; }
        .login-container { display: flex; max-width: 1000px; width: 100%; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); }
        .login-left { flex: 1; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; }
        .login-right { flex: 1; padding: 50px 40px; }
        .form-control { border-radius: 10px; padding: 12px 20px 12px 45px; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--primary-light); z-index: 3; }
        .btn-login { width: 100%; padding: 14px; background: var(--primary); border: none; border-radius: 10px; color: white; font-weight: 600; }
        .btn-login:hover { background: var(--primary-dark); }
        @media (max-width: 768px) { .login-container { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left d-none d-md-flex">
            <h2>Selamat Datang</h2>
            <p>Sistem bel pintar untuk manajemen waktu sekolah yang lebih efisien.</p>
        </div>
        
        <div class="login-right">
            <h3>Masuk sebagai Admin</h3>
            <p>Gunakan akun admin untuk mengakses dashboard.</p>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user-shield"></i>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username admin" required value="<?= htmlspecialchars($username_value) ?>">
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>
    
    </body>
</html>