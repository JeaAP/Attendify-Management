<?php
require_once __DIR__ . '/../../../config/config.php';

session_start();
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link href="<?= BASE_URL ?>public/assets/styles/style.css" rel="stylesheet">

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
    <?php include_once __DIR__ . "/../templates/sidebar.php" ?>

    <main>
        <h2>About</h2>
    </main>
</body>
</html>
