<?php
include("../config/db.php");

$id = $_POST['id'];

if (isset($_POST['used'])) {
    mysqli_query($conn,
        "UPDATE ngo_storage SET status='used' WHERE id=$id"
    );
}

if (isset($_POST['waste'])) {
    mysqli_query($conn,
        "UPDATE ngo_storage SET status='waste' WHERE id=$id"
    );
}

header("Location: storage.php");
