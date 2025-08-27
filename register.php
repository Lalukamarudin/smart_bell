<?php
session_start();
require_once 'koneksi.php';

// Jika pengguna sudah login, arahkan ke halaman utama
if (isset($_SESSION['loggedin'])) {
    header("Location: home.php");
    exit;
}

$errors = [];
$input = []; // Simpan input user jika terjadi error

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil dan bersihkan input
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'] ?? ''; // Ambil role dari dropdown
    $email = trim($_POST['email']);
    $fullname = trim($_POST['fullname']);
    
    // Simpan input untuk ditampilkan kembali jika ada error
    $input = $_POST;

    // --- VALIDASI SERVER-SIDE ---
    if (empty($fullname)) {
        $errors[] = "Nama lengkap wajib diisi.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
    if (strlen($username) < 4) {
        $errors[] = "Username harus memiliki minimal 4 karakter.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password harus memiliki minimal 8 karakter.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok.";
    }
    // PERBAIKAN: Tambahkan 'petugas' ke role yang valid
    if (!in_array($role, ['admin', 'user', 'petugas'])) {
        $errors[] = "Role yang dipilih tidak valid.";
    }

    // Jika tidak ada error validasi, lanjutkan ke pengecekan database
    if (empty($errors)) {
        try {
            // Cek apakah username atau email sudah ada
            $stmt = $koneksi->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errors[] = "Username atau email sudah terdaftar.";
            } else {
                // Hash password sebelum disimpan
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Masukkan data pengguna baru ke database
                $insert_stmt = $koneksi->prepare("INSERT INTO users (username, password, role, email, fullname) VALUES (?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("sssss", $username, $hashed_password, $role, $email, $fullname);
                
                if ($insert_stmt->execute()) {
                    // Redirect ke halaman login dengan pesan sukses
                    header("Location: login.php?status=registered");
                    exit;
                }
                $insert_stmt->close();
            }
            $stmt->close();

        } catch (mysqli_sql_exception $e) {
            // Tangani error database dengan aman
            error_log("Registration DB Error: " . $e->getMessage());
            $errors[] = "Terjadi masalah pada server. Gagal melakukan registrasi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SmartBel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #28a745; --primary-dark: #218838; --secondary: #1e7e34; }
        body { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; font-family: 'Poppins', sans-serif; }
        .register-container { max-width: 500px; width: 100%; background: white; border-radius: 20px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); border-top: 5px solid var(--primary); }
        .register-right { padding: 2.5rem; }
        .form-control, .form-select { border-radius: 10px; padding: 12px 20px 12px 45px; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--primary); z-index: 3; }
        .btn-register { width: 100%; padding: 14px; background: var(--primary); border: none; color: white; font-weight: 600; }
        .btn-register:hover { background: var(--primary-dark); }
        .login-link a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 .25rem rgba(40,167,69,.25); }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-right">
            <div class="text-center mb-4">
                <h3>Buat Akun Baru</h3>
                <p class="text-muted">Isi formulir untuk mendaftar.</p>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form id="registrationForm" method="POST" class="needs-validation" novalidate>
                <div class="form-group mb-3">
                    <label class="form-label" for="fullname">Nama Lengkap</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($input['fullname'] ?? '') ?>" placeholder="Masukkan nama lengkap" required>
                        <div class="invalid-feedback">Nama lengkap tidak boleh kosong.</div>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($input['email'] ?? '') ?>" placeholder="Masukkan email valid" required>
                        <div class="invalid-feedback">Masukkan format email yang benar.</div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($input['username'] ?? '') ?>" placeholder="Minimal 4 karakter" required minlength="4">
                        <div class="invalid-feedback">Username minimal 4 karakter.</div>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required minlength="8">
                        <div class="invalid-feedback">Password minimal 8 karakter.</div>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ketik ulang password" required>
                        <div class="invalid-feedback">Konfirmasi password harus diisi.</div>
                    </div>
                </div>

                <!-- PERBAIKAN: Mengganti input hidden dengan dropdown -->
                <div class="form-group mb-4">
                    <label class="form-label" for="role">Daftar sebagai</label>
                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" disabled selected>-- Pilih Peran --</option>
                            <option value="user" <?= (isset($input['role']) && $input['role'] == 'user') ? 'selected' : '' ?>>User (Siswa/Guru)</option>
                            <option value="petugas" <?= (isset($input['role']) && $input['role'] == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                            <option value="admin" <?= (isset($input['role']) && $input['role'] == 'admin') ? 'selected' : '' ?>>Administrator</option>
                        </select>
                        <div class="invalid-feedback">Anda harus memilih peran.</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-register">Buat Akun</button>
                </div>
            </form>
            
            <div class="login-link text-center mt-3">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </div>
        </div>
    </div>
    
    <script>
        // Validasi client-side menggunakan Bootstrap 5
        (() => {
            'use strict'
            const form = document.getElementById('registrationForm');
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirm_password');
                
                // Cek manual jika password tidak cocok
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Password tidak cocok.');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    confirmPassword.setCustomValidity('');
                }

                form.classList.add('was-validated');
            }, false);

            // Hapus custom validity saat input berubah
            document.getElementById('confirm_password').addEventListener('input', function() {
                this.setCustomValidity('');
            });
        })();
    </script>
</body>
</html>
