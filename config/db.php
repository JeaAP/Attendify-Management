<?php
if(!defined('DB_HOST')) define('DB_HOST', 'localhost');
if(!defined('DB_USER')) define('DB_USER', 'bacs5153');
if(!defined('DB_PASS')) define('DB_PASS', 'k1QwiSmarvUx27');
if(!defined('DB_NAME')) define('DB_NAME', 'bacs5153_attendify');
//DB_USER = 'bacs5153'
//DB_PASS = 'k1QwiSmarvUx27'

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>