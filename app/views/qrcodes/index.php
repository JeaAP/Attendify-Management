<?php
require_once __DIR__ . '/../../../config/config.php';

session_start();
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qrcodes Attendify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">
</head>
<body>
    <!-- Template Sidebar -->
    <?php include_once __DIR__ . "/../templates/sidebar.php" ?>

    <main>
        <h2>QR code</h2>
        <div class="qr-container">
            <!-- Left Panel -->
            <div class="qr-left-panel">
                <div class="qr-card">
                    <div class="qr-card-header">
                        <img src="<?= ASSETS_PATH ?>images//PNGQr.png" alt="QR Icon" class="qr-card-icon">
                        <h5>Data QR code</h5>
                        <div class="qr-card-actions">
                            <select class="qr-action-dropdown">
                                <option>Today</option>
                                <option>Next Week</option>
                            </select>
                        </div>
                    </div>
                    <div class="qr-card-body">
                        <table class="qr-code-table">
                            <thead>
                                <tr>
                                    <th>QR Code</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="<?= ASSETS_PATH ?>images//PNGQr.png" alt="QR Code"></td>
                                    <td>17-01-2025</td>
                                    <td><button class="delete-btn">Delete</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="qr-right-panel">
                <div class="qr-card">
                    <div class="qr-card-header">
                        <h5>QR code Terbaru</h5>
                    </div>
                    <div class="qr-card-body">
                        <img src="<?= ASSETS_PATH ?>images//PNGQr.png" alt="QR Code" class="qr-preview-img">
                        <div class="qr-actions">
                            <button class="download-btn">Download</button>
                            <button class="generate-btn">Generate QR code</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
