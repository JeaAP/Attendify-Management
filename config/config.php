<?php
define('ROOT_PATH', __DIR__ . '/../');  // Menentukan root aplikasi

define('BASE_URL', 'https://backend24.site/Rian/XI/attendify/attendify_management/');
// define('BASE_URL', '/Attendify-Management/');
// gunakan -> https://backend24.site/Rian/XI/attendify/Web_Manajemen/
define('BASE_PATH', realpath(__DIR__ . '/../') . '/');


// Ini bisa berguna jika Anda ingin mengakses folder lain seperti assets atau uploads
define('ASSETS_PATH', BASE_URL . '/public/assets/');
define('VIEWS_PATH', BASE_URL . '/app/views/');
define('TEMPLATES_PATH', BASE_URL . '/app/views/templates/');


?>
