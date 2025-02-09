<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../controllers/absensiController.php';

session_start();
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

    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">
</head>
<body>
    <!-- Template Sidebar -->
    <?php include_once __DIR__ . "/templates/sidebar.php" ?>

    <main class="col px-4">
        <p>Dashboard</p>
      <div class="dashboard-summary row">
          <div class="col-md-4 summary-card">
              <div class="card text-left">
                  <div class="card-bodyhadir" onclick="window.location.href='Absensi.php'">
                      <h4>Total Hadir</h4>
                      <h2 class="text-success small-number"><?= $attendancee['total_hadir']; ?> Siswa </h2>
                  </div>
              </div>
          </div>
          <div class="col-md-4 summary-card">
              <div class="card text-left">
                  <div class="card-bodyterlambat" onclick="window.location.href='Tardy.php'">
                      <h4>Total Terlambat</h4>
                      <h2 class="text-danger small-number"><?= $attendancee['total_terlambat']; ?> Siswa</h2>
                  </div>
              </div>
          </div>
          <div class="col-md-4 summary-card">
              <div class="card text-left">
                  <div class="card-bodytotal">
                      <h4>Total Siswa</h4>
                      <h2 class="text-danger small-number"><??> Siswa</h2>
                  </div>
              </div>
          </div>
      </div>

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
                                <a href="ReviewMood.php?mood=Angry"><img src="PNGAngry.png" alt="Angry" class="mood-icon"> </a>
                                    <p>Angry: <?= $mood_review['Angry']; ?>%</p>
                                </div>
                                <div class="mood-item">
                                <a href="ReviewMood.php?mood=Tired"><img src="PNGTired.png" alt="Tired" class="mood-icon"> </a>
                                    <p>Tired: <?= $mood_review['Tired']; ?>%</p>
                                </div>
                                <div class="mood-item">
                                <a href="ReviewMood.php?mood=Sad"><img src="PNGSad.png" alt="Sad" class="mood-icon"> </a>
                                    <p>Sad: <?= $mood_review['Sad']; ?>%</p>
                                </div>
                                <div class="mood-item">
                                <a href="ReviewMood.php?mood=Happy"><img src="PNGHappy.png" alt="Happy" class="mood-icon"> </a>
                                    <p>Happy: <?= $mood_review['Happy']; ?>%</p>
                                </div>
                                <div class="mood-item">
                                    <a href="ReviewMood.php?mood=Excited"><img src="PNGAnother.png" alt="Another" class="mood-icon" ></a>
                                    <p>Excited: <?= $mood_review['Excited']; ?>%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <a class="nav-link">
                    <img src="PNGChamp.png" alt="Champ Icon" class="nav-icon">
                    Rangking Kehadiran Terbaik
                </a>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Total Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($top_students as $index => $student):
                                // Menentukan nomor urut (1 sampai 3 diubah dengan ikon piala)
                                if ($index === 0) {
                                    $ranking = '<img src="PNGChamp1.png" alt="Piala 1" class="icon-piala">'; // Piala untuk peringkat 1
                                } elseif ($index === 1) {
                                    $ranking = '<img src="PNGChamp2.png" alt="Piala 2" class="icon-piala">'; // Piala untuk peringkat 2
                                } elseif ($index === 2) {
                                    $ranking = '<img src="PNGChamp3.png" alt="Piala 3" class="icon-piala">'; // Piala untuk peringkat 3
                                } else {
                                    $ranking = $index + 1; // Nomor urut untuk siswa setelah peringkat 3
                                }
                            ?>
                                <tr>
                                    <td><?php echo $ranking; ?></td>
                                    <td><?php echo htmlspecialchars($student['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($student['kelas']); ?></td>
                                    <td><?php echo htmlspecialchars($student['top_students']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <a class="nav-link">
                    <img src="PNGAverange.png" alt="Kehadiran Icon" class="nav-icon">
                    Rata-rata Kehadiran Siswa 1 Tahun Pembelajaran <br><div class="low-attendance-list">
                </a>
                <div class="row mt-4 attendance-cards">
                    <div class="col-md-4">
                        <div class="card hadir shadow-sm">
                          <div class="card-body">
                                <h6>Hadir</h6>
                                <p><strong><?= number_format($attendancee['hadir_percentage'], 1); ?>% <span class="up">⬆</span></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card terlambat shadow-sm">
                          <div class="card-body">
                                <h6>Terlambat</h6>
                                <p><strong><?= number_format($attendancee['terlambat_percentage'], 1); ?>% <span class="up">⬆</span></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
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
                                  <div class="attendance-col">Total Terlambat</div>
                      </div>
                      <?php foreach ($low_attendance_students as $index => $student): ?>
                        <div class="attendance-row">
                            <div class="attendance-col"><?php echo $index + 1; ?></div>
                            <div class="attendance-col"><?php echo htmlspecialchars($student['nama']); ?></div>
                            <div class="attendance-col"><?php echo htmlspecialchars($student['kelas']); ?></div>
                            <div class="attendance-col"><?php echo htmlspecialchars($student['terlambat_count']); ?></div>
                        </div>
                    <?php endforeach; ?>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </main>
</body>
</html>
