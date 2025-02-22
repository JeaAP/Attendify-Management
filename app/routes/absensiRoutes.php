<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../controllers/absensiController.php';

if(isset($_GET['action'])) {
    $action = $_GET['action']; // Mengambil parameter action

    switch ($action) {
        case 'baca':
            getAllAbsensiController();
            getTotalAbsensiController();
            getJurusanController();
            getKelasController();
            break;
        default: // Tidak menemukan parameter, pergi ke index.php
            header('Location: '. BASE_URL. 'public/');
            exit();
    }
} else {
    header('Location: '. BASE_URL. 'public/');
    exit();
}
?>