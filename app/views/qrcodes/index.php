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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">
    
    <script src="/Attendify-Management/public/assets/js/config.js"></script>
    <script src="/Attendify-Management/public/assets/js/filter.js"></script>
    <script>
        sessionStorage.setItem("lastPage", window.location.pathname);
        // Bypass javascript auth
        if (!sessionStorage.getItem("authenticated")) {
            window.location.href = window.CONFIG.BASE_URL + "public/";
        }
    </script>
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
                        <div class="row"> 
                            <div class="col-md-auto">
                                <img src="<?= ASSETS_PATH ?>images/Frame43.png">
                            </div>
                            <div class="col">
                                <h6>Data QR code</h6>
                            </div>
                            <div class="col-md-auto">
                                <div class="form-row">
                                    <div class="form-group col-md-auto">
                                        <!-- Tombol Refresh -->
                                        <button type="button" class="btn btn-primary" id="refreshButton">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="form-group col-md-auto">
                                        <!-- Filter Tanggal -->
                                        <input type="date" class="form-control" id="filterDate" oninput="filterByDate()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qr-card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>QR Code</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">
                                <tr>
                                    <td><img src="<?= ASSETS_PATH ?>images//PNGQr.png" alt="QR Code"></td>
                                    <td class="text-center align-content-center">17-01-2025</td>
                                    <td class="text-center align-content-center"><button class="delete-btn">Delete</button></td>
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
                        <h6 class="card-title text-center align-content-center">QR code Terbaru</h6>
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
