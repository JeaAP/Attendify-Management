<?php
require_once __DIR__ . '/../../config/config.php';
require_once  __DIR__ . '/../../config/db.php';

// Fungsi untuk membersihkan input (Sanitasi XSS)
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Mengambil semua absensi (langsung array)
function getAllAbsensi() {
    global $conn;

    // $offset = ($page - 1) * $limit;
    // LIMIT $limit OFFSET $offset
    $query = "SELECT * FROM absensi ORDER BY waktu DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC); // Langsung mengembalikan array
}

// Mengambil jumlah semua absensi
function getTotalAbsensi() {
    global $conn;

    $sql = "SELECT COUNT(*) AS total FROM absensi"; 
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Filter
function filterAbsensi($kelas, $jurusan, $status, $mood, $tanggal, $limit, $page) {
    global $conn;

    $offset = ($page - 1) * $limit;
    
    $query = "SELECT * FROM absensi";
    $conditions = [];
    
    if (!empty($kelas)) {
        $conditions[] = "kelas = ?";
    }
    if (!empty($jurusan)) {
        $conditions[] = "jurusan = ?";
    }
    if(!empty($status)) {
        $conditions[] = "keterangan = ?"; // Changed from status to keterangan based on table structure
    }
    if (!empty($mood)) {
        $conditions[] = "mood = ?";
    }
    if (!empty($tanggal)) {
        $conditions[] = "DATE(waktu) = ?";
    }
    
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $query .= " ORDER BY waktu DESC LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    if ($stmt) {
        $types = str_repeat('s', count($conditions)) . 'ii'; // string params + 2 integers for limit/offset
        $params = [];
        
        if (!empty($kelas)) $params[] = $kelas;
        if (!empty($jurusan)) $params[] = $jurusan;
        if (!empty($status)) $params[] = $status;
        if (!empty($mood)) $params[] = $mood;
        if (!empty($tanggal)) $params[] = $tanggal;
        
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    return [];
}

// Mengambil absensi berdasarkan hari ini (langsung array)
function getTodayAbsensi() {
    global $conn;
    $today = date('Y-m-d');

    $query = "SELECT * FROM absensi WHERE DATE(waktu) = ? ORDER BY waktu DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC); // Langsung array
}

// Mengambil jumlah data absensi untuk dashboard (langsung array)
function getKehadiranDashboardData() {
    global $conn;
    $date = date('Y-m-d');
    $total_Siswa = 1214;

    $query = "SELECT 
                COALESCE(SUM(CASE WHEN keterangan IN ('Tepat Waktu', 'Terlambat') THEN 1 ELSE 0 END), 0) AS total_hadir,
                COALESCE(SUM(CASE WHEN keterangan = 'Tepat Waktu' THEN 1 ELSE 0 END), 0) AS total_tepat_waktu,
                COALESCE(SUM(CASE WHEN keterangan = 'Terlambat' THEN 1 ELSE 0 END), 0) AS total_terlambat
            FROM absensi
            WHERE DATE(waktu) = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        $result = [
            'total_hadir' => 0,
            'total_tepat_waktu' => 0,
            'total_terlambat' => 0
        ];
    }

    $result['total_belum_absen'] = $total_Siswa - $result['total_hadir'];
    
    return $result;
}


// Mengambil jumlah data absensi untuk dashboard sesuai mood (langsung array)
function getDashboardMoodData() {
    global $conn;
    $date = date('Y-m-d');

    $query = "SELECT
                COALESCE(SUM(CASE WHEN mood = 'Angry' THEN 1 ELSE 0 END), 0) AS total_mood_angry,
                COALESCE(SUM(CASE WHEN mood = 'Tired' THEN 1 ELSE 0 END), 0) AS total_mood_tired,
                COALESCE(SUM(CASE WHEN mood = 'Sad' THEN 1 ELSE 0 END), 0) AS total_mood_sad,
                COALESCE(SUM(CASE WHEN mood = 'Happy' THEN 1 ELSE 0 END), 0) AS total_mood_happy,
                COALESCE(SUM(CASE WHEN mood = 'Excited' THEN 1 ELSE 0 END), 0) AS total_mood_excited
            FROM absensi
            WHERE DATE(waktu) = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc(); // Langsung array
    
    if(!$result) {
        $result = [
            'total_mood_angry' => 0,
            'total_mood_tired' => 0,
            'total_mood_sad' => 0,
            'total_mood_happy' => 0,
            'total_mood_excited' => 0
        ];
    }

    return $result;
}

// Mengambil absensi top 10 siswa dengan tingkat kehadiran rendah atau terlambat (langsung array)
function getLow10Absensi() {
    global $conn;

    $query = "SELECT
                nama,
                kelas,
                keterangan,
                COUNT(*) AS total_terlambat
            FROM absensi
            WHERE keterangan = 'Terlambat'
            GROUP BY nama, kelas, keterangan
            ORDER BY total_terlambat DESC
            LIMIT 10";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC); // Langsung array
}

// Mengambil absensi top 10 siswa dengan tingkat kehadiran tertinggi atau tepat waktu (langsung array)
function getTop10Absensi() {
    global $conn;

    $query = "SELECT
                nama,
                kelas,
                keterangan,
                COUNT(*) AS total_tepat_waktu
            FROM absensi
            WHERE keterangan = 'Tepat Waktu'
            GROUP BY nama, kelas, keterangan
            ORDER BY total_tepat_waktu DESC
            LIMIT 10";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC); // Langsung array
}


// Data rata-rata persentase kehadiran siswa setiap tahun pembelajaran (langsung array)
function getRataRataKehadiran() {
    global $conn;

    $query = "SELECT 
                tahun_pembelajaran,
                ROUND(AVG(persen_hadir), 2) AS rata_rata_hadir,
                ROUND(AVG(persen_tepat_waktu), 2) AS rata_rata_tepat_waktu,
                ROUND(AVG(persen_terlambat), 2) AS rata_rata_terlambat
            FROM (
                SELECT 
                    nisn,
                    YEAR(waktu) AS tahun_pembelajaran,
                    COUNT(*) AS total_hadir,
                    SUM(CASE WHEN keterangan = 'Tepat Waktu' THEN 1 ELSE 0 END) AS total_tepat_waktu,
                    SUM(CASE WHEN keterangan = 'Terlambat' THEN 1 ELSE 0 END) AS total_terlambat,
                    (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM absensi WHERE YEAR(waktu) = YEAR(waktu))) AS persen_hadir,
                    (SUM(CASE WHEN keterangan = 'Tepat Waktu' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) AS persen_tepat_waktu,
                    (SUM(CASE WHEN keterangan = 'Terlambat' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) AS persen_terlambat
                FROM absensi 
                WHERE keterangan IN ('Tepat Waktu', 'Terlambat')
                GROUP BY nisn, YEAR(waktu)
            ) AS subquery
            GROUP BY tahun_pembelajaran
            ORDER BY tahun_pembelajaran";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

// Tabel Jurusan
function getJurusan() {
    global $conn;

    $query = "SELECT * FROM jurusan";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Tabel Kelas
function getKelas() {
    global $conn;

    $query = "SELECT * FROM kelas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
