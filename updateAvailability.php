<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['roomId'];
    $status = $_POST['status'];


    $sql = "UPDATE rooms SET available = '$status' WHERE room_id = '$roomId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'Availability updated successfully';
    } else {
        echo 'Error updating availability';
    }
}
