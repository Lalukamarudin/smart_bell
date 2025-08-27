<?php
session_start();
require_once 'koneksi.php';

// Keamanan: Pastikan hanya user yang sudah login yang bisa mengakses halaman ini.
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
$message = '';
$message_type = '';

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


// --- PROSES FORM JIKA ADA REQUEST POST ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek form mana yang di-submit
    if (isset($_POST['update_profile'])) {
        // --- PROSES UPDATE PROFIL ---
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);

        // Validasi
        if (empty($fullname) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Nama lengkap dan email valid harus diisi.";
            $message_type = 'danger';
        } else {
            try {
                // Cek apakah email sudah digunakan oleh user lain
                $stmt_check = $koneksi->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $stmt_check->bind_param("si", $email, $user_id);
                $stmt_check->execute();
                if ($stmt_check->get_result()->num_rows > 0) {
                    $message = "Email sudah terdaftar pada akun lain.";
                    $message_type = 'danger';
                } else {
                    $stmt = $koneksi->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $fullname, $email, $user_id);
                    $stmt->execute();

                    log_activity($koneksi, "Memperbarui profil (nama & email).");
                    $message = "Profil berhasil diperbarui.";
                    $message_type = 'success';
                }
            } catch (Exception $e) {
                $message = "Terjadi kesalahan pada server.";
                $message_type = 'danger';
                error_log("Update profile error: " . $e->getMessage());
            }
        }
    } elseif (isset($_POST['change_password'])) {
        // --- PROSES UBAH PASSWORD ---
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $message = "Semua field password harus diisi.";
            $message_type = 'danger';
        } elseif ($new_password !== $confirm_password) {
            $message = "Password baru dan konfirmasi tidak cocok.";
            $message_type = 'danger';
        } elseif (strlen($new_password) < 8) {
            $message = "Password baru minimal harus 8 karakter.";
            $message_type = 'danger';
        } else {
            try {
                // Ambil hash password saat ini dari DB
                $stmt_pass = $koneksi->prepare("SELECT password FROM users WHERE id = ?");
                $stmt_pass->bind_param("i", $user_id);
                $stmt_pass->execute();
                $result = $stmt_pass->get_result();
                $user = $result->fetch_assoc();

                // Verifikasi password saat ini
                if (password_verify($current_password, $user['password'])) {
                    // Hash password baru dan update ke DB
                    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $stmt_update = $koneksi->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt_update->bind_param("si", $new_hashed_password, $user_id);
                    $stmt_update->execute();

                    log_activity($koneksi, "Mengubah password.");
                    $message = "Password berhasil diubah.";
                    $message_type = 'success';
                } else {
                    $message = "Password saat ini salah.";
                    $message_type = 'danger';
                }
            } catch (Exception $e) {
                $message = "Terjadi kesalahan pada server.";
                $message_type = 'danger';
                error_log("Change password error: " . $e->getMessage());
            }
        }
    }
}

// Ambil data terbaru pengguna untuk ditampilkan di form
$stmt_user = $koneksi->prepare("SELECT fullname, email, role FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$current_user = $stmt_user->get_result()->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Smart Bell System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: #1B5E20; --secondary: #4CAF50; --gray-bg: #f8f9fa; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--gray-bg); }
        .navbar { background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .profile-card { background-color: white; border-radius: .75rem; border: 1px solid #e0e0e0; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--secondary); border-color: var(--secondary); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <img src="asset/LOGO-SMKNW-PANCOR-246x300.png" alt="Logo" width="40" class="me-2">
                <span class="fw-bold text-primary">Smart Bell System</span>
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($username); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="home.php">Lihat Situs</a></li>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li><a class="dropdown-item" href="admin_dashboard.php">Dashboard Admin</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-5">
        <h1 class="h3 mb-4">Profil Saya</h1>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <!-- Form Informasi Akun -->
                <div class="profile-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-user-edit me-2 text-primary"></i>Informasi Akun</h5>
                        <form action="profile.php" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($current_user['fullname']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($current_user['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" readonly disabled>
                                <small class="text-muted">Username tidak dapat diubah.</small>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Peran</label>
                                <input type="text" class="form-control" id="role" value="<?php echo ucfirst(htmlspecialchars($current_user['role'])); ?>" readonly disabled>
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <!-- Form Ubah Password -->
                <div class="profile-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-key me-2 text-primary"></i>Ubah Password</h5>
                        <form action="profile.php" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                             <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                                <div class="invalid-feedback">Password baru minimal 8 karakter.</div>
                            </div>
                             <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-primary w-100">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script validasi form Bootstrap 5
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
