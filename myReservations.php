<?php
session_start();

if (!isset($_SESSION['userType'])) {
  header("Location: login.php");
  exit;
}

$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
  echo 'Connection failed: ' . mysqli_connect_error();
  exit;
}

$userId = $_SESSION['userId'];
$userType = $_SESSION['userType'];
$sql = "SELECT * FROM reservations WHERE userID = '$userId'";

$result = mysqli_query($conn, $sql);





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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/x-icon" href="source.png" />
  <title>Reservations</title>
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
    <div class="container d-flex flex-column min-vh-100 mt-3 ll">
      <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <?php $startTime = strtotime($row['startTime']); ?>
          <?php $endTime = strtotime($row['endTime']); ?>
          <?php $now = time(); ?>

          <?php if ($endTime < $now) {  ?>
            <h2 class="mb-3 title2 text-center">Past Reservation</h2>

            <div class="card my-3">
              <div class="row">
                <div class="col-md-1">
                  <img class="img-fluid" style="height: 100%" src="https://food.fnr.sndimg.com/content/dam/images/food/unsized/2014/6/23/0/fnd_Reserved-Sign-Thinkstock_s4x3.jpg" alt="" />
                </div>
                <div class="col-md-11 xd">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-8">
                        <h5 class="card-title"> <?php echo "Reservation ID: " . $row['id'] ?> </h5>
                        <p class="card-text">
                          <i class="fa-regular fa-calendar-days"></i> <?php echo date('Y-m-d H:i', strtotime($row['startTime'])) . '  ->  ' . date('Y-m-d H:i', strtotime($row['endTime'])); ?>

                        </p>
                        <p class="card-text">
                          <i class="fa-solid fa-circle-info"></i> <?php echo  $row['type'] ?>
                        </p>
                        <p class="card-text">
                          <i class="fa-solid fa-person mr-5"></i>
                          <span class="mr-2"> <?php echo  $row['attendees'] ?></span>
                        </p>
                        <p class="card-text">
                          <i class="fa-solid fa-note-sticky"></i> <?php echo  $row['notes'] ?>
                        </p>
                      </div>
                      <div class="col-4">
                        <form action="#">
                          <label class="form-label" for="feedback">Leave a Feedback</label>
                          <textarea name="feedback" class="form-control mb-2" id="feedback" cols="30" rows="5"></textarea>
                          <button class="btn btn-success">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php } else { ?>
            <h2 class="mb-3 title2 text-center">Future Reservation</h2>

            <div class="card my-3">
              <div class="row">
                <div class="col-md-1">
                  <img class="img-fluid" style="height: 100%" src="https://food.fnr.sndimg.com/content/dam/images/food/unsized/2014/6/23/0/fnd_Reserved-Sign-Thinkstock_s4x3.jpg" alt="" />
                </div>
                <div class="col-md-11 xd">
                  <div class="card-body">
                    <h5 class="card-title"> <?php echo "Reservation ID: " . $row['id'] ?> </h5>
                    <p class="card-text">
                      <i class="fa-regular fa-calendar-days"></i> <?php echo date('Y-m-d H:i', strtotime($row['startTime'])) . '  ->  ' . date('Y-m-d H:i', strtotime($row['endTime'])); ?>

                    </p>
                    <p class="card-text">
                      <i class="fa-solid fa-circle-info"></i> <?php echo  $row['type'] ?>
                    </p>
                    <p class="card-text">
                      <i class="fa-solid fa-person mr-5"></i>
                      <span class="mr-2"> <?php echo  $row['attendees'] ?></span>
                    </p>
                    <p class="card-text">
                      <i class="fa-solid fa-note-sticky"></i> <?php echo  $row['notes'] ?>
                    </p>
                    <form action="modifyReservation.php" method="POST" style="display:inline;">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <button class="btn btn-success" type="submit">Modify</button>
                    </form>
                    <form action="deleteReservation.php" method="POST" style="display:inline;">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
      <?php }
        }
      } ?>

      <hr />


    </div>

    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  </body>

</html>