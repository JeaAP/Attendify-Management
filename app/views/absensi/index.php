<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../controllers/absensiController.php';

session_start();

// Ambil semua data absensi
$absensiAll = getAllAbsensiController();

// Pagination
$limit = 50;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalAbsensi = count($absensiAll);
$totalPages = ceil($totalAbsensi / $limit);

$absensiPaginated = array_slice($absensiAll, $offset, $limit);

$visiblePages = 20;
$startPage = max(1, min($page - 1, $totalPages - $visiblePages + 1));
$endPage = min($startPage + $visiblePages - 1, $totalPages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Attendify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">

    <script src="<?= BASE_URL ?>public/assets/js/config.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/filter.js"></script>
    <script>
        sessionStorage.setItem("lastPage", window.location.pathname);
        // Bypass javascript auth
        if (!sessionStorage.getItem("authenticated")) {
            window.location.href = window.CONFIG.BASE_URL + "public/";
        }
    </script>
</head>
<body>
    <!-- Template Sidebar -->
    <?php include_once __DIR__ . "/../templates/sidebar.php" ?>

    <main>
        <h2>Absensi</h2>
        <!-- Search and Action Buttons -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari siswa..." class="form-control mb-3">
        </div>

        <!-- Table for Attendance Data -->
        <div class="card">
            <div class="container p-3 m-0 mw-100">
                <div class="container-head">
                    <div class="row"> 
                        <div class="col-md-auto mt-1">
                            <img src="<?= ASSETS_PATH ?>images/Frame42.png">
                        </div>
                        <div class="col mt-2">
                            <h6>Data Kehadiran Siswa</h6>
                        </div>
                        <div class="col-md-auto">
                            <div class="form-row">
                                <div class="form-group col-md-auto">
                                    <!-- Tombol Refresh -->
                                    <button type="button" class="btn btn-primary" id="refreshButton">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                                <div class="form-group col-md-auto">
                                    <!-- Tombol Reset Filter -->
                                    <button type="button" class="btn btn-warning" id="resetFilterButton">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </div>
                                <div class="form-group col-md-auto">
                                    <!-- Filter Jurusan -->
                                    <select class="custom-select" id="jurusanFilter">
                                        <option value="">Jurusan</option>
                                        <option value="RPL">Rekayasa Perangkat Lunak</option>
                                        <option value="TBS">Tata Busana</option>
                                        <option value="KUL">Kuliner</option>
                                        <option value="PH">Perhotelan</option>
                                        <option value="ULW">Usaha Layanan Wisata</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-auto">
                                <!-- Filter Kelas -->
                                    <select class="custom-select" id="kelasFilter">
                                        <option value="">Kelas</option>
                                        <option value="X PPL 1">X PPL 1</option>
                                        <option value="X PPL 2">X PPL 2</option>    
                                        <option value="X TBS 1">X TBS 1</option>
                                        <option value="X TBS 2">X TBS 2</option>
                                        <option value="X TBS 3">X TBS 3</option>
                                        <option value="X KUL 1">X KUL 1</option>
                                        <option value="X KUL 2">X KUL 2</option>
                                        <option value="X KUL 3">X KUL 3</option>
                                        <option value="X PH 1">X PH 1</option>
                                        <option value="X PH 2">X PH 2</option>
                                        <option value="X PH 3">X PH 3</option>
                                        <option value="X ULW 1">X ULW 1</option>
                                        <option value="XI PPL 1">XI PPL 1</option>
                                        <option value="XI PPL 2">XI PPL 2</option>    
                                        <option value="XI TBS 1">XI TBS 1</option>
                                        <option value="XI TBS 2">XI TBS 2</option>
                                        <option value="XI TBS 3">XI TBS 3</option>
                                        <option value="XI KUL 1">XI KUL 1</option>
                                        <option value="XI KUL 2">XI KUL 2</option>
                                        <option value="XI KUL 3">XI KUL 3</option>
                                        <option value="XI PH 1">XI PH 1</option>
                                        <option value="XI PH 2">XI PH 2</option>
                                        <option value="XI PH 3">XI PH 3</option>
                                        <option value="XI ULW 1">XI ULW 1</option>
                                        <option value="XII PPL 1">XII PPL 1</option>
                                        <option value="XII PPL 2">XII PPL 2</option>    
                                        <option value="XII TBS 1">XII TBS 1</option>
                                        <option value="XII TBS 2">XII TBS 2</option>
                                        <option value="XII TBS 3">XII TBS 3</option>
                                        <option value="XII KUL 1">XII KUL 1</option>
                                        <option value="XII KUL 2">XII KUL 2</option>
                                        <option value="XII KUL 3">XII KUL 3</option>
                                        <option value="XII PH 1">XII PH 1</option>
                                        <option value="XII PH 2">XII PH 2</option>
                                        <option value="XII PH 3">XII PH 3</option>
                                        <option value="XII ULW 1">XII ULW 1</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-0">
                                    <!-- Filter Status -->
                                    <select class="custom-select" id="statusFilter">
                                        <option value="">Status</option>
                                        <option value="Tepat Waktu">Tepat Waktu</option>
                                        <option value="Terlambat">Terlambat</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-0">
                                    <!-- Filter Mood -->
                                    <select class="custom-select" id="moodFilter">
                                        <option value="">Mood</option>
                                        <option value="Happy">Happy</option>
                                        <option value="Sad">Sad</option>
                                        <option value="Angry">Angry</option>
                                        <option value="Tired">Tired</option>
                                        <option value="Excited">Excited</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-0">
                                    <!-- Filter Tanggal -->
                                    <input type="date" class="form-control" id="filterDate" oninput="filterByDate()" value="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <td class="text-secondary">Nama</td>
                                <td class="text-secondary">Kelas</td>
                                <td class="text-secondary">NISN</td>
                                <td class="text-secondary">Tanggal</td>
                                <td class="text-secondary">Waktu</td>
                                <td class="text-secondary">Status</td>
                                <td class="text-secondary">Mood</td>
                                <td class="text-secondary"></td>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            <?php if (!empty($absensiPaginated)): ?>
                                <?php foreach ($absensiPaginated as $absensi): 
                                    $tanggal = date('d-m-Y', strtotime($absensi['waktu']));
                                    $waktu = date('H:i', strtotime($absensi['waktu']));
                                    $statusClass = $absensi['keterangan'] == 'Tepat Waktu' ? 'badge rounded-pill bg-success' : 'badge rounded-pill bg-danger';
                                    $moodColor = '';
                                    if (in_array($absensi['mood'], ['Angry', 'Tired', 'Sad'])) $moodColor = 'text-danger';
                                ?>
                                <tr class="text-center">
                                    <td class="text-start"><?= $absensi['nama'] ?></td>
                                    <td><?= $absensi['kelas'] ?></td>
                                    <td><?= $absensi['nisn'] ?></td>
                                    <td><?= $tanggal ?></td>
                                    <td><?= $waktu ?></td>
                                    <td><span class="<?= $statusClass ?>"><?= $absensi['keterangan'] ?></span></td>
                                    <td><span class="<?= $moodColor ?>"><?= $absensi['mood'] ?></span></td>
                                    <td><a href="#">Detail</a></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Data Kosong</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-container text-center mt-3">
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </main>
</body>
</html>
