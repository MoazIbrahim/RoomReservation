<?php
session_start();


if (isset($_SESSION['userType'])) {

    if (isset($_SESSION['userFavs'])) {
        $userFavs = $_SESSION['userFavs'];
    } else {

        $userFavs = '';
    }
    $roomId = $_POST['roomId'];
    $isFavorite = strpos($userFavs, $roomId) !== false;


    if ($isFavorite) {

        $userFavs = str_replace($roomId . ',', '', $userFavs);
        $message = 'Room removed from favorites.';
    } else {

        $userFavs .= $roomId . ',';
        $message = 'Room added to favorites.';
    }
    $_SESSION['userFavs'] = $userFavs;
    echo $message;
} else {

    echo "User type not found in the session.";
}
