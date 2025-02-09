<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/absensiModel.php';

// Mengambil semua data absensi
function getAllAbsensiController() {
    $result = getAllAbsensi();
    return $result;
}

// Mengambil absensi berdasarkan hari ini
function getTodayAbsensiController() {
    $result = getTodayAbsensi();
    return $result;
}

// Mengambil jumlah kehadiran untuk dashboard
function getKehadiranDashboardController() {
    return getKehadiranDashboardData();
}

// Mengambil jumlah mood siswa untuk dashboard
function getDashboardMoodController() {
    return getDashboardMoodData();
}

// Mengambil top 20 siswa dengan keterlambatan terbanyak
function getTop20AbsensiController() {
    $result = getTop20Absensi();
    return $result;
}

// Mengambil rata-rata kehadiran per tahun ajaran
function getRataRataKehadiranController() {
    $result = getRataRataKehadiran();
    return $result;
}
?>
