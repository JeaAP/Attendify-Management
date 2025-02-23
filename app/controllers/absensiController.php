<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/absensiModel.php';

// Mengambil semua data absensi
function getAllAbsensiController($limit, $page) {
    $result = getAllAbsensi($limit, $page);
    return $result;
}

// Filter absensi
function filterAbsensiController($kelas, $jurusan, $mood, $tanggal, $limit, $page) {
    $result = filterAbsensi($kelas, $jurusan, $mood, $tanggal, $limit, $page);
    return $result;
}

// Mengambil jumlah semua absensi
function getTotalAbsensiController() {
    $result = getTotalAbsensi();
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

// Mengambil top 10 siswa dengan keterlambatan terbanyak
function getTopLow10AbsensiController() {
    $result = getLow10Absensi();
    return $result;
}

// Mengambil top 10 siswa dengan tingkat kehadiran tertinggi
function getTopHigh10AbsensiController() {
    $result = getTop10Absensi();
    return $result;
}

// Mengambil rata-rata kehadiran per tahun ajaran
function getRataRataKehadiranController() {
    $result = getRataRataKehadiran();
    return $result;
}
// Controller untuk jurusan
function getJurusanController() {
    $result = getJurusan();
    return $result;
}

// Controller untuk kelas
function getKelasController() {
    $result = getKelas();
    return $result;
}
?>
