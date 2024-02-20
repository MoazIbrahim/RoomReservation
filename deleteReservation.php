<?php
session_start();

$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $reservationId = $_POST['id'];


    $sql = "DELETE FROM reservations WHERE id = '$reservationId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        header("Location: myReservations.php");
        exit;
    } else {

        echo "Delete failed: " . mysqli_error($conn);
    }
}
