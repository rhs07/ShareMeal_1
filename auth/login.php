<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($pass, $user['password'])) {

        if ($user['status'] != 'approved') {
            echo "Account pending admin approval.";
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../" . $user['role'] . "/dashboard.php");
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | ShareMeal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="card">
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button name="login">Login</button>
    </form>
</div>

</body>
</html>
