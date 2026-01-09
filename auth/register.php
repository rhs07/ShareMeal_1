<?php
include("../config/db.php");

if (isset($_POST['register'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role  = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$pass', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful. Wait for admin approval.";
    } else {
        echo "Error: Email already exists.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | ShareMeal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="card">
    <h2>Create Account</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="donor">Donor</option>
            <option value="volunteer">Volunteer</option>
            <option value="ngo">NGO</option>
        </select><br><br>

        <button name="register">Register</button>
    </form>
</div>

</body>
</html>
