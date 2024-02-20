<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
  echo 'Connection failed: ' . mysqli_connect_error();
  exit;
}
$emailError = $passwordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $storedPassword = $row['password'];
    $userType = $row['type'];
    $userFirst = $row['first'];
    $userLast = $row['last'];
    $userEmail = $row['email'];
    $userId = $row['id'];
    $userFavs = $row['favoriteRooms'];
    $userReservations = $row['reservations'];

    if (password_verify($password, $storedPassword)) {
      $_SESSION['userType'] = $userType;
      $_SESSION['userFirst'] = $userFirst;
      $_SESSION['userLast'] = $userLast;
      $_SESSION['userEmail'] = $userEmail;
      $_SESSION['userId'] = $userId;
      $_SESSION['userFavs'] = $userFavs;
      $_SESSION['userReservations'] = $userReservations;



      header("Location: AllRooms.php");
      exit;
    }
  }

  if (empty($email)) {
    $emailError = 'Email is required';
  }
  if (empty($password)) {
    $passwordError = 'Password is required';
  } else {
    $emailError = 'Invalid email or password.';
  }
}

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
  <link rel="icon" type="image/x-icon" href="source.png" ' />
  <title>Login</title>
</head>

<body>
  <div class="container vh-100 d-flex flex-column justify-content-center">
    <div class="row">
      <div class="col-6 offset-3 logincontainer">
        <div class="row">
          <div class="col-4 offset-4">
            <img class="text-center img-fluid" src="source.png" style="height: 200px; width: 200px; border-radius:50%;
            " alt="" />
          </div>
        </div>

        <form action="login.php" class="" method="POST">
          <div class="mb-3">
            <label class="form-label" for="Email">Email </label>
            <input class="form-control" type="email" name="email" id="email" required />
            <div class="text-danger"><?php echo $emailError; ?></div>
          </div>
          <hr />

          <div class="mb-3">
            <label class="form-label" for="password">Password </label>
            <input class="form-control" type="password" name="password" id="password" />
            <div class="text-danger"><?php echo $passwordError; ?></div>
          </div>

          <hr />

          <div class="mb-3">
            <button class="btn btn-success">Login</button>
            <span class="mx-3">
              Don' t have an account ? <a href="register.php">Register</a></span>
  </div>

  </form>
  </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  </body>

</html>