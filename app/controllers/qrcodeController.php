<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/qrcodeModel.php';

function createQrcodeController() {
    try {
        addQRCode();
        header("Location: Qr.php?success=note_created");
    } catch (Exception $e) {
        header("Location: Qr.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}

function readQrcodeController() {
    try{
        return getAllQRCode();
    } catch(Exception $e) {
        header("Location: Qr.php?error=". urlencode($e->getMessage()));
    }
}

function deleteQrcodeController() {
    if(isset($_GET['id'])) {
        $id = cleanInput($_GET['id']);

        try {
            deleteQRCode($id);
            header("Location: Qr.php?success=note_deleted");
        } catch (Exception $e) {

            header("Location: Qr.php?error=" . urlencode($e->getMessage()));
        }
    } else {
        header("Location: Qr.php?error=id_not_provided");
        exit();
    }
}
?>