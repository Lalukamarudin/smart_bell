<?php
session_start();
require_once 'koneksi.php';

// Keamanan: Pastikan hanya admin yang sudah login yang bisa mengakses halaman ini.
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

function get_stats($koneksi) {
    $stats = ['total_jadwal' => 0, 'total_users' => 0, 'jadwal_hari_ini' => 0];
    try {
        $stats['total_jadwal'] = $koneksi->query("SELECT COUNT(id) as total FROM kontrol_bel")->fetch_assoc()['total'];
        $stats['total_users'] = $koneksi->query("SELECT COUNT(id) as total FROM users")->fetch_assoc()['total'];
        
        date_default_timezone_set('Asia/Makassar');
        $dayOfWeek = strtolower(date('l')); // ex: monday
        $dayMap = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'];
        $todayColumn = $dayMap[$dayOfWeek] ?? 'senin';
        $stats['jadwal_hari_ini'] = $koneksi->query("SELECT COUNT(id) as total FROM kontrol_bel WHERE {$todayColumn} = 1")->fetch_assoc()['total'];

    } catch (Exception $e) {
        error_log("Gagal mengambil statistik: " . $e->getMessage());
    }
    return $stats;
}

$stats = get_stats($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Bell System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1B5E20;      /* Green Dark */
            --secondary: #2E7D32;   /* Green Medium */
            --accent: #4CAF50;      /* Green Light */
            --light-green: #E8F5E9; /* Green Pale */
            --gray-bg: #f8f9fa;
            --danger: #dc3545;
            --bs-primary-rgb: 27, 94, 32;
        }
        body { font-family: 'Poppins', sans-serif; background-color: var(--gray-bg); }
        .navbar { background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        
        .stat-card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-left: 5px solid var(--accent);
            border-radius: .75rem;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
            border-left-color: var(--primary);
        }
        .stat-card .icon {
            width: 50px; height: 50px;
            background-color: var(--light-green);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-card h3 {
             color: var(--primary);
        }

        .dashboard-card { background-color: white; border-radius: .75rem; border: 1px solid #e0e0e0; }
        .table-responsive { max-height: 450px; }
        .table thead { position: sticky; top: 0; background-color: var(--light-green); }
        
        .nav-tabs .nav-link { color: #6c757d; border-radius: .5rem .5rem 0 0; }
        .nav-tabs .nav-link.active {
            color: var(--primary);
            background-color: var(--light-green);
            border-color: #dee2e6 #dee2e6 var(--light-green);
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
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
                        <i class="fas fa-user-shield me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="home.php">Lihat Situs</a></li>
                        <li><a class="dropdown-item" href="profile.php">Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4">
        <h1 class="h3 mb-4">Dashboard Administrator</h1>
        
        <!-- Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex align-items-center">
                    <div class="icon me-3"><i class="fas fa-clock"></i></div>
                    <div>
                        <h3 class="fw-bold"><?php echo $stats['total_jadwal']; ?></h3>
                        <p class="text-muted mb-0">Total Jadwal</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex align-items-center">
                    <div class="icon me-3"><i class="fas fa-users"></i></div>
                    <div>
                        <h3 class="fw-bold"><?php echo $stats['total_users']; ?></h3>
                        <p class="text-muted mb-0">Pengguna Terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex align-items-center">
                    <div class="icon me-3"><i class="fas fa-bell"></i></div>
                    <div>
                        <h3 class="fw-bold"><?php echo $stats['jadwal_hari_ini']; ?></h3>
                        <p class="text-muted mb-0">Jadwal Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifikasi Placeholder -->
        <div id="notification-placeholder" style="position: sticky; top: 10px; z-index: 1050;"></div>
        
        <!-- Tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button">Manajemen Jadwal</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pengguna-tab" data-bs-toggle="tab" data-bs-target="#pengguna" type="button">Manajemen Pengguna</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button">Log Aktivitas</button></li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Tab Manajemen Jadwal -->
            <div class="tab-pane fade show active" id="jadwal" role="tabpanel">
                <div class="dashboard-card mt-3">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Kolom Form -->
                            <div class="col-lg-5">
                                <h5 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Tambah Jadwal Baru</h5>
                                <form id="formJadwal" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="nama_jadwal" class="form-label">Nama Jadwal</label>
                                        <input type="text" class="form-control" id="nama_jadwal" name="nama_jadwal" placeholder="Contoh: Bel Masuk" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="time" class="form-label">Waktu</label>
                                        <input type="time" class="form-control" id="time" name="time" step="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Hari</label>
                                        <div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="senin" id="senin"><label class="form-check-label" for="senin">Sen</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="selasa" id="selasa"><label class="form-check-label" for="selasa">Sel</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="rabu" id="rabu"><label class="form-check-label" for="rabu">Rab</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="kamis" id="kamis"><label class="form-check-label" for="kamis">Kam</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="jumat" id="jumat"><label class="form-check-label" for="jumat">Jum</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="sabtu" id="sabtu"><label class="form-check-label" for="sabtu">Sab</label></div>
                                            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="minggu" id="minggu"><label class="form-check-label" for="minggu">Min</label></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Simpan Jadwal</button>
                                </form>
                                <hr>
                                <h5 class="fw-bold mt-4 mb-3"><i class="fas fa-hand-pointer text-primary me-2"></i>Kontrol Manual</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-success" onclick="ringBellManually('Bel Masuk')">Bunyikan Bel Masuk</button>
                                </div>
                            </div>
                            <!-- Kolom Tabel Jadwal -->
                            <div class="col-lg-7">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0"><i class="fas fa-list-ul text-primary me-2"></i>Daftar Jadwal</h5>
                                    <button class="btn btn-sm btn-danger" onclick="deleteAllSchedules()">Hapus Semua</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead><tr><th>Nama</th><th>Waktu</th><th>Hari Aktif</th><th>Aksi</th></tr></thead>
                                        <tbody id="jadwalTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Manajemen Pengguna -->
            <div class="tab-pane fade" id="pengguna" role="tabpanel">
                 <div class="dashboard-card mt-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                             <h5 class="fw-bold mb-0"><i class="fas fa-users-cog text-primary me-2"></i>Daftar Pengguna</h5>
                             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Nama Lengkap</th><th>Peran</th><th>Aksi</th></tr></thead>
                                <tbody id="usersTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                 </div>
            </div>

            <!-- Tab Log Aktivitas -->
            <div class="tab-pane fade" id="log" role="tabpanel">
                <div class="dashboard-card mt-3">
                     <div class="card-body p-4">
                         <h5 class="fw-bold mb-3"><i class="fas fa-history text-primary me-2"></i>10 Aktivitas Terakhir</h5>
                         <div class="table-responsive">
                            <table class="table">
                                <thead><tr><th>Pengguna</th><th>Aksi</th><th>Waktu</th></tr></thead>
                                <tbody id="logsTableBody"></tbody>
                            </table>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Pengguna Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="formUser" class="needs-validation" novalidate>
              <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="fullname" required></div>
              <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
              <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" required></div>
              <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
              <div class="mb-3">
                <label class="form-label">Peran</label>
                <select class="form-select" name="role" required>
                  <option value="user">User</option><option value="petugas">Petugas</option><option value="admin">Admin</option>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="saveUserBtn">Simpan Pengguna</button>
          </div>
        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- UTILITIES ---
        function showNotification(message, type = 'success') {
            const placeholder = document.getElementById('notification-placeholder');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
            placeholder.append(wrapper);
            setTimeout(() => wrapper.remove(), 5000);
        }

        async function apiCall(action, formData) {
            formData.append('action', action);
            try {
                const response = await fetch('api_handler.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (!response.ok) throw new Error(result.message || 'Terjadi kesalahan pada server.');
                return result;
            } catch (error) {
                showNotification(`Error: ${error.message}`, 'danger');
                console.error(error);
                return null;
            }
        }
        
        function validateForm(form) {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return false;
            }
            form.classList.remove('was-validated');
            return true;
        }

        // --- SCHEDULE MANAGEMENT ---
        const jadwalTableBody = document.getElementById('jadwalTableBody');
        async function loadSchedules() {
            jadwalTableBody.innerHTML = `<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm"></div></td></tr>`;
            const result = await apiCall('get_schedules', new FormData());
            if (result && result.data) {
                jadwalTableBody.innerHTML = '';
                if(result.data.length === 0) {
                     jadwalTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Belum ada jadwal.</td></tr>`;
                }
                result.data.forEach(s => {
                    let days = [];
                    if(s.senin == 1) days.push('Sen'); if(s.selasa == 1) days.push('Sel'); if(s.rabu == 1) days.push('Rab');
                    if(s.kamis == 1) days.push('Kam'); if(s.jumat == 1) days.push('Jum'); if(s.sabtu == 1) days.push('Sab');
                    if(s.minggu == 1) days.push('Min');
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${s.nama_jadwal}</td>
                        <td>${s.time.substring(0, 5)}</td>
                        <td><small>${days.join(', ') || '-'}</small></td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="deleteSchedule(${s.id})"><i class="fas fa-trash"></i></button></td>
                    `;
                    jadwalTableBody.appendChild(row);
                });
            }
        }
        
        document.getElementById('formJadwal').addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!validateForm(this)) return;
            const result = await apiCall('add_schedule', new FormData(this));
            if(result && result.success) {
                showNotification(result.message, 'success');
                this.reset();
                this.classList.remove('was-validated');
                loadSchedules();
            }
        });

        async function deleteSchedule(id) {
            if (!confirm(`Yakin ingin menghapus jadwal ID ${id}?`)) return;
            const formData = new FormData();
            formData.append('id', id);
            const result = await apiCall('delete_schedule', formData);
            if(result && result.success) {
                showNotification(result.message, 'warning');
                loadSchedules();
            }
        }

        async function deleteAllSchedules() {
            if (!confirm('PERINGATAN! Anda akan menghapus SEMUA jadwal. Aksi ini tidak dapat dibatalkan. Lanjutkan?')) return;
            const result = await apiCall('delete_all_schedules', new FormData());
            if(result && result.success) {
                showNotification(result.message, 'danger');
                loadSchedules();
            }
        }
        
        async function ringBellManually(bell_name){
            const formData = new FormData();
            formData.append('bell_name', bell_name);
            const result = await apiCall('ring_bell_manually', formData);
            if(result && result.success) showNotification(result.message, 'info');
        }

        // --- USER MANAGEMENT ---
        const usersTableBody = document.getElementById('usersTableBody');
        const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        async function loadUsers() {
            usersTableBody.innerHTML = `<tr><td colspan="6" class="text-center"><div class="spinner-border spinner-border-sm"></div></td></tr>`;
            const result = await apiCall('get_users', new FormData());
            if (result && result.data) {
                usersTableBody.innerHTML = '';
                 if(result.data.length === 0) {
                     usersTableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Belum ada pengguna.</td></tr>`;
                }
                result.data.forEach(u => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${u.id}</td><td>${u.username}</td><td>${u.email}</td>
                        <td>${u.fullname || '-'}</td><td>${u.role}</td>
                        <td><button class="btn btn-sm btn-outline-danger" onclick="deleteUser(${u.id})"><i class="fas fa-trash"></i></button></td>
                    `;
                    usersTableBody.appendChild(row);
                });
            }
        }
        
        document.getElementById('saveUserBtn').addEventListener('click', async function(){
            const form = document.getElementById('formUser');
            if (!validateForm(form)) return;
            const result = await apiCall('add_user', new FormData(form));
            if(result && result.success) {
                showNotification(result.message, 'success');
                form.reset();
                form.classList.remove('was-validated');
                addUserModal.hide();
                loadUsers();
            }
        });
        
        async function deleteUser(id) {
             if (!confirm(`Yakin ingin menghapus pengguna ID ${id}?`)) return;
            const formData = new FormData();
            formData.append('id', id);
            const result = await apiCall('delete_user', formData);
            if(result && result.success) {
                showNotification(result.message, 'warning');
                loadUsers();
            }
        }
        
        // --- LOGS ---
        const logsTableBody = document.getElementById('logsTableBody');
        async function loadLogs() {
             logsTableBody.innerHTML = `<tr><td colspan="3" class="text-center"><div class="spinner-border spinner-border-sm"></div></td></tr>`;
            const result = await apiCall('get_logs', new FormData());
            if(result && result.data) {
                logsTableBody.innerHTML = '';
                if(result.data.length === 0) {
                    logsTableBody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">Belum ada aktivitas.</td></tr>`;
                }
                result.data.forEach(log => {
                    const row = document.createElement('tr');
                    const d = new Date(log.created_at);
                    const formattedDate = `${d.toLocaleDateString('id-ID')} ${d.toLocaleTimeString('id-ID', { hour: '2-digit', minute:'2-digit' })}`;
                    row.innerHTML = `<td><strong>${log.username}</strong></td><td>${log.action}</td><td>${formattedDate}</td>`;
                    logsTableBody.appendChild(row);
                });
            }
        }
        
        // --- INITIAL LOAD & TAB EVENTS ---
        document.addEventListener('DOMContentLoaded', () => {
            loadSchedules();
            
            document.getElementById('pengguna-tab').addEventListener('shown.bs.tab', loadUsers);
            document.getElementById('log-tab').addEventListener('shown.bs.tab', loadLogs);
        });

    </script>
</body>
</html>
