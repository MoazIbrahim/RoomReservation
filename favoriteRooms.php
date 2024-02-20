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
  if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
  }
}
$userType = null;
if (isset($_SESSION['userType'])) {
  $userType = $_SESSION['userType'];
  $userFavs = $_SESSION['userFavs'];
} else {
}
$userFavsArray = explode(',', $userFavs);
$favoriteRoomIds = implode(',', array_map('intval', $userFavsArray));
$sql = "SELECT * FROM rooms WHERE room_id IN ($favoriteRoomIds)";
$result = $conn->query($sql);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/x-icon" href="source.png" />
  <title>All Rooms</title>
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
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
      <div class="w-75 d-flex flex-row justify-content-between mb-3">
        <h3 class="mb-3 title2">Favorite Rooms</h3>
        <div class="text-center">
          <!-- Filter and Add Room code here -->
        </div>
      </div>
      <ul>
        <?php if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $roomId = $row['room_id'];
            $roomName = $row['name'];
            $roomDescription = $row['description'];
            $roomImage = $row['image'];
            $roomAvailability = $row['available'];
            $roomFeatures = $row['utilities'];
        ?>
            <div class="card mb-3 xd">
              <div class="row">
                <div class="col-md-4">
                  <img class="img-fluid" src="<?php echo $roomImage; ?>" alt="" style="width:700px;height:330px;" />
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $roomName; ?></h5>
                    <hr>
                    <p class="card-text"><?php echo $roomDescription; ?></p>
                    <hr>
                    <p class="card-text">
                      <small class="text-muted"><?php echo $roomFeatures; ?></small>
                    </p>
                    <?php if ($roomAvailability == '0') { ?>
                      <small class="text-danger px-3">Unavailable</small>
                      <button class="btn btn-success" disabled>Reserve</button>
                    <?php } else { ?>
                      <small class="text-success px-3">Available</small>
                      <a href="reserveRoom.php?id=<?php echo $roomId; ?>&roomName=<?php echo urlencode($roomName); ?>"><button class="btn btn-success">Reserve</button></a>
                    <?php } ?>
                    <?php if ($userType === "admin") { ?>
                      <div class="dropdown" style="display:inline; margin-left:50px;">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="availabilityDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Status
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="availabilityDropdown">
                          <li><a class="dropdown-item" href="#" data-roomid="<?php echo $roomId; ?>" data-status="1">Available</a></li>
                          <li><a class="dropdown-item" href="#" data-roomid="<?php echo $roomId; ?>" data-status="0">Unavailable</a></li>
                        </ul>
                      </div>
                    <?php }  ?>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<h1>You have no favorite rooms.</h1>";
        }
        ?>
      </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  </body>

</html>