<?php
include("../config/db.php");

if (isset($_POST['picked'])) {
    $id = $_POST['donation_id'];
    mysqli_query($conn, "UPDATE donations SET status='picked' WHERE id=$id");
}

if (isset($_POST['delivered'])) {
    $id = $_POST['donation_id'];
    mysqli_query($conn, "UPDATE donations SET status='delivered' WHERE id=$id");
}

header("Location: assignments.php");
