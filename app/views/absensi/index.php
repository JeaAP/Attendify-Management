<?php
require_once __DIR__ . '/../../../config/config.php';

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Attendify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">
</head>
<body>
    <!-- Template Sidebar -->
    <?php include_once __DIR__ . "/../templates/sidebar.php" ?>

    <main>
        <h2>Absensi</h2>
        <!-- Search and Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <input type="text" class="form-control w-25" placeholder="Cari siswa..." id="searchInput">
        </div>

        <!-- Table for Attendance Data -->
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Absen</th>
                        <th>NISN</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Mood</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this row for each attendance entry -->
                    <tr>
                        <td>Ananda Keizha Oktavian</td>
                        <td>XI PPL 2</td>
                        <td>7</td>
                        <td>348769854</td>
                        <td>17-01-2025</td>
                        <td>08:15</td>
                        <td><span class="badge bg-success">Masuk</span></td>
                        <td><span class="badge bg-warning">Happy</span></td>
                        <td><button class="btn btn-info btn-sm">Detail</button></td>
                    </tr>
                    <!-- End repeat -->
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
