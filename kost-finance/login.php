<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - FUNDORA</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff3e6, #ffe5d0);
      height: 100vh;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    /* BUBBLES */
    .bubble {
      position: absolute;
      border-radius: 50%;
      opacity: 0.25;
      animation: float 8s infinite ease-in-out;
      z-index: 0;
    }

    .bubble1 { width: 120px; height: 120px; background: #f28500; top: 10%; left: 5%; animation-delay: 0s; }
    .bubble2 { width: 100px; height: 100px; background: #ffbb66; bottom: 10%; right: 10%; animation-delay: 1s; }
    .bubble3 { width: 90px; height: 90px; background: #ffd1a3; top: 35%; left: 0%; animation-delay: 2s; }
    .bubble4 { width: 80px; height: 80px; background: #ffe0b3; bottom: 30%; right: 5%; animation-delay: 3s; }
    .bubble5 { width: 130px; height: 130px; background: #f28500; top: 50%; left: 30%; animation-delay: 4s; }
    .bubble6 { width: 100px; height: 100px; background: #ffcc99; bottom: 50%; right: 25%; animation-delay: 5s; }
    .bubble7 { width: 70px; height: 70px; background: #f5b66e; top: 15%; right: 20%; animation-delay: 6s; }
    .bubble8 { width: 150px; height: 150px; background: #ffd9b3; bottom: 10%; left: 20%; animation-delay: 7s; }
    .bubble9 { width: 100px; height: 100px; background: #ffc180; top: 5%; right: 5%; animation-delay: 8s; }
    .bubble10 { width: 120px; height: 120px; background: #ffe0b3; bottom: 5%; left: 10%; animation-delay: 9s; }

    @keyframes float {
      0%   { transform: translateY(0); }
      50%  { transform: translateY(-20px); }
      100% { transform: translateY(0); }
    }

    /* LOGIN FORM */
    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 360px;
      z-index: 2;
      text-align: center;
      position: relative;
    }

    h2 {
      margin-bottom: 10px;
      color: #f28500;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 2px solid #ffe0b3;
      border-radius: 10px;
      font-size: 14px;
      background-color: #fffaf5;
    }

    button {
      background-color: #f28500;
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #db7300;
    }

    .error {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- Bubbles -->
  <div class="bubble bubble1"></div>
  <div class="bubble bubble2"></div>
  <div class="bubble bubble3"></div>
  <div class="bubble bubble4"></div>
  <div class="bubble bubble5"></div>
  <div class="bubble bubble6"></div>
  <div class="bubble bubble7"></div>
  <div class="bubble bubble8"></div>
  <div class="bubble bubble9"></div>
  <div class="bubble bubble10"></div>

  <!-- Login Form -->
  <div class="login-container">
    <h2>Masuk ke <span style="color:#f28500;">FUNDORA</span></h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Masuk</button>
    </form>
    <?php if ($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
  </div>

</body>
</html>
