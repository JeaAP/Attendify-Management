<?php
if(!defined('DB_HOST')) define('DB_HOST', 'localhost');
if(!defined('DB_USER')) define('DB_USER', 'root');
if(!defined('DB_PASS')) define('DB_PASS', '');
if(!defined('DB_NAME')) define('DB_NAME', 'absensi');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>