<?php
$host = "localhost";
$user = "root";
$pass = "Shakib123@";
$db   = "sharemeal_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed");
}
?>
