<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../controllers/qrcodeController.php';

$qr_codes = readQrcodeController();

$folderPath = BASE_URL . '../qrcodes/';
$files = scandir($folderPath);

if (is_dir($folderPath)) {
    $files = array_diff(scandir($folderPath, SCANDIR_SORT_DESCENDING), array('.', '..'));
    $latestQr = reset($files); // Ambil file (terbaru)
} else {
    $latestQr = null;
}

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
    
    <script src="<?= BASE_URL ?>public/assets/js/config.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/filter.js"></script>
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
                                <?php foreach ($files as $file):
                                    if ($file === '.' || $file === '..') continue; 
                                        foreach($qr_codes as $qr_code): 
                                            if($file === $qrCode['qr_code_text'] . '.png') continue;?>
                                <tr>
                                    <td>
                                        <img src="<?= $folderPath . $file ?>" alt="QR Code">
                                        <span class="qr-code-text" hidden><?= $qrCode['qr_code_text']?></span>
                                    </td>
                                    <td class="text-center align-content-center"><?= date($qrCode['created_at']) ?></td>
                                    <td class="text-center align-content-center"><button class="delete-btn">Delete</button></td>
                                </tr>
                                <?php endforeach; endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="qr-right-panel">
                <div class="qr-card">
                    <div class="qr-card-header">
                        <h6 class="card-title text-center align-content-center">QR Code Terbaru</h6>
                    </div>
                    <div class="qr-card-body text-center">
                        <?php if ($latestQr): ?>
                            <img src="<?= $folderPath . $latestQr ?>" alt="QR Code" class="qr-preview-img" style="width: 200px;">
                        <?php else: ?>
                            <p>Tidak ada QR Code tersedia.</p>
                        <?php endif; ?>

                        <div class="qr-actions mt-3">
                            <?php if ($latestQr): ?>
                                <a href="<?= $folderPath . $latestQr ?>" download="<?= $latestQr ?>">
                                    <button class="btn btn-success">Download</button>
                                </a>
                            <?php endif; ?>
                            
                            <a href="<?= BASE_URL ?>app/routes/qrcodesRoutes.php?action=create">
                                <button class="btn btn-primary">Generate QR Code</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
