<?php
session_start();

$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
  echo 'Connection failed: ' . mysqli_connect_error();
  exit;
}

if (!isset($_SESSION['userType'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
  } else {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $type = $_POST['type'];
    $attendees = $_POST['attendees'];
    $notes = $_POST['notes'];


    $sql = "INSERT INTO reservations (userId, roomName, startTime, endTime, type, attendees, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssis", $_SESSION['userId'], $_POST['roomName'], $start, $end, $type, $attendees, $notes);

    if (mysqli_stmt_execute($stmt)) {
      header("Location: myReservations.php");
    } else {
      echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  }
}

$roomName = isset($_GET['roomName']) ? $_GET['roomName'] : '';
$userType = $_SESSION['userType'];
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
  <title>Reserve Room</title>
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
          <?php if ($_SESSION['userType'] == 'client') { ?>
            <a class="nav-link" href="favoriteRooms.php">Favorites</a>
          <?php } ?>
          <?php if ($_SESSION['userType'] == 'client') { ?>
            <a class="nav-link" href="myReservations.php">Reservations</a>
          <?php } ?>
          <?php if ($_SESSION['userType'] == 'admin') { ?>
            <a class="nav-link" href="allReservations.php">Reservations</a>
          <?php } ?>
          <a class="nav-link" href="clientMessages.php">Messages</a>
          <a class="nav-link" href="profile.php">Profile</a>
        </div>
        <div class="navbar-nav ms-auto">
          <?php if ($_SESSION['userType']) { ?>
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
</header>

<body>
  <div class="container vh-100 d-flex flex-column justify-content-center">
    <div class="row">
      <div class="col-6 offset-3 newformcontainer">
        <h1><?php echo htmlentities($roomName); ?></h1>
        <form action="reserveRoom.php" method="POST">
          <div class="mb-3">
            <div class="row">
              <div class="col-6">
                <label class="form-label" for="start">From</label>
                <input class="form-control" type="datetime-local" name="start" id="start" />
              </div>
              <div class="col-6">
                <label class="form-label" for="end">To</label>
                <input class="form-control" type="datetime-local" name="end" id="end" />
              </div>
            </div>
          </div>
          <hr />
          <div class="mb-3">
            <label class="form-label" for="type">Reservation Type</label>
            <select class="form-control" name="type" id="type">
              <option value="none">Please select reservation type</option>
              <option value="meeting">Meeting</option>
              <option value="exam">Exam</option>
              <option value="classroom">Classroom</option>
            </select>
          </div>
          <hr />
          <div class="mb-3">
            <label class="form-label" for="attendees">Number of Attendees : </label>
            <input class="form-control" type="number" name="attendees" id="attendees" />
          </div>
          <hr />
          <div class="mb-3">
            <label class="form-label" for="notes">Additional Notes </label>
            <textarea class="form-control" name="notes" id="notes" cols="30" rows="10"></textarea>
          </div>
          <hr />
          <div class="mb-3">
            <button onclick="alert('A Confirmation email has been sent to your email address please check your email ! ')" class="btn btn-success">
              Reserve
            </button>
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