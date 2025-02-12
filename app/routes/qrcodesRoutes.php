<?php
require_once __DIR__ . '/../../config/config.php';
require_once  __DIR__ . '/../controllers/qrcodeController.php';

if(isset($_GET['action'])) {
    $action = $_GET['action']; // Mengambil parameter action

    switch($action) {
        case 'create': // Membuat qrcode
            createQrcodeController();
            break;
        case 'read': // Membaca qrcode
            readQrcodeController();
            break;
        case 'delete': // Menghapus qrcode
            deleteQrcodeController();
            break;
        
        default: // Tidak ada parameter
            echo "Aksi tidak valid!";
            break;
    }
} else {
    echo "Aksi tidak ditemukan!";
}
?>