<?php
include "db.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $birthday = $_POST['birthday'];

  $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password, birthday) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $fullname, $email, $username, $password, $birthday);

  if ($stmt->execute()) {
    $message = "Registration successful!";
    header("Location: users.php");
    exit;
  } else {
    $message = "Error: " . $stmt->error;
  }

  $stmt->close();
}
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registration Form</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous" />


  <link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="card" role="main" aria-labelledby="regTitle">
    <div class="header">
      <h2 id="regTitle">Register Your Account</h2>
      <p class="lead">Fill in your details and see yourself on our users list</p>
    </div>

    <?php if ($message) {
      echo "<div class='message'>$message</div>";
    } ?>

    <form action="" method="POST" novalidate>
      <label class="input-group" for="fullname">
        <span class="ico"><i class="fa-solid fa-id-badge"></i></span>
        <input id="fullname" name="fullname" type="text" placeholder="Full name" required />
      </label>

      <label class="input-group" for="email">
        <span class="ico"><i class="fa-solid fa-envelope"></i></span>
        <input id="email" name="email" type="email" placeholder="Email address" required />
      </label>

      <label class="input-group" for="username">
        <span class="ico"><i class="fa-solid fa-user"></i></span>
        <input id="username" name="username" type="text" placeholder="Username" required />
      </label>

      <label class="input-group" for="birthday">
        <span class="ico"><i class="fa-solid fa-calendar-days"></i></span>
        <input id="birthday" name="birthday" type="date" required />
      </label>

      <label class="input-group input-with-action" for="password">
        <span class="ico"><i class="fa-solid fa-lock"></i></span>
        <input id="password" name="password" type="password" placeholder="Password" required />
        <button type="button" class="show-pass" onclick="togglePassword()">
          <i id="eyeIcon" class="fa-regular fa-eye"></i>
        </button>
      </label>

      <button class="submit-btn" type="submit">REGISTER</button>
    </form>

    <div class="foot">Want to see registered users? <a href="users.php">View Users</a></div>
  </div>


  <script src="script.js"></script>
</body>

</html>