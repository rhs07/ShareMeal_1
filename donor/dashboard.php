<?php
session_start();
if ($_SESSION['role'] != 'donor') {
    header("Location: ../auth/login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h2>Donor Dashboard</h2>
</header>

<div class="card">
    <a href="donate_food.php"><button>Donate Food</button></a>
</div>

</body>
</html>
