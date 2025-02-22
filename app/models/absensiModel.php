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

    $query = "SELECT * FROM absensi ORDER BY waktu DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC); // Langsung mengembalikan array
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
                SUM(CASE WHEN keterangan IN ('Tepat Waktu', 'Terlambat') THEN 1 ELSE 0 END) AS total_hadir,
                SUM(CASE WHEN keterangan = 'Tepat Waktu' THEN 1 ELSE 0 END) AS total_tepat_waktu,
                SUM(CASE WHEN keterangan = 'Terlambat' THEN 1 ELSE 0 END) AS total_terlambat
            FROM absensi
            WHERE DATE(waktu) = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $result['total_belum_absen'] = $total_Siswa - $result['total_hadir'];
    
    return $result;
}


// Mengambil jumlah data absensi untuk dashboard sesuai mood (langsung array)
function getDashboardMoodData() {
    global $conn;
    $date = date('Y-m-d');

    $query = "SELECT
                SUM(CASE WHEN mood = 'Angry' THEN 1 ELSE 0 END) AS total_mood_angry,
                SUM(CASE WHEN mood = 'Tired' THEN 1 ELSE 0 END) AS total_mood_tired,
                SUM(CASE WHEN mood = 'Sad' THEN 1 ELSE 0 END) AS total_mood_sad,
                SUM(CASE WHEN mood = 'Happy' THEN 1 ELSE 0 END) AS total_mood_happy,
                SUM(CASE WHEN mood = 'Excited' THEN 1 ELSE 0 END) AS total_mood_excited
            FROM absensi
            WHERE DATE(waktu) = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // Langsung array
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
