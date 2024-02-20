<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat</title>
  <link rel="stylesheet" href="/Css/message.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

  <link rel="icon" type="image/x-icon" href="source.png" ' />
  <link rel="stylesheet" href="style.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
          <a class="nav-link" href="favoriteRooms.php">Favorites</a>
          <a class="nav-link" href="myReservations.php">Reservations</a>
          <a class="nav-link" href="clientMessages.php">Messages</a>
          <a class="nav-link" href="profile.php">Profile</a>
        </div>
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="AllRooms.php">Admin</a>
          <a class="nav-link" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </nav>
</header>

<body>
  <div class="container px-1">
    <div class="chat-container">
      <div class="chat-header">
        <div class="participants">
          <ul>
            <li class="wow">
              <img class="profile-pic" src="anon.jpg" alt="Moaz" />
            </li>
            <li class="wow">
              <img class="profile-pic" src="source.png" style=' border-radius:50%;' alt="Admin" />
  </li>
  </ul>
  </div>
  <div class="call-buttons-xd">
    <button class="btn btn-primary mx-3 call-button">
      <i class="fa-solid fa-phone"></i>
    </button>
  </div>
  </div>

  <div class="chat-box">
    <div class="message sent">
      <p>
        Hello, can you please let me know when will you add new rooms ?
      </p>
      <button class="btn btn-sm btn-danger ms-auto" style="width: 5%">
        <i class="fa-solid fa-trash"></i>
      </button>
      <span class="time">11:30 AM</span>
    </div>
    <div class="message received">
      <p>
        Hello Moaz , We are working on it ! we just need to prepare the
        utilites and we will add multiple new rooms.
      </p>
      <button class="btn btn-sm btn-primary" style="width: 5%">
        <i class="fa-solid fa-reply"></i>
      </button>
      <span class="time">12:35 PM</span>
    </div>
    <div class="message sent">
      <p>thanks alot.</p>
      <button class="btn btn-sm btn-danger ms-auto" style="width: 5%">
        <i class="fa-solid fa-trash"></i>
      </button>
      <span class="time">01:15 PM</span>
    </div>
  </div>
  <div class="message-input">
    <input type="text" placeholder="Type your message here" />
    <button class="btn btn-success">Send</button>
  </div>
  </div>
  </div>
  </body>

</html>