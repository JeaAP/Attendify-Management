<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../controllers/absensiController.php';

session_start();
$low_attendance_students = getTopLow10AbsensiController();
$Top_attendance_students = getTopHigh10AbsensiController();
$student_attendance = getKehadiranDashboardData();
$student_mood = getDashboardMoodData();
$average_student_attendance = getRataRataKehadiran();

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendify Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link href="<?= BASE_URL ?>public/assets/styles/style.css?v=<?= time() ?>" rel="stylesheet">

    <script src="/Attendify-Management/public/assets/js/config.js"></script>
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
    <?php include_once __DIR__ . "/templates/sidebar.php" ?>

<main class="col px-4">
    
    <!-- Dashboard Total Hadir, Total Terlambat, dan Total Tidak Absen -->
    <p>Dashboard</p>
    <div class="dashboard-summary row">
        <div class="col-md-4 summary-card">
            <div class="card text-left">
                <div class="card-bodyhadir" onclick="window.location.href='absensi/index.php'">
                    <h4>Total Hadir</h4>
                    <h2 class="text-success small-number"><?= $student_attendance['total_hadir']; ?> Siswa </h2> 
                    <p>Dari 1.214 Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 summary-card">
            <div class="card text-left">
                <div class="card-bodyterlambat" onclick="window.location.href='absensi/index.php'">
                    <h4>Total Terlambat</h4>
                        <h2 class="text-danger small-number"><?= $student_attendance['total_terlambat']; ?> Siswa</h2>
                        <p>Dari 1.214 Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 summary-card">
            <div class="card text-left">
                <div class="card-bodytotal">
                    <h4>Total Belum Absen</h4>
                    <h2 class="text-danger small-number"><?= $student_attendance['total_belum_absen']; ?> Siswa</h2>
                    <p>Dari 1.214 Siswa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Mood -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="col-md-12 summary-card">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4>Review Mood</h4>
                                <a>Presentase rata-rata mood yang sering dirasakan siswa</a>
                                <div class="mood-summary">
                                    <div class="mood-item">
                                    <a href="ReviewMood.php?mood=Angry"><img src="<?= ASSETS_PATH ?>images/PNGAngry.png" alt="Angry" class="mood-icon"> </a>
                                        <p>Angry: <?= $student_mood['total_mood_angry']; ?>%</p>
                                    </div>
                                    <div class="mood-item">
                                    <a href="ReviewMood.php?mood=Tired"><img src="<?= ASSETS_PATH ?>images/PNGTired.png" alt="Tired" class="mood-icon"> </a>
                                        <p>Tired: <?= $student_mood['total_mood_tired']; ?>%</p>
                                    </div>
                                    <div class="mood-item">
                                    <a href="ReviewMood.php?mood=Sad"><img src="<?= ASSETS_PATH ?>images/PNGSad.png" alt="Sad" class="mood-icon"> </a>
                                        <p>Sad: <?= $student_mood['total_mood_tired']; ?>%</p>
                                    </div>
                                    <div class="mood-item">
                                    <a href="ReviewMood.php?mood=Happy"><img src="<?= ASSETS_PATH ?>images/PNGHappy.png" alt="Happy" class="mood-icon"> </a>
                                        <p>Happy: <?= $student_mood['total_mood_happy']; ?>%</p>
                                    </div>
                                    <div class="mood-item">
                                        <a href="ReviewMood.php?mood=Excited"><img src="<?= ASSETS_PATH ?>images/PNGExcited.png" alt="Another" class="mood-icon" ></a>
                                        <p>Excited: <?= $student_mood['total_mood_excited']; ?>%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Kehadiran Terbaik -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <a class="nav-link">
                        <img src="<?= ASSETS_PATH ?>images/PNGChamp.png" alt="Champ Icon" class="nav-icon"> 
                        Rangking Kehadiran Terbaik
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Keterangan</th>
                                    <th>Total Hadir</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                    foreach ($Top_attendance_students as $index => $student):
                                        if ($index === 0) {
                                            $ranking = ASSETS_PATH.'images/PNGChamp1.png'; 
                                            $ranking_display = '<img src="'.$ranking.'" alt="piala">';
                                        } elseif ($index === 1) {
                                            $ranking = ASSETS_PATH.'images/PNGChamp2.png'; 
                                            $ranking_display = '<img src="'.$ranking.'" alt="piala">';
                                        } elseif ($index === 2) {
                                            $ranking = ASSETS_PATH.'images/PNGChamp3.png'; 
                                            $ranking_display = '<img src="'.$ranking.'" alt="piala">';
                                        } else {
                                            $ranking_display = $index + 1;  
                                        }
                                ?>
                                    <tr>        
                                        <td><?=$ranking_display;?></td>
                                        <td><?php echo htmlspecialchars($student['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($student['kelas']); ?></td>
                                        <td><?php echo htmlspecialchars($student['keterangan']); ?></td>
                                        <td><?php echo htmlspecialchars($student['total_tepat_waktu']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Rata-Rata Kehadiran Selama 1 Tahun -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a class="nav-link">
                        <img src="<?= ASSETS_PATH ?>images/PNGAverange.png">
                        Rata-rata Kehadiran Siswa 1 Tahun Pembelajaran <br><div class="low-attendance-list">
                    </a>
                    <div class="row mt-4 attendance-cards">
                        <div class="col-md-4">
                            <div class="card hadir shadow-sm">
                                <div class="card-body">
                                    <h6>Hadir</h6>
                                    <p><strong><?= number_format($average_student_attendance['rata_rata_hadir'], 1); ?>% <span class="up">⬆</span></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card terlambat shadow-sm">
                                <div class="card-body">
                                    <h6>Terlambat</h6>
                                    <p><strong><?= number_format($average_student_attendance['rata_rata_terlambat'], 1); ?>% <span class="up">⬆</span></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Kehadiran Terendah -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="nav-link">
                    <span class="down">⬇</span> Data Siswa dengan Tingkat Kehadiran Rendah
                </h5>
                <div class="low-attendance-list">
                        <div class="attendance-row">
                                    <div class="attendance-col">No</div>
                                    <div class="attendance-col">Nama</div>
                                    <div class="attendance-col">Kelas</div>
                                    <div class="attendance-col">Keterangan</div>
                                    <div class="attendance-col">Total Terlambat</div>
                        </div>
                    <?php foreach ($low_attendance_students as $index => $student): ?>
                    <div class="attendance-row">
                        <div class="attendance-col"><?php echo $index + 1; ?></div>
                        <div class="attendance-col"><?php echo htmlspecialchars($student['nama']); ?></div>
                        <div class="attendance-col"><?php echo htmlspecialchars($student['kelas']); ?></div>
                        <div class="attendance-col"><?php echo htmlspecialchars( $student['keterangan']); ?></div>
                        <div class="attendance-col"><?php echo $student['total_terlambat']; ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
