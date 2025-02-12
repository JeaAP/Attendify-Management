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
    $folderPath = BASE_URL . '../qrcodes/';
    
    // Cek apakah QR code untuk hari ini sudah ada di database
    $stmt = $conn->prepare("SELECT * FROM qr_codes WHERE qr_code_date = ?");
    $stmt->bind_param("s", $today); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Mengecek apakah QR code untuk hari ini sudah ada
    if ($result->num_rows > 0) {
        echo "QR Code for today already exists!";
        return false;  // Mengembalikan false jika QR code sudah ada
    } else {
        $uniqueCode = $today . '-' . md5(uniqid());
        $filePath = $folderPath . $uniqueCode . '.png';
        
        // Memastikan folder qrcodes ada dan bisa ditulis
        if (!is_dir($folderPath) || !is_writable($folderPath)) {
            echo "QR code folder does not exist.";
            return false;  // Mengembalikan false jika folder tidak ada
        }

        // Generate QR Code
        QRcode::png($uniqueCode, $filePath, QR_ECLEVEL_L, 10);
        
        // Simpan QR Code ke database
        $stmt = $conn->prepare("INSERT INTO qr_codes (qr_code_text, qr_code_date) VALUES (?, ?)");
        $stmt->bind_param("ss", $uniqueCode, $today);
        
        if ($stmt->execute()) {
            echo "QR Code created and saved successfully!";
            return true;  // Mengembalikan true jika QR code berhasil disimpan
        } else {
            echo "Failed to save QR Code: " . $stmt->error;
            return false;  // Mengembalikan false jika gagal menyimpan QR code
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
    global $conn;

    $stmt = $conn->prepare("DELETE FROM qr_codes WHERE id =?");
    $stmt->bind_param("i", $id);

    return $stmt->execute();
}
?>