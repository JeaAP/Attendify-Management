<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../routes/absensiRoutes.php';

session_start();

// Ambil semua data absensi
$absensiAll = getAllAbsensiController();
$kelas = getKelasController();
$jurusan = getJurusanController();
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
        document.querySelectorAll('.detail-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                
                var perasaan = e.target.getAttribute('data-perasaan');
                
                document.getElementById('perasaanContent').textContent = perasaan;
                
                var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
            });
        });
    </script>
</body>
</html>
