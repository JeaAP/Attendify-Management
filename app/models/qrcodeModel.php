<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../utils/phpqrcode.php';

// Fungsi untuk membersihkan input (Sanitasi XSS)
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function addQRCode(): bool {
    global $conn;
    $today = date('Y-m-d');

    // Cek apakah QR code untuk hari ini sudah ada
    $stmt = $conn->prepare("SELECT * FROM qr_codes WHERE qr_code_date = ?");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "QR Code for today already exists!";
        return false;
    } else {
        $uniqueCode = $today . '-' . md5(uniqid());
        $filePath = __DIR__ . '/../../../qrcodes/' . $uniqueCode . '.png';

        // **DEBUGGING**: Pastikan folder ada dan bisa ditulis
        if (!is_dir(__DIR__ . '/../../../qrcodes/')) {
            die("Error: QR Code folder does not exist or is not writable.");
        }

        // **DEBUGGING**: Cek apakah library phpqrcode berfungsi
        if (!class_exists('QRcode')) {
            die("Error: phpqrcode library not found.");
        }

        // Generate QR Code
        QRcode::png($uniqueCode, $filePath, QR_ECLEVEL_L, 10);

        // **DEBUGGING**: Pastikan file QR Code berhasil dibuat
        if (!file_exists($filePath)) {
            die("Error: Failed to generate QR Code.");
        }

        // Simpan QR Code ke database
        $stmt = $conn->prepare("INSERT INTO qr_codes (qr_code_text, qr_code_date) VALUES (?, ?)");
        $stmt->bind_param("ss", $uniqueCode, $today);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Error: Failed to save QR Code in database. " . $stmt->error);
        }
    }
}



// Mengambil semua QR Code
function getAllQRCode() {
    global $conn;

    $query = "SELECT * FROM qr_codes";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $qr_codes = [];
        while ($row = $result->fetch_assoc()) {
            $qr_codes[] = $row;
        }
        return $qr_codes;
    } else {
        return [];
    }
}

// Menghapus QR Code berdasarkan ID
function deleteQRCode($id) {
    function deleteQRCode($id) {
        global $conn;
    
        // Ambil nama file QR Code dari database sebelum dihapus
        $stmt = $conn->prepare("SELECT qr_code_text FROM qr_codes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            die("Error: QR Code tidak ditemukan di database.");
        }
    
        $row = $result->fetch_assoc();
        $qrFileName = $row['qr_code_text'] . '.png';
        $filePath = __DIR__ . '/../../../qrcodes/' . $qrFileName;
    
        // Hapus file dari folder jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    
        // Hapus data dari database
        $stmt = $conn->prepare("DELETE FROM qr_codes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}    
?>