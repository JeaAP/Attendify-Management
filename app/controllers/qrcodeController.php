<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/qrcodeModel.php';

function createQrcodeController() {
    try {
        addQRCode();
        header("Location: Qr.php?success=note_created");
    } catch (Exception $e) {
        // Menangani jika ada error
        header("Location: Qr.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}

function deleteQrcodeController() {
    // Mengambil id QR Code yang dipilih
    if(isset($_GET['id'])) {
        $id = cleanInput($_GET['id']);

        // Menghapus QR Code berdasarkan id
        try {
            deleteQRCode($id);
            header("Location: Qr.php?success=note_deleted");
        } catch (Exception $e) {
            // Menangani jika ada error
            header("Location: Qr.php?error=" . urlencode($e->getMessage()));
        }
    } else {
        // Menangani jika id QR Code tidak ditemukan
        header("Location: Qr.php?error=id_not_provided");
        exit();
    }
}
?>