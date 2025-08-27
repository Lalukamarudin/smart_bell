<?php
session_start();
require_once 'koneksi.php';

// --- FUNGSI UTAMA UNTUK MENGAMBIL SEMUA DATA DINAMIS ---
function get_full_homepage_data($koneksi) {
    $data = [
        'total_users' => 0, 'total_teachers' => 0, 'students_male' => 0, 
        'students_female' => 0, 'alumni' => [], 'upcoming_schedules' => [],
        'gallery' => [], 'articles' => [], 'next_event' => null
    ];

    try {
        // Query data secara paralel jika memungkinkan (mysqli tidak mendukung secara native, jadi kita eksekusi satu per satu)
        
        // Statistik Pengguna, Guru, Siswa
        $data['total_users'] = $koneksi->query("SELECT COUNT(id) as total FROM users")->fetch_assoc()['total'] ?? 0;
        $data['total_teachers'] = $koneksi->query("SELECT COUNT(id) as total FROM teachers")->fetch_assoc()['total'] ?? 0;
        $data['students_male'] = $koneksi->query("SELECT COUNT(id) as total FROM students WHERE gender = 'Laki-laki'")->fetch_assoc()['total'] ?? 0;
        $data['students_female'] = $koneksi->query("SELECT COUNT(id) as total FROM students WHERE gender = 'Perempuan'")->fetch_assoc()['total'] ?? 0;

        // Data Alumni
        $result_alumni = $koneksi->query("SELECT name, graduation_year, story, photo_url FROM alumni ORDER BY RAND() LIMIT 3");
        if ($result_alumni) $data['alumni'] = $result_alumni->fetch_all(MYSQLI_ASSOC);

        // Jadwal Bel Mendatang
        date_default_timezone_set('Asia/Makassar');
        $currentTime = date('H:i:s');
        $dayOfWeek = strtolower(date('l'));
        $dayMap = ['monday'=>'senin', 'tuesday'=>'selasa', 'wednesday'=>'rabu', 'thursday'=>'kamis', 'friday'=>'jumat', 'saturday'=>'sabtu', 'sunday'=>'minggu'];
        $todayColumn = $dayMap[$dayOfWeek] ?? 'senin';
        $stmt_upcoming = $koneksi->prepare("SELECT nama_jadwal, time FROM kontrol_bel WHERE {$todayColumn} = 1 AND time > ? ORDER BY time ASC LIMIT 5");
        $stmt_upcoming->bind_param("s", $currentTime);
        $stmt_upcoming->execute();
        $data['upcoming_schedules'] = $stmt_upcoming->get_result()->fetch_all(MYSQLI_ASSOC);

        // Galeri
        $result_gallery = $koneksi->query("SELECT image_url, title, category FROM galleries ORDER BY id DESC LIMIT 6");
        if ($result_gallery) $data['gallery'] = $result_gallery->fetch_all(MYSQLI_ASSOC);

        // Artikel
        $result_articles = $koneksi->query("SELECT title, excerpt, image_url, created_at FROM articles ORDER BY created_at DESC LIMIT 3");
        if ($result_articles) $data['articles'] = $result_articles->fetch_all(MYSQLI_ASSOC);
        
        // Acara Mendatang
        $result_event = $koneksi->query("SELECT title, event_date FROM events WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 1");
        if ($result_event) $data['next_event'] = $result_event->fetch_assoc();

    } catch (Exception $e) {
        error_log("Gagal mengambil data homepage: " . $e->getMessage());
    }
    return $data;
}

$page_data = get_full_homepage_data($koneksi);

