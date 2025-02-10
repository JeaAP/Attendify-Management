<?php
// Menggunakan __DIR__ untuk mendapatkan direktori saat ini
define('ROOT_PATH', __DIR__ . '/../');  // Menentukan root aplikasi

// Anda juga bisa mendefinisikan URL dasar aplikasi jika diperlukan
define('BASE_URL', 'https://backend24.site/Rian/XI/attendify/attendify_management/');
// gunakan -> https://backend24.site/Rian/XI/attendify/Web_Manajemen/

// Tentukan path dasar proyek (root proyek)
define('BASE_PATH', realpath(__DIR__ . '/../') . '/');


// Ini bisa berguna jika Anda ingin mengakses folder lain seperti assets atau uploads
define('ASSETS_PATH', BASE_URL . 'public/assets/');
define('VIEWS_PATH', BASE_URL . 'app/views/');
define('TEMPLATES_PATH', BASE_URL . 'app/views/templates/');


?>
