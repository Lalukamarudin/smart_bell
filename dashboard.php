<?php
session_start();
require_once 'koneksi.php';

// Keamanan: Pastikan hanya user yang sudah login yang bisa mengakses halaman ini.
// Jika belum login, tendang ke halaman login.
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Ambil nama lengkap user dari session untuk sapaan personal.
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Bell System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1B5E20;
            --secondary: #4CAF50;
            --light-green: #E8F5E9;
            --gray-bg: #f8f9fa;
            --text-dark: #343a40;
            --text-muted: #6c757d;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-bg);
        }

        /* Navbar */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .navbar-brand img { max-height: 40px; }
        
        /* Main Content */
        .main-content {
            padding-top: 90px;
        }

        /* Header Card */
        .header-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 1rem;
            padding: 2rem;
        }
        #clock {
            font-size: 2.5rem;
            font-weight: 600;
        }

        /* Dashboard Card */
        .dashboard-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            overflow: hidden; /* Penting untuk table-responsive */
        }
        .dashboard-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .dashboard-card-header h4 {
            margin: 0;
            font-weight: 600;
            color: var(--primary);
        }

        /* Tabel Jadwal */
        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
        }
        .table thead {
            position: sticky;
            top: 0;
            background-color: var(--light-green);
        }
        .table th {
            font-weight: 600;
        }
        .table td .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <img src="asset/LOGO-SMKNW-PANCOR-246x300.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo $username; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container py-4">
            <!-- Header -->
            <div class="header-card mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold">Selamat Datang, <?php echo $username; ?>!</h2>
                        <p class="mb-0">Berikut adalah jadwal bel yang aktif di sistem saat ini.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <h3 id="clock" class="mb-0">00:00:00</h3>
                        <p id="date" class="mb-0">Senin, 1 Januari 2024</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Jadwal -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h4><i class="fas fa-list-ul me-2"></i>Daftar Jadwal Bel</h4>
                </div>
                <div class="table-wrapper">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis Bel</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="riwayatTableBody">
                            <!-- Data akan dimuat oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadRiwayat();
            setInterval(updateClock, 1000);
            updateClock();
        });

        const riwayatTableBody = document.getElementById('riwayatTableBody');
        
        /**
         * Memuat data riwayat dari server dan menampilkannya di tabel.
         */
        async function loadRiwayat() {
            riwayatTableBody.innerHTML = `<tr><td colspan="4" class="text-center py-5"><div class="spinner-border text-success" role="status"></div></td></tr>`;
            try {
                const response = await fetch('tampil_bel.php');
                if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                
                const data = await response.json();
                riwayatTableBody.innerHTML = '';

                if (data.length === 0) {
                    riwayatTableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada jadwal yang diatur.</td></tr>';
                } else {
                    const now = new Date();
                    const currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
                    
                    data.sort((a, b) => a.time.localeCompare(b.time)); // Urutkan berdasarkan waktu

                    data.forEach(item => {
                        const [h, m, s] = item.time.split(':');
                        const itemTime = (+h) * 3600 + (+m) * 60 + (+s);
                        
                        let statusBadge;
                        if (itemTime < currentTime) {
                            statusBadge = '<span class="badge bg-secondary">Selesai</span>';
                        } else {
                            statusBadge = '<span class="badge bg-success">Akan Datang</span>';
                        }

                        const row = `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.hari || 'N/A'}</td>
                                <td><strong>${item.time.substring(0, 5)}</strong></td>
                                <td>${statusBadge}</td>
                            </tr>
                        `;
                        riwayatTableBody.insertAdjacentHTML('beforeend', row);
                    });
                }
            } catch (error) {
                console.error('Error saat memuat riwayat:', error);
                riwayatTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger py-4">${error.message}</td></tr>`;
            }
        }

        /**
         * Memperbarui jam digital secara real-time.
         */
        function updateClock() {
            const now = new Date();
            const clockEl = document.getElementById('clock');
            const dateEl = document.getElementById('date');
            
            if (clockEl && dateEl) {
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const s = String(now.getSeconds()).padStart(2, '0');
                clockEl.textContent = `${h}:${m}:${s}`;
                
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Makassar' };
                dateEl.textContent = now.toLocaleDateString('id-ID', options);
            }
        }

    </script>
</body>
</html>
