<?php
require_once __DIR__ . '/../../config/config.php';
session_start();

// Logout user
function logoutController() {
    session_destroy();
    header('Location: '. BASE_URL. 'public/');
    exit();
}
?>