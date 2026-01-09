<?php
session_start();
include("../config/db.php");

$ngo_id = $_SESSION['user_id'];

if (isset($_POST['request'])) {
    $food = $_POST['food_type'];
    $qty  = $_POST['quantity'];
    $date = $_POST['needed_by'];

    mysqli_query($conn,
        "INSERT INTO food_requests (ngo_id, food_type, quantity, needed_by)
         VALUES ($ngo_id, '$food', $qty, '$date')"
    );

    echo "Food request submitted successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Food</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="card">
    <h3>Request Food</h3>

    <form method="POST">
        <input type="text" name="food_type" placeholder="Food Type" required><br><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br><br>
        <input type="date" name="needed_by" required><br><br>
        <button name="request">Submit Request</button>
    </form>
</div>

</body>
</html>
