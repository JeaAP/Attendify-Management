<?php
require_once __DIR__ . '/../../../config/config.php';

// Mengambil bagian URL dari path
$requestUri = $_SERVER['REQUEST_URI'];

$pathSegments = explode('/', trim($requestUri, '/'));
$currentFolder = end($pathSegments); // Mengambil elemen terakhir, yaitu folder saat ini

// Tentukan status "active" berdasarkan folder yang ada
$dashboardActive = ($currentFolder === 'dashboard.php') ? 'active' : ''; // Jika folder saat ini adalah 'dashboard'
$absensiActive = ($currentFolder === 'absensi') ? 'active' : ''; // Jika folder saat ini adalah 'absensi'
$qrcodeActive = ($currentFolder === 'qrcodes') ? 'active' : ''; // Jika folder saat ini adalah 'qrcodes'
$aboutActive = ($currentFolder === 'about') ? 'active' : ''; // Jika folder saat ini adalah 'about'
?>

<nav class="sidebar">
    <h4 class="nav-logo">
        <img src="<?=ASSETS_PATH?>images/PNGAttendify.png" alt="Logo" class="logo"> Attendify
    </h4>
    <p class="menu">Menu</p>
    <ul class="nav flex-column">
        <div class="top-nav">
            <!-- Navigasi Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?= $dashboardActive; ?>" href="<?=BASE_URL?>app/views/dashboard.php">
                    <img src="<?=ASSETS_PATH?>images/PNGDashboard.png" alt="Dashboard Icon" class="nav-icon <?= $dashboardActive; ?>"> Dashboard
                </a>
            </li>
            <!-- Navigasi Absensi -->
            <li class="nav-item">
                <a class="nav-link <?= $absensiActive; ?>" href="<?=BASE_URL?>app/views/absensi">
                    <img src="<?=ASSETS_PATH?>images/PNGAbsensi.png" alt="Absensi Icon" class="nav-icon <?= $absensiActive; ?>"> Absensi
                </a>
            </li>
            <!-- Navigasi About -->
            <li class="nav-item">
                <a class="nav-link <?= $aboutActive; ?>" href="<?=BASE_URL?>app/views/about">
                    <img src="<?=ASSETS_PATH?>images/PNGAbout.png" alt="About Icon" class="nav-icon <?= $aboutActive; ?>"> About
                </a>
            </li>
            <!-- Navigasi QR Code -->
            <li class="nav-item">
                <a class="nav-link <?= $qrcodeActive; ?>" href="<?=BASE_URL?>app/views/qrcodes">
                    <img src="<?=ASSETS_PATH?>images/PNGQr.png" alt="Qr Icon" class="nav-icon <?= $qrcodeActive; ?>"> QR Code
                </a>
            </li>
        </div>
        <div class="bottom-nav">
            <li class="nav-item">
                <a class="nav-link" href="#" id="logoutBtn">
                    <img src="<?=ASSETS_PATH?>images/PNGLogout.png" alt="Logout Icon" class="nav-icon"> Logout
                </a>
            </li>
        </div>
    </ul>
</nav>

<script>
    // Logout
    const logoutButton = document.getElementById('logoutBtn');
    logoutButton.addEventListener('click', function() {
        const confirmLogout = confirm('Apakah Anda yakin ingin keluar?');
        if (confirmLogout) {
            sessionStorage.clear();
            window.location.href = '<?=BASE_URL?>app/routes/authRoutes.php?action=logout';
        }
    });
</script>