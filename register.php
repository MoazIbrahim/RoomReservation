<?php
session_start();
$conn = mysqli_connect('localhost', 'webadmin', '123456', 'webproject', 3308);

if (!$conn) {
  echo 'Connection failed: ' . mysqli_connect_error();
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first = $_POST['first'];
  $last = $_POST['last'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $type = $_POST['type'];

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (first, last, email, password, type, favoriteRooms, reservations) 
            VALUES ('$first', '$last', '$email', '$hashedPassword', '$type', '', '')";

  if (mysqli_query($conn, $sql)) {
    $_SESSION['userType'] = $type;
    $_SESSION['userFirst'] = $first;
    $_SESSION['userLast'] = $last;
    $_SESSION['userEmail'] = $email;
    $_SESSION['userId'] = mysqli_insert_id($conn);
    $_SESSION['userFavs'] = '';
    $_SESSION['userReservations'] = '';

    if ($type === 'client') {
      header("Location: AllRooms.php");
    } elseif ($type === 'admin') {
      header("Location: AllRooms.php");
    } else {
      echo 'Invalid user type.';
    }
    exit;
  } else {
    echo 'Error: ' . mysqli_error($conn);
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
  <link rel="icon" type="image/x-icon" href="source.png" />
  <title>Register</title>
</head>

<body>
  <div class="container vh-100 d-flex flex-column justify-content-center">
    <div class="row">
      <div class="col-6 offset-3 logincontainer">
        <div class="row mb-5">
          <div class="col-4 offset-4">
            <img class="text-center img-fluid" src="source.png" style="height: 200px; width: 200px; border-radius:50%;" alt="" />
          </div>
        </div>
        <form action="register.php" class="" method="POST">
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label" for="first">First Name </label>
                <input class="form-control" type="text" name="first" id="first" required />
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label" for="last">Last Name </label>
                <input class="form-control" type="text" name="last" id="last" required />
              </div>
            </div>
          </div>
          <hr />
          <div class="mb-3">
            <label class="form-label" for="email">Email </label>
            <input class="form-control" type="email" name="email" id="email" required />
          </div>

          <hr />

          <div class="mb-3">
            <label class="form-label" for="password">Password </label>
            <input class="form-control" type="password" name="password" id="password" required />
          </div>

          <hr />
          <div class="mb-3">
            <label class="form-label" for="type">Type</label>
            <select class="form-control" name="type" id="type" required>
              <option value="pls">Please select account type</option>
              <option value="client">Client</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <hr />

          <div class="mb-3">
            <a href="AllRooms.php"><button class="btn btn-success">Register</button></a>
            <span class="mx-3">
              Already have an account ? <a href="login.php">Login</a></span>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>