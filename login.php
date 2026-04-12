<?php
session_start();
require_once 'db_config.php';

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $con = getDBConnection();

        $stmt = mysqli_prepare($con, "SELECT id, fullname, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId, $fullname, $hashedPassword);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        if ($userId && password_verify($password, $hashedPassword)) {
            // ✅ Login successful
            $_SESSION['user_id']   = $userId;
            $_SESSION['user_name'] = $fullname;
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect email or password. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – Pdf To Audio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }
    .auth-card {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 20px;
      padding: 45px 40px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.4);
      color: #fff;
    }
    .brand-logo {
      text-align: center;
      margin-bottom: 8px;
      font-size: 1.8rem;
      font-weight: 700;
      color: #1ae4c0;
      letter-spacing: 1px;
    }
    .auth-card h2 {
      text-align: center;
      font-size: 1.3rem;
      font-weight: 400;
      color: rgba(255,255,255,0.7);
      margin-bottom: 30px;
    }
    .form-label { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin-bottom: 5px; }
    .form-control {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: #fff;
      border-radius: 10px;
      padding: 12px 15px;
      transition: all 0.3s;
    }
    .form-control:focus {
      background: rgba(255,255,255,0.15);
      border-color: #1ae4c0;
      color: #fff;
      box-shadow: 0 0 0 3px rgba(26,228,192,0.2);
      outline: none;
    }
    .form-control::placeholder { color: rgba(255,255,255,0.4); }
    .password-toggle {
      cursor: pointer;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: rgba(255,255,255,0.6);
      border-radius: 0 10px 10px 0;
      padding: 0 14px;
    }
    .password-toggle:hover { color: #1ae4c0; }
    .btn-login {
      background: linear-gradient(135deg, #1ae4c0, #0ab89a);
      border: none;
      color: #000;
      font-weight: 600;
      padding: 13px;
      border-radius: 10px;
      width: 100%;
      font-size: 1rem;
      transition: all 0.3s;
      margin-top: 10px;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,228,192,0.4); }
    .divider { text-align: center; color: rgba(255,255,255,0.4); margin: 20px 0; position: relative; }
    .divider::before, .divider::after {
      content: ''; position: absolute; top: 50%; width: 40%; height: 1px;
      background: rgba(255,255,255,0.2);
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }
    .register-link { text-align: center; color: rgba(255,255,255,0.6); font-size: 0.9rem; }
    .register-link a { color: #1ae4c0; text-decoration: none; font-weight: 600; }
    .register-link a:hover { text-decoration: underline; }
    .forgot-link { text-align: right; margin-bottom: 5px; }
    .forgot-link a { color: rgba(255,255,255,0.5); font-size: 0.82rem; text-decoration: none; }
    .forgot-link a:hover { color: #1ae4c0; }
    .alert { border-radius: 10px; font-size: 0.9rem; }
  </style>
</head>
<body>

<div class="auth-card">
  <div class="brand-logo">🎧 Pdf To Audio</div>
  <h2>Welcome back! Please login</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php" novalidate>
    <!-- Email -->
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control"
             placeholder="Enter your email"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </div>

    <!-- Password -->
    <div class="mb-3">
      <div class="forgot-link"><a href="forgot_password.php">Forgot password?</a></div>
      <label class="form-label">Password</label>
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control"
               placeholder="Enter your password" required>
        <button type="button" class="password-toggle" onclick="togglePass()">
          <i class="bi bi-eye" id="eyeIcon"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn-login">
      <i class="bi bi-box-arrow-in-right me-2"></i>Login
    </button>
  </form>

  <div class="divider">or</div>
  <div class="register-link">
    Don't have an account? <a href="register.php">Register here</a>
  </div>
</div>

<script>
function togglePass() {
  const field = document.getElementById('password');
  const icon  = document.getElementById('eyeIcon');
  if (field.type === 'password') {
    field.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    field.type = 'password';
    icon.className = 'bi bi-eye';
  }
}
</script>
</body>
</html>
