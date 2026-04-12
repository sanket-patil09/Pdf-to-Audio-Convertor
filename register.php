<?php
session_start();
require_once 'db_config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname  = trim($_POST['fullname'] ?? '');
    $email     = trim($_POST['email']    ?? '');
    $password  = $_POST['password']      ?? '';
    $confirm   = $_POST['confirm']       ?? '';

    // --- Validation ---
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $con = getDBConnection();

        // Check if email already exists
        $checkStmt = mysqli_prepare($con, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($checkStmt, "s", $email);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $error = "This email is already registered. Please <a href='login.php'>login</a>.";
        } else {
            // Hash password securely
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $stmt = mysqli_prepare($con, "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $hashed);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Registration successful! <a href='login.php'>Click here to login</a>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register – Pdf To Audio</title>
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
      max-width: 480px;
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
    .input-group-text {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: rgba(255,255,255,0.6);
      border-radius: 10px 0 0 10px;
    }
    .btn-register {
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
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,228,192,0.4); }
    .divider { text-align: center; color: rgba(255,255,255,0.4); margin: 20px 0; position: relative; }
    .divider::before, .divider::after {
      content: ''; position: absolute; top: 50%; width: 40%; height: 1px;
      background: rgba(255,255,255,0.2);
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }
    .login-link { text-align: center; color: rgba(255,255,255,0.6); font-size: 0.9rem; }
    .login-link a { color: #1ae4c0; text-decoration: none; font-weight: 600; }
    .login-link a:hover { text-decoration: underline; }
    .alert { border-radius: 10px; font-size: 0.9rem; }
    .password-toggle { cursor: pointer; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.6); border-radius: 0 10px 10px 0; padding: 0 14px; }
    .password-toggle:hover { color: #1ae4c0; }
    .password-strength { height: 4px; border-radius: 2px; margin-top: 6px; transition: all 0.3s; }
  </style>
</head>
<body>

<div class="auth-card">
  <div class="brand-logo">🎧 Pdf To Audio</div>
  <h2>Create your account</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST" action="register.php" novalidate>
    <!-- Full Name -->
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="fullname" class="form-control"
             placeholder="Enter your full name"
             value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control"
             placeholder="Enter your email"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control"
               placeholder="Min. 6 characters" required oninput="checkStrength(this.value)">
        <button type="button" class="password-toggle" onclick="togglePass('password','eyePass')">
          <i class="bi bi-eye" id="eyePass"></i>
        </button>
      </div>
      <div class="password-strength" id="strengthBar" style="background:#444; width:0;"></div>
      <small id="strengthText" style="color:rgba(255,255,255,0.5); font-size:0.78rem;"></small>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <div class="input-group">
        <input type="password" name="confirm" id="confirm" class="form-control"
               placeholder="Re-enter your password" required>
        <button type="button" class="password-toggle" onclick="togglePass('confirm','eyeConfirm')">
          <i class="bi bi-eye" id="eyeConfirm"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn-register">
      <i class="bi bi-person-plus-fill me-2"></i>Create Account
    </button>
  </form>

  <div class="divider">or</div>
  <div class="login-link">
    Already have an account? <a href="login.php">Login here</a>
  </div>
</div>

<script>
function togglePass(fieldId, iconId) {
  const field = document.getElementById(fieldId);
  const icon  = document.getElementById(iconId);
  if (field.type === 'password') {
    field.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    field.type = 'password';
    icon.className = 'bi bi-eye';
  }
}

function checkStrength(val) {
  const bar  = document.getElementById('strengthBar');
  const text = document.getElementById('strengthText');
  let strength = 0;
  if (val.length >= 6) strength++;
  if (val.length >= 10) strength++;
  if (/[A-Z]/.test(val)) strength++;
  if (/[0-9]/.test(val)) strength++;
  if (/[^A-Za-z0-9]/.test(val)) strength++;

  const levels = [
    {w:'20%', bg:'#e74c3c', t:'Very Weak'},
    {w:'40%', bg:'#e67e22', t:'Weak'},
    {w:'60%', bg:'#f1c40f', t:'Fair'},
    {w:'80%', bg:'#2ecc71', t:'Strong'},
    {w:'100%',bg:'#1ae4c0', t:'Very Strong'}
  ];
  const lvl = levels[strength - 1] || {w:'0', bg:'#444', t:''};
  bar.style.width = lvl.w;
  bar.style.background = lvl.bg;
  text.textContent = lvl.t;
  text.style.color = lvl.bg;
}
</script>
</body>
</html>
