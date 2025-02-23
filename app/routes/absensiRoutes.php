<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../controllers/absensiController.php';

if(isset($_GET['action'])) {
    $action = $_GET['action']; // Mengambil parameter action

    // $limit = isset($_GET['limit'])? $_GET['limit'] : 10;
    // $page = isset($_GET['page'])? $_GET['page'] : 1;

    // $kelas = isset($_GET['kelas'])? $_GET['kelas'] : '';
    // $jurusan = isset($_GET['jurusan'])? $_GET['jurusan'] : '';
    // $status = isset($_GET['status'])? $_GET['status'] : '';
    // $mood = isset($_GET['mood'])? $_GET['mood'] : '';
    // $tanggal = isset($_GET['tanggal'])? $_GET['tanggal'] : '';

    switch ($action) {
        case 'baca':
            $absensiAll = getAllAbsensiController();
            $totalAbsensi = getTotalAbsensiController();
            getJurusanController();
            getKelasController();
            // $filterAbsensi = filterAbsensiController($kelas, $jurusan, $status, $mood, $tanggal, $limit, $page);
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