function time_ago($timestamp) {
    $time_ago = strtotime($timestamp); $current_time = time(); $time_difference = $current_time - $time_ago;
    $seconds = $time_difference; $minutes = round($seconds / 60); $hours = round($seconds / 3600); $days = round($seconds / 86400);
    if ($seconds <= 60) return "Baru saja"; else if ($minutes <= 60) return ($minutes == 1) ? "1 menit lalu" : "$minutes menit lalu";
    else if ($hours <= 24) return ($hours == 1) ? "1 jam lalu" : "$hours jam lalu"; else return ($days == 1) ? "1 hari lalu" : "$days hari lalu";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Smart Bell System SMK NWDI Pancor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1B5E20; --secondary: #2E7D32; --accent: #4CAF50;
            --light-green: #E8F5E9; --gray-bg: #f9fafb; --bs-primary-rgb: 27, 94, 32;
        }
        body { font-family: 'Poppins', sans-serif; background-color: white; }
        .navbar { transition: all 0.3s ease; }
        .navbar-brand img { max-height: 40px; }
        .navbar.scrolled { background-color: white !important; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--secondary); border-color: var(--secondary); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background-color: var(--primary); color: white; }

        .hero-section {
            padding-top: 140px; padding-bottom: 80px;
            background: linear-gradient(135deg, var(--light-green), white);
            position: relative; overflow: hidden;
        }
        .hero-section h1 { font-weight: 800; color: var(--primary); font-size: 3.5rem; }
        .hero-section .lead { font-size: 1.25rem; }
        .hero-img { 
            max-width: 400px;
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }

        .section { padding: 80px 0; }
        .section-title { font-weight: 700; color: var(--primary); margin-bottom: 1rem; }
        .section-subtitle { max-width: 600px; margin: 0 auto 4rem auto; color: #6b7280; }
        
        .card { border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.07); transition: all 0.3s ease; }
        .card:hover { transform: translateY(-8px); box-shadow: 0 18px 45px rgba(0,0,0,0.12); }
        
        .jurusan-card .icon-wrapper {
            width: 80px; height: 80px; background-color: var(--light-green); color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; margin: 0 auto 1.5rem auto; transition: all 0.3s ease;
        }
        .jurusan-card:hover .icon-wrapper { background-color: var(--primary); color: white; transform: scale(1.1) rotate(15deg); }

        .stat-card { background: var(--primary); color: white; text-align: center; padding: 2rem; }
        .stat-number { font-size: 3.5rem; font-weight: 700; }
        
        .alumni-card { background-color: var(--light-green); }
        .alumni-card img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        
        .gallery-item { position: relative; overflow: hidden; border-radius: .75rem; }
        .gallery-item img { transition: transform 0.4s ease; }
        .gallery-item:hover img { transform: scale(1.1); }
        .gallery-overlay {
            position: absolute; bottom: 0; left: 0; width: 100%; color: white;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 1.5rem; transform: translateY(100%); transition: transform 0.4s ease;
        }
        .gallery-item:hover .gallery-overlay { transform: translateY(0); }
        
        .article-card img { height: 200px; object-fit: cover; }
        .article-card .badge { background-color: var(--primary); }

        #event-countdown { font-size: 2.5rem; font-weight: 700; color: var(--accent); letter-spacing: 2px; }

        footer { background-color: #1f2937; color: #9ca3af; padding: 60px 0; }
        footer .footer-title { color: white; font-weight: 600; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php"><img src="asset/LOGO-SMKNW-PANCOR-246x300.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jurusan">Jurusan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="#alumni">Alumni</a></li>
                </ul>
                <div class="ms-lg-3">
                     <?php if(isset($_SESSION['loggedin'])): ?>
                        <div class="dropdown">
                            <a href="#" class="btn btn-outline-primary dropdown-toggle rounded-pill px-3" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo $_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'dashboard.php'; ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="profile.php">Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-primary rounded-pill px-3 me-2">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 mb-4" data-aos="fade-right">Selamat Datang di SMK NWDI Pancor</h1>
                    <p class="lead text-muted mb-5" data-aos="fade-right" data-aos-delay="100">Membentuk Generasi Unggul, Kreatif, dan Berakhlak Mulia Melalui Pendidikan Vokasi Berkualitas.</p>
                    <div data-aos="fade-right" data-aos-delay="200">
                        <a href="https://smknwdipancor.sch.id/" target="_blank" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Pendaftaran Siswa Baru <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                    <img src="asset/bdk.jpg" class="img-fluid hero-img" alt="Ilustrasi Sekolah"> <!-- Ganti dengan URL gambar yang sesuai -->
                </div>
            </div>
        </div>
    </header>
    
    <!-- Live Schedule & Countdown -->
    <section class="section" style="padding-top:0; margin-top: -50px;">
        <div class="container">
             <div class="card p-4" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-primary"><i class="fas fa-bell me-2"></i>Jadwal Bel Berikutnya Hari Ini</h5>
                        <div id="upcoming-schedule-list" class="mt-3">
                             <?php if (empty($page_data['upcoming_schedules'])): ?>
                                <p class="text-center text-muted p-3">Tidak ada jadwal bel berikutnya.</p>
                            <?php else: ?>
                                <?php foreach ($page_data['upcoming_schedules'] as $schedule): ?>
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <span><?php echo htmlspecialchars($schedule['nama_jadwal']); ?></span>
                                        <span class="fw-bold text-primary" data-time="<?php echo $schedule['time']; ?>"><?php echo date("H:i", strtotime($schedule['time'])); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-5 border-start-lg mt-4 mt-lg-0 text-center">
                         <h5 class="fw-bold text-primary">Acara Terdekat</h5>
                         <?php if ($page_data['next_event']): ?>
                             <p class="mb-2"><?php echo htmlspecialchars($page_data['next_event']['title']); ?></p>
                             <div id="event-countdown" data-datetime="<?php echo $page_data['next_event']['event_date']; ?>"></div>
                         <?php else: ?>
                             <p class="text-muted mt-3">Belum ada acara yang dijadwalkan.</p>
                         <?php endif; ?>
                    </div>
                </div>
             </div>
        </div>
    </section>

    <!-- Jurusan Section -->
    <section id="jurusan" class="section bg-light-green">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Jurusan Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200"><div class="card jurusan-card h-100 p-4"><div class="icon-wrapper"><i class="fas fa-code"></i></div><h4 class="fw-bold">RPL</h4><p class="text-muted small">Menjadi ahli rekayasa perangkat lunak, web, mobile, dan basis data.</p></div></div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300"><div class="card jurusan-card h-100 p-4"><div class="icon-wrapper"><i class="fas fa-cut"></i></div><h4 class="fw-bold">Tata Busana</h4><p class="text-muted small">Menguasai desain fesyen, pembuatan pola, hingga teknik menjahit.</p></div></div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400"><div class="card jurusan-card h-100 p-4"><div class="icon-wrapper"><i class="fas fa-utensils"></i></div><h4 class="fw-bold">Tata Boga</h4><p class="text-muted small">Menjelajahi dunia kuliner, dari seni memasak hingga manajemen restoran.</p></div></div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="500"><div class="card jurusan-card h-100 p-4"><div class="icon-wrapper"><i class="fas fa-concierge-bell"></i></div><h4 class="fw-bold">Perhotelan</h4><p class="text-muted small">Mempelajari standar layanan perhotelan internasional dan manajemen.</p></div></div>
            </div>
        </div>
    </section>

    <!-- Statistik Sekolah Section -->
    <section class="section">
        <div class="container">
             <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up"><div class="card stat-card"><div class="stat-number counter" data-target="<?php echo $page_data['students_male']; ?>">0</div><p class="mb-0">Siswa Laki-laki</p></div></div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100"><div class="card stat-card"><div class="stat-number counter" data-target="<?php echo $page_data['students_female']; ?>">0</div><p class="mb-0">Siswa Perempuan</p></div></div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200"><div class="card stat-card"><div class="stat-number counter" data-target="<?php echo $page_data['total_teachers']; ?>">0</div><p class="mb-0">Tenaga Pendidik</p></div></div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300"><div class="card stat-card"><div class="stat-number counter" data-target="<?php echo $page_data['total_users']; ?>">0</div><p class="mb-0">Pengguna Sistem</p></div></div>
            </div>
        </div>
    </section>
    
    <!-- Galeri Section -->
    <section id="galeri" class="section bg-light-green">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Galeri Sekolah</h2>
            <div class="row g-4">
                <?php foreach ($page_data['gallery'] as $index => $item): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <a href="#" class="gallery-item d-block">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="img-fluid">
                        <div class="gallery-overlay">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($item['title']); ?></h5>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Berita Section -->
    <section id="berita" class="section">
        <div class="container text-center">
             <h2 class="section-title" data-aos="fade-up">Berita & Informasi Terbaru</h2>
             <div class="row g-4 justify-content-center">
                 <?php foreach ($page_data['articles'] as $index => $article): ?>
                 <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                     <div class="card article-card h-100">
                         <img src="<?php echo htmlspecialchars($article['image_url']); ?>" class="card-img-top">
                         <div class="card-body text-start">
                            <span class="badge mb-2"><?php echo time_ago($article['created_at']); ?></span>
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text text-muted small"><?php echo htmlspecialchars($article['excerpt']); ?></p>
                         </div>
                     </div>
                 </div>
                 <?php endforeach; ?>
             </div>
        </div>
    </section>

    <!-- Alumni Section -->
    <section id="alumni" class="section bg-light-green">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Kisah Sukses Alumni</h2>
            <div class="row g-4">
                 <?php foreach ($page_data['alumni'] as $index => $alumnus): ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo 200 + ($index * 100); ?>">
                        <div class="card alumni-card h-100 p-4 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <img src="<?php echo htmlspecialchars($alumnus['photo_url']); ?>" alt="Foto Alumni">
                                <div class="ms-3">
                                    <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($alumnus['name']); ?></h5>
                                    <p class="text-muted mb-0">Lulusan <?php echo htmlspecialchars($alumnus['graduation_year']); ?></p>
                                </div>
                            </div>
                            <p class="mb-0 small">"<?php echo htmlspecialchars($alumnus['story']); ?>"</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Smart Bell System. Dikembangkan untuk SMK NWDI Pancor.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Efek scroll pada navbar
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Animasi counter angka
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = +counter.getAttribute('data-target');
                    let count = 0;
                    const updateCount = () => {
                        const inc = Math.max(target / 100, 1);
                        if (count < target) {
                            count = Math.min(Math.ceil(count + inc), target);
                            counter.innerText = count;
                            setTimeout(updateCount, 20);
                        }
                    };
                    updateCount();
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(counter => observer.observe(counter));
        
        // Countdown untuk acara
        const countdownEl = document.getElementById('event-countdown');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.getAttribute('data-datetime')).getTime();
            const interval = setInterval(() => {
                const now = new Date().getTime();
                const diff = targetDate - now;
                if (diff < 0) {
                    clearInterval(interval);
                    countdownEl.innerHTML = "Acara Telah Berlangsung";
                    return;
                }
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);
                countdownEl.innerHTML = `${d}h ${h}j ${m}m ${s}d`;
            }, 1000);
        }
    </script>
</body>
</html>
