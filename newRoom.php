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
  $name = $_POST['name'];
  $floor = $_POST['floor'];
  $description = $_POST['description'];
  $capacity = $_POST['capacity'];
  $image = $_POST['image'];

  $utilities = [];
  if (isset($_POST['desktop_computer'])) {
    $utilities[] = 'Desktop Computer';
  }
  if (isset($_POST['projector'])) {
    $utilities[] = 'Projector';
  }
  if (isset($_POST['microphone'])) {
    $utilities[] = 'Microphone';
  }
  if (isset($_POST['speakers'])) {
    $utilities[] = 'Speakers';
  }


  $utilitiesString = implode(',', $utilities);

  $sql = "INSERT INTO rooms (name, floor, description , capacity, image, utilities) 
            VALUES ('$name', '$floor', '$description' ,'$capacity', '$image', '$utilitiesString')";

  if (mysqli_query($conn, $sql)) {

    header("Location: AllRooms.php");
    exit;
  } else {
    echo 'Error: ' . mysqli_error($conn);
  }
}
if (!isset($_SESSION['userType'])) {
  header("Location: login.php");
  exit;
}
$userType = $_SESSION['userType'];



mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/x-icon" href="source.png" />

  <title>New Room</title>
</head>
<header>
  <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="source.png" width="50" height="50" style="border-radius: 50%;" alt="" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="AllRooms.php">Rooms</a>
          <?php if ($userType == 'client') { ?>
            <a class="nav-link" href="favoriteRooms.php">Favorites</a>
          <?php } ?>
          <?php if ($userType == 'client') { ?>
            <a class="nav-link" href="myReservations.php">Reservations</a>
          <?php } ?>
          <?php if ($userType == 'admin') { ?>
            <a class="nav-link" href="allReservations.php">Reservations</a>
          <?php } ?>
          <a class="nav-link" href="clientMessages.php">Messages</a>
          <a class="nav-link" href="profile.php">Profile</a>
        </div>
        <div class="navbar-nav ms-auto">
          <?php if ($userType) { ?>


            <form method="post">
              <button type="submit" name="logout" class="nav-link btn btn-link">Logout</button>
            </form>
          <?php } else { ?>
            <a class="nav-link" href="login.php">Login</a>
            <a class="nav-link" href="register.php">Register</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>

  <body>
    <div class="container vh-100 d-flex flex-column justify-content-center">
      <div class="row">
        <div class="col-6 offset-3 newformcontainer">
          <h1>Create a new room</h1>
          <form action="newRoom.php" method="POST">
            <div class="mb-3">
              <label class="form-label" for="name">Room Number : </label>
              <input class="form-control" type="text" name="name" id="name" required />
            </div>
            <hr />
            <div class="mb-3">
              <label class="form-label" for="floor">Floor : </label>
              <input class="form-control" type="number" name="floor" id="floor" required />
            </div>
            <hr />
            <div class="mb-3">
              <label class="form-label" for="floor">Capacity : </label>
              <input class="form-control" type="text" name="capacity" id="capacity" required />
            </div>
            <hr />
            <div class="mb-3">
              <label class="form-label" for="image">Image URL (Optional)
              </label>
              <input class="form-control" type="text" name="image" id="image" />
            </div>

            <hr />
            <div class="mb-3">
              <label class="form-label" for="description">Description: </label>
              <input class="form-control" type="text" name="description" id="description" required />
            </div>
            <hr />
            <label class="form-label" for="utilities">Utilities</label>
            <div class="form-group mb-3 d-flex flex-row">
              <div class="form-check mx-3">
                <input class="form-check-input" type="checkbox" value="Desktop computer" name="desktop_computer" id="desktop" />
                <label class="form-check-label" for="desktop">
                  Desktop Computer
                </label>
              </div>
              <div class="form-check mx-3">
                <input class="form-check-input" type="checkbox" value="Projector" name="projector" id="projector" />
                <label class="form-check-label" for="projector">
                  Projector
                </label>
              </div>
              <div class="form-check mx-3">
                <input class="form-check-input" type="checkbox" value="Microphone" name="microphone" id="microphone" />
                <label class="form-check-label" for="microphone">
                  Microphone
                </label>
              </div>
              <div class="form-check mx-3">
                <input class="form-check-input" type="checkbox" value="Speakers" name="speakers" id="speakers" />
                <label class="form-check-label" for="speakers">
                  Speakers
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-success">Add Room</button>
            </div>
          </form>
          <a class="btn btn-warning" href="AllRooms.php">Back to all Rooms</a>
        </div>
      </div>
    </div>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  </body>

</html>