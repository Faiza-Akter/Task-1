<?php   
// Database connection
$host = "localhost";
$user = "root"; // default XAMPP username
$pass = "";     // default XAMPP password is empty
$db   = "registration_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $birthday = $_POST['birthday'];

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password, birthday) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $email, $username, $password, $birthday);

    if ($stmt->execute()) {
        $message = "Registration successful!";
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

  <!-- Google Font + icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

  <style>
    :root{
      --accent-1: #1b2733; /* Dark Navy */
      --accent-2: #60b36c; /* Fern Green */
      --accent-3: #033364; /* Steel Blue */
      --muted: #9aa4ad;
      --input-border: #eef2f6;
      --radius: 15px;
      --black: rgba(0,0,0,1);
    }

    * { box-sizing: border-box; }
    html,body { height: 100%; margin: 0; font-family: 'Poppins', Arial, sans-serif; }

    body {
        background-image: url('img1.jpg'); /* Replace with your image path */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: grid;
        place-items: center;
        padding: 28px;
        min-height: 100vh;
    }

    .card {
      width: 400px;
      max-width: calc(100% - 36px);
      background: rgba(255,255,255,0.15);
      border-radius: var(--radius);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      padding: 20px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,0.3);
      z-index: 1;
      backdrop-filter: blur(8px);
    }

    .header { text-align: center; margin-bottom: 8px; }
    h2 { margin:0; font-size:20px; color:#ffffff; font-weight:700; }
    p.lead { margin:4px 0 0 0; color:rgba(255,255,255,0.7); font-size:12px; }

    .message {
      display:flex; align-items:center; gap:10px;
      background: rgba(59,130,246,0.2);
      border:1px solid rgba(59,130,246,0.5);
      color:#60b36c;
      padding:8px 10px;
      border-radius:10px;
      margin:8px 0;
      font-size:13px;
      justify-content: center;
    }

    form { display:flex; flex-direction:column; gap:8px; }

    .input-group {
      display:flex;
      align-items:center;
      gap:10px;
      padding:8px 12px;
      background: rgba(255, 255, 255, 0.2);
      border-radius:10px;
      border:1px solid rgba(255,255,255,0.3);
      transition: all .18s ease;
    }

    .input-group:focus-within {
      border-color: #60b36c;
      box-shadow: 0 0 0 3px rgba(96,179,108,0.2);
      transform: translateY(-1px);
    }

    .input-group .ico {
      width:34px; height:34px;
      border-radius:8px;
      display:grid;
      place-items:center;
      background: rgba(255,255,255,0.2);
      color: var(--input-border);
      font-size:15px;
    }

    .input-group input {
      border:0; outline:none; font-size:14px;
      color:#ffffff; background:transparent;
      width:100%; padding: 5px 5px;
    }
    .input-group input::placeholder { color:var(--muted); }

    input[type="date"] {
      color: var(--muted);
    }
    input[type="date"]:valid {
      color: #ffffff;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
      filter: brightness(0) invert(0.95);
      cursor: pointer;
    }

    .input-with-action { position: relative; }
    .show-pass {
      border:0; background:transparent;
      cursor:pointer; font-size:13px;
      color: var(--input-border);
      padding:5px; border-radius:6px;
    }

    /* New gradient for register button */
    .submit-btn {
      display:block; width:100%; border:0;
      padding:10px 14px; border-radius:10px;
      font-size:15px; font-weight:700; color:white;
      cursor:pointer;
      background: linear-gradient(90deg, var(--accent-1), var(--accent-2), var(--accent-3));
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
    }
    .submit-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 12px 26px rgba(0,0,0,0.4);
    }
    .submit-btn:active { transform: translateY(0); }

    .foot { text-align:center; margin-top:8px; color:rgba(255,255,255,0.7); font-size:12px; }
    .foot a { color:#ffffff; text-decoration:none; font-weight:600; }

    @media (max-width:460px){
      .card { padding:14px; border-radius:10px; width: 92%; }
    }
  </style>
</head>
<body>
  <div class="card" role="main" aria-labelledby="regTitle">
    <div class="header">
      <h2 id="regTitle">Create An Account</h2>
      <p class="lead">Fast, secure signup to access your dashboard</p>
    </div>

    <?php if($message) { echo "<div class='message'>$message</div>"; } ?>

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

    <div class="foot">Already have an account? <a href="#">Log in</a></div>
  </div>

  <script>
    function togglePassword(){
      const pwd = document.getElementById('password');
      const eye = document.getElementById('eyeIcon');
      if(pwd.type === 'password'){
        pwd.type = 'text';
        eye.className = 'fa-regular fa-eye-slash';
      } else {
        pwd.type = 'password';
        eye.className = 'fa-regular fa-eye';
      }
    }

    const form = document.querySelector('form');
    form.addEventListener('submit', function(){
      const btn = form.querySelector('.submit-btn');
      btn.disabled = true;
      btn.style.opacity = 0.95;
      btn.textContent = 'Registering...';
    });
  </script>
</body>
</html>
