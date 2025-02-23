<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../routes/absensiRoutes.php';

session_start();

// Ambil semua data absensi
// $absensiAll = getAllAbsensiController($limit, $page);
$filterAbsensi = filterAbsensiController( $kelas, $jurusan, $mood, $tanggal, $limit, $page);
$kelas = getKelasController();
$jurusan = getJurusanController();

$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$jurusan = isset($_GET['jurusan']) ? $_GET['jurusan'] : '';
$mood = isset($_GET['mood']) ? $_GET['mood'] : '';
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page'])? (int)$_GET['page'] : 1;
$totalPages = ceil($totalAbsensi / $limit);

$maxPages = 10;
if ($totalPages > $maxPages) {
    $startPage = max(1, $page - floor($maxPages / 2));
    $endPage = min($totalPages, $startPage + $maxPages - 1);
} else {
    $startPage = 1;
    $endPage = $totalPages;
}

$pages = range($startPage, $endPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Attendify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    
    <link href="<?= BASE_URL ?>public/assets/styles/style.css?v=<?= time() ?>" rel="stylesheet">

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
                            <select class="custom-select" id="limitSelect">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
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
                                        <?php foreach ($jurusan as $j) : ?>
                                            <option value="<?= $j['kodeJurusan'] ?>"><?= $j['namaJurusan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-auto">
                                <!-- Filter Kelas -->
                                    <select class="custom-select" id="kelasFilter">
                                        <option value="">Kelas</option>
                                        <?php foreach ($kelas as $k) :?>
                                            <option value="<?= $k['kelas']?>"><?= $k['kelas']?></option>
                                        <?php endforeach;?>
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
                                    <input type="date" class="form-control" id="filterDate" oninput="filterByDate()" ">
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
                            <?php if (!empty($absensiAll)): ?>
                                <?php foreach ($absensiAll as $absensi): 
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
                                    <td><a href="#" class="detail-link" data-perasaan="<?= htmlspecialchars($absensi['perasaan']) ?>">Detail</a></td>
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

                <!-- Pagination -->
                <div class="pagination-container">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>" id="prevButton">
                                <a class="page-link" onclick="prevPage()" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <?php if ($startPage > 1): ?>
                                <li class="page-item"><a class="page-link" href="?page=1&limit=<?= $limit ?>">1</a></li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php foreach ($pages as $i): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                                </li>
                            <?php endforeach; ?>
                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>&limit=<?= $limit ?>"><?= $totalPages ?></a></li>
                            <?php endif; ?>

                            <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>" id="nextButton">
                                <a class="page-link" onclick="nextPage()" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="perasaanContent">Loading...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Detail Modal
        document.querySelectorAll('.detail-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                
                var perasaan = e.target.getAttribute('data-perasaan');
                
                document.getElementById('perasaanContent').textContent = perasaan;
                
                var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
                    // limit page url
        window.onload = function () {
            var urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('limit') && !urlParams.has('page')) {
                urlParams.set('limit', '10');
                urlParams.set('page', '1');
                window.history.replaceState(null, '', window.location.pathname + '?' + urlParams.toString());
            }
        };

        // limit
        document.getElementById('limitSelect').addEventListener('change', function () {
            var limit = this.value;
            var currentUrl = new URL(window.location.href);
            
            updatePageLimit(currentUrl.searchParams.get('page'), limit);
        });

        // pagination
        document.querySelectorAll('.page-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var page = this.textContent;
                var currentUrl = new URL(window.location.href);
                
                updatePageLimit(page, currentUrl.searchParams.get('limit'));
            });
        })

        function updatePageLimit(page, limit) {
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('page', page);
            currentUrl.searchParams.set('limit', limit);
            window.history.replaceState(null, '', currentUrl.toString());
        };
        });
    </script>
</body>
</html>